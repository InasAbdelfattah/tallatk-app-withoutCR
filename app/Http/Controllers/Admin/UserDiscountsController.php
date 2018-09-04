<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserDiscount;
use App\UserInvitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Auth;

use App\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;


class UserDiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('contact_manage')) {
            return abort(401);
        }

        $users = User::orderBy('id','desc')->get();
        
        return view('admin.discounts.index' , compact('users'));
    }

    public function show($id){

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $user = User::find($id);
        $discounts = UserDiscount::where('user_id',$id)->get();

        return view('admin.discounts.show' , compact('discounts' , 'user'));

    }
    
    public function searchDiscount(Request $request){
        // $rules = [
        //     //'day'      => 'string|required|min:3|max:3',
        //     //'day'      => 'date_format:"D"|required',
        //     'from'     => 'date_format:"Y-m-d"|required',
        //     'to'       => 'date_format:"Y-m-d"|required|after:from',
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {

        //     return redirect()->back()->with('error',$validator->errors()->first());
        // }
        
        $discounts = [];
        
        if($request->from <= $request->to){
            $discounts = UserDiscount::whereDate('created_at','>=',$request->from)->whereDate('created_at','<=',$request->to)->get();
        }else{
                //return 'fail';
                return back()->with('error','يرجى ادخال فترة زمنية صحيحة');
            }
        
        return view('admin.discounts.discounts' , compact('discounts'));
    }

    public function addDiscount(Request $request){
        
        //dd($request);
        if (!Gate::allows('contact_manage')) {
            return abort(401);
        }

        $user = User::find($request->userId);

        // $rules = [
        //     'discount' => 'required',
        //     'from_date' => 'required',
        //     'to_date' => 'required',
        //     'maxOrders' => 'required',
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {

        //     $error_arr = validateRules($validator->errors(), $rules);
        //     return response()->json(['status'=>false,'message' => $validator->errors()->all()]);
        
        // }
        
        if ($request->discount < 0 || $request->maxOrders < 0) {
            return response()->json([
                'status' => false,
                'message' => 'نسبة الخصم وعدد الطلبات يجب ان تكون ارقاما اكبر من الصفر',
            ]);
        }

        if ($request->discount == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة الخصم',
            ]);
        }

        if ($request->maxOrders == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كابة اقصى عدد للطلبات المتاح للمستخدم الاستفادة منها للخصم',
            ]);
        }

        if ($request->from_date == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة تاريخ بداية الاستفادة من الخصم',
            ]);
        }

        if ($request->to_date == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة تاريخ نهاية الاستفادة من الخصم',
            ]);
        }

        if ($request->to_date < $request->from_date) {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة فترة زمنية صحيحة',
            ]);
        }

        if ($user) {

            $model = new UserDiscount();

            $model->user_id = $request->userId ;
            $model->created_by = Auth::user()->id;
            $model->registered_users_no = $request->invitedCounts ;
            $model->discount = $request->discount ;
            $model->max_orders = $request->maxOrders ;
            $model->from_date = $request->from_date ;
            $model->to_date = $request->to_date ;
            
            if($request->is_reset != null):
                $model->is_reset = 1 ;
               // $invited_users = 0 ;
            else:
                $model->is_reset = 0;
                //$invited_users = $model->registered_users_no ;
            endif;
            
            $invited_users = countInvited($request->userId);
            if ($model->save()) {
                $discount_no = UserDiscount::where('user_id' , $request->userId)->count();
                
                
                
                $title = 'تم اضافة خصم';
                $msg = 'تم اضافة خصم بنسبة'.$request->discount.'صالح فى الفترة من'.$model->from_date .'الى'.$model->to_date.'وكود الخصم هو '.$model->id.'اقصى عدد طلبات مسموح استخدام كود الخصم فيه هو : '.$model->max_orders;
                
                $not = $this->sendSingleNotification($title , $msg , $request->userId,
                'user_discount');
                
                return response()->json([
                    'status' => true,
                    'message' => 'تم الحفظ',
                    'id' => $model->id,
                    'discount_no' => $discount_no ,
                    'invited_users' => $invited_users
                ]);
            }
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }

    public function userDiscounts(){

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }
        
        $discounts = UserDiscount::join('users','user_discounts.user_id','users.id')->select('user_discounts.*' , 'users.id as user_id' , 'users.name as username' , 'users.phone as user_phone')->groupBy('user_discounts.user_id')->orderBY('user_discounts.id','desc')->get();

        return view('admin.discounts.discounts' , compact('discounts'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $models = UserDiscount::where('user_id',$request->user_id)->get();

        foreach ($models as $model) {
            $model->delete();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);

    }


    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function groupDelete(Request $request)
    {

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $user = UserDiscount::findOrFail($id);
            $user->delete();
        }


        return response()->json([
            'status' => true,
        ]);
    }
    
    private function sendSingleNotification($title , $msg , $user_id ,$notif_type){

        $device = \App\Device::where('user_id',$user_id)->orderBy('id','Desc')->first();
        if($device):
            $token = $device->device;
        else:
            $token = '';
        endif;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder('طلتك');
        $notificationBuilder->setBody($msg)
            ->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        
        $dataBuilder->addData(['message' => $msg , 'title'=>$title ,'type' =>$notif_type]);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $notif = new Notification();
        $notif->msg = $msg;
        $notif->title = $title;
        $notif->image = '';
        $notif->to_user = $user_id;
        $notif->type = 'single';
        $notif->notif_type = $notif_type;
        $notif->save();
        
        if($token != ''){
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();
            //return Array - you must remove all this tokens in your database
            $downstreamResponse->tokensToDelete();
            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $downstreamResponse->tokensToModify();
            //return Array - you should try to resend the message to the tokens in the array
            $downstreamResponse->tokensToRetry();
            // return Array (key:token, value:errror) - in production you should remove from your database the tokens
            
            return true;
        }
        
        return false;
    }
    
    public function activateProvider(Request $request)
    {

        $model = User::findOrFail($request->id);
        //dd($request);

        if ($model) {

            if($model->is_active != $request->is_active) {
                if ($request->is_active == 1) {
                    $msg = 'تم تفعيل مزود الخدمة';
                } else {

                    // if ($model->districts->count() > 0) {
                    //     return response()->json([
                    //         'status' => false,
                    //         'message' => "عفواً, لا يمكنك تعطيل المنطقة الرئيسية ($model->name_ar) نظراً لوجود مناطق فرعية ملتحقة بها "
                    //     ]);
                    // }

                    $msg = 'تم تعطيل مزود الخدمة';
                }
                $model->status = $request->status;
                if ($model->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => $msg,
                        'id' => $model->id
                    ]);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'لم يحدث تغيير',
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => 'فشل',
            ]);
        }
    }


    
}
