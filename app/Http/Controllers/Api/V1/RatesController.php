<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\User;
use App\Rate;
use App\Order;
use App\Setting;
use App\FinancialAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use willvincent\Rateable\Rating;

use App\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class RatesController extends Controller
{
    public function __construct()
    {
        app()->setlocale(request('lang'));
        $this->public_path = 'files/pays/';

    }
    
    public function postRating(Request $request)
    {
        $user = User::byToken($request->api_token);

        $validator = Validator::make($request->all(), [
            //'centerId' => 'required',
            'orderId' => 'required',
            //'userId' => 'required',
            'rateValue' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ]);
        }

        if ($request->api_token) {

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                    'data' => []
                ]);
            }
            $order = Order::find($request->orderId);
            if(!$order){
                return response()->json([
                    'status' => false,
                    'message' => 'orderNotFound',
                    'data' => []
                ]);
            }

            $company = Company::where('id',$order->company_id)->first();
            if(!$company){
                return response()->json([
                    'status' => false,
                    'message' => 'centerNotFound',
                    'data' => []
                ]);
            }
            
            
            $userRatingBefore = Rate::where('company_id', $request->centerId)->where('user_id', $user->id)->where('order_id', $request->orderId)->first();

            if ($userRatingBefore) {
                $userRatingBefore->rate = $request->rateValue;
                $userRatingBefore->price = $request->price;
                $userRatingBefore->comment = $request->comment;
                if($user->is_provider == 1 && $user->id == $company->user_id){
                    $rating->rate_from = 'provider';
                }else{
                    $rating->rate_from = 'user' ;
                }
                $userRatingBefore->save();

                return response()->json([
                    'status' => true,
                    'message' => 'the user ' . $user->name . ' updated the rate.',
                    'data' => $request->rateValue,
                    'rate' => $company->rates()->avg('rate')
                ]);
            }

            $rating = new Rate;
            $rating->rate = $request->rateValue;
            $rating->price = $request->price;
            $rating->order_id = $request->orderId;
            $rating->company_id = $company->id;
            $rating->user_id = $user->id;
            $rating->comment = $request->comment;
            if($user->is_provider == 1 && $user->id == $company->user_id){
                $rating->rate_from = 'provider';
            }else{
                $rating->rate_from = 'user' ;
            }

            $rating->save();
            
            
            
        
        //$usr = User::find($newModel->user_id);
        // if($usr){
        //     Sms::sendActivationCode($msg , $usr->phone);
        // }
            
            $finished_order1 = Rate::where('order_id' , $order->id)->where('company_id',$company->id)->where('user_id',$order->user_id)->where('rate_from','user')->first();
            
            $finished_order2 = Rate::where('order_id' , $order->id)->where('company_id',$company->id)->where('user_id',$order->provider_id)->where('rate_from','provider')->first();
            
            if($finished_order2):
                $order->app_ratio = Setting::getBody('commission') * $finished_order2->price /100;
                $order->save();
            endif;
            
            if( $finished_order1  && $finished_order2){
                $order->status = 1;
                $order->save();
                
                $orders = Order::where('company_id',$company->id)->where('status',1)->get();
                if(count($orders) > 0){
                    $model = FinancialAccount::where('company_id',$company->id)->first();
                    $appRatio = 0;
                    foreach($orders as $order){

                        $appRatio += $order->app_ratio;
                    };
                
                    //$appRatio = Setting::getBody('commission') * $profit /100;
                
                
                    if(!$model){
                        $newModel = new FinancialAccount();
                        $newModel->company_id = $company->id;
                        $newModel->orders_count = $orders->count();
                        $newModel->net_app_ratio = $appRatio;
                        $newModel->transfered_money = '';
                        $newModel->last_transfered_money = '';
                        $newModel->pay_status = 0;
                        $newModel->pay_doc = '';
                        $newModel->paid = 0;
                        $newModel->remain = 0;
                        $newModel->is_confirmed = 0;
                        $newModel->save();
    
                    }else{
                        $model->orders_count = $orders->count();
                        $model->net_app_ratio = $appRatio;
                        //$model->net_app_ratio = $appRatio - $model->net_app_ratio;
                        $model->pay_status = 0;
                        $model->save();
                    }
                }
            
            }
            
            if(app()->getlocale() == 'ar'):
            
                
                $msg = " تم تأكيد إنهاء الحجز رقم " .$request->orderId. " من قبل " . ($rating->rate_from == 'provider'?'مزود الخدمة':'المستخدم')."";
                
            else:
                // $title = 'order confirmation';
                $msg = "order ". $request->orderId. " has been finished from ".($rating->rate_from == 'provider' ? 'provider':'user') ."";
            endif;
            
            if($rating->rate_from == 'provider'){
                $userId = $order->user_id;
                $title = User::find($company->user_id) ? User::find($company->user_id)->name : '';
            }else{
                $userId = $company->user_id; 
                
                $title = User::find($order->user_id) ? User::find($order->user_id)->name : '';
            }
            
            //$title = $user->name;
            
            $order_status = $order->status == 1 ? 1 : 2 ;
            
            $this->sendSingleNotification($title , $msg , $userId ,'confirm_order' ,$order_status ,$order->id);
            

            // $userCurrent = User::whereId($request->user_id)->whereIsActive(1)->first();
            // $userCurrent->notify(new \App\Notifications\AddRateForAgentNotification($user->averageRating));
            return response()->json([
                'status' => true,
                'message' => 'you rated successfully.',
                'data' => $request->rateValue,
                'rate' => $company->rates()->avg('rate')
            ]);

        }
    }
    
     public function saveRating(Request $request)
    {
        $user = User::byToken($request->api_token);

        $validator = Validator::make($request->all(), [
            'centerId' => 'required',
            'rateValue' => 'required',
        ]);
        

        if ($validator->fails()) {
            
            $rules = [
                'centerId' => 'required',
                'rateValue' => 'required',
            ];
        
            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
//            return response()->json([
//                'status' => false,
//                'data' => $validator->errors()
//            ]);
        }

        if ($request->api_token) {

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                    'data' => []
                ]);
            }

            $company = Company::where('id',$request->centerId)->first();
            if(!$company){
                return response()->json([
                    'status' => false,
                    'message' => 'center not found',
                    'data' => []
                ]);
            }

            $userRatingBefore = Rate::where('company_id', $request->centerId)->where('user_id', $user->id)->where('type', 0)->first();

            if ($userRatingBefore) {
                $userRatingBefore->rate = $request->rateValue;
                $userRatingBefore->save();

                return response()->json([
                    'status' => true,
                    'message' => 'the user ' . $user->name . ' updated the rate.',
                    'data' => $request->rateValue,
                    'rate' => $company->rates()->avg('rate') ? $company->rates()->avg('rate') : 0
                ]);
            }

            $rating = new Rate;
            $rating->rate = $request->rateValue;
            $rating->price = '';
            $rating->order_id = 0;
            $rating->company_id = $request->centerId;
            $rating->user_id = $user->id;
            $rating->rate_from = '';
            $rating->type = 0 ;
            }

            $rating->save();

            // $userCurrent = User::whereId($request->user_id)->whereIsActive(1)->first();
            // $userCurrent->notify(new \App\Notifications\AddRateForAgentNotification($user->averageRating));
            return response()->json([
                'status' => true,
                'message' => 'you rated successfully.',
                'data' => $request->rateValue,
                'rate' => $company->rates()->avg('rate')
            ]);

        }
        
        private function sendSingleNotification($title , $msg , $user_id ,$notif_type , $order_status , $target){

        $device = \App\Device::where('user_id',$user_id)->orderBy('id','Desc')->first();
        
        if($device):
            $token = $device->device;
        else:
            $token = '';
        endif;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($msg)
            ->setSound('default');
        $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['message' => $msg , 'title'=>$title ,'type' =>$notif_type , 'order_starus'=>$order_status]);
        
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $notif = new Notification();
        $notif->msg = $msg;
        $notif->title = $title;
        $notif->image = '';
        $notif->to_user = $user_id;
        $notif->target_id = $target;
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
    


}
