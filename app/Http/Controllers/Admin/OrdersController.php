<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Order;
use App\Category;
use App\Rate;
use App\OrderService;
use App\FinancialAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username')->orderBy('id','Desc')->get();
        
        $cats = Category::all();
        $type = 0;

        return view('admin.orders.index' , compact('orders' , 'cats' , 'type'));
    }

    public function search(Request $request)
    {
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $orders = [] ;
        if($request->from != '' && $request->to != ''){
            if($request->from < $request->to){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->whereDate('orders.created_at','>',$request->from)->whereDate('orders.created_at','<',$request->to)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username')->get();
            }else{
                //return 'fail';
                return back()->with('error','يرجى ادخال فترة زمنية صحيحة');
            }
        }elseif ($request->service_type != '' && $request->service_provider == '') {
            
            $serviceType = Category::find($request->service_type);
            if($serviceType){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('orders.service_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get(); 
            }

        }elseif ($request->service_type == '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like','%'.$request->service_provider.'%')->first();
            
            if($serviceProvider){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('companies.user_id',$serviceProvider->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get(); 
            }

        }elseif ($request->service_type != '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like',$request->service_provider)->first();
            $serviceType = Category::where('name_ar','like',$request->service_type)->first();
            if($serviceType && $serviceProvider){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('companies.user_id',$serviceProvider->id)->where('orders.service_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get(); 
            }
        }else{

            return back()->with(compact('orders'))->with('fail','من فضلك يرجى كتابة اسم مزود الخدمة أو اختيار نوع الخدمة');

        }
        $type = 1;
        return view('admin.orders.index' , compact('orders' , 'type'));

    }

    public function show($id){
        //return $id;
        $order = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('orders.id',$id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username')->first();
        if($order):
            $order->orderServices = OrderService::where('order_id',$id)->get();
        else:
            $order->orderServices = null;
        endif;
        $user_rate = Rate::where('order_id',$id)->where('rate_from','user')->first();
        
        $provider_rate = Rate::where('order_id',$id)->where('rate_from','provider')->first();
        
        return view('admin.orders.show' , compact('order','user_rate','provider_rate'));
    }

    public function getFinancialReports()
    {
        //status = 3 when order is finished
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        // $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('orders.status',1)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc', 'services.serviceType_id as serviceType')->orderBy('id','desc')->get();
        
        $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('orders.status',1)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username')->orderBy('id','desc')->get();
        
        $type = 0 ;
        return view('admin.orders.reports' , compact('orders' , 'type'));
    }

    public function searchFinancialReports(Request $request)
    {
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $orders = [] ;
        //dd($request);
        if($request->from != '' && $request->to != ''){
            if($request->from <= $request->to){
                // $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->whereDate('orders.created_at','>=',$request->from)->whereDate('orders.created_at','<=',$request->to)->where('orders.status',1)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc', 'services.serviceType_id as serviceType')->get();
                
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->whereDate('orders.created_at','>=',$request->from)->whereDate('orders.created_at','<=',$request->to)->where('orders.status',1)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username')->get();
            }else{
                //return 'fail';
                return back()->with('error','يرجى ادخال فترة زمنية صحيحة');
            }
        }elseif ($request->service_type != '' && $request->service_provider == '') {
            
            // $serviceType = Category::where('name_ar','like','%'.$request->service_type.'%')->first();
            
            $serviceType = Category::find($request->service_type);
            
            if($serviceType){
                // $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('services.serviceType_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc' , 'services.serviceType_id as serviceType')->get();
                
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('orders.service_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get();
            }

        }elseif ($request->service_type == '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like','%'.$request->service_provider.'%')->first();
            
            if($serviceProvider){
                // $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('companies.user_id',$serviceProvider->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc' , 'services.serviceType_id as serviceType')->get(); 
                
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('companies.user_id',$serviceProvider->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get(); 
            }

        }elseif ($request->service_type != '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like',$request->service_provider)->first();
            $serviceType = Category::where('name_ar','like',$request->service_type)->first();
            if($serviceType && $serviceProvider){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->where('companies.user_id',$serviceProvider->id)->where('orders.service_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' )->get(); 
            }
        }else{

            return back()->with(compact('orders'))->with('error','من فضلك يرجى كتابة اسم مزود الخدمة أو اختيار نوع الخدمة');
        }
        
        $type = 1 ;
        return view('admin.orders.reports' , compact('orders' ,'type'));

    }

    public function getFinancialAccounts()
    {
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $accounts = FinancialAccount::join('companies','financial_accounts.company_id','companies.id')->select('financial_accounts.*' , 'companies.id as company_id' , 'companies.name as company_name' , 'companies.user_id as provider_id')->get();
        
        $type = 0 ;

        return view('admin.orders.accounts' , compact('accounts' , 'type'));
    }

    public function confirmPayment(Request $request){

        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $finance = FinancialAccount::find($request->accountId);
        if($finance->net_app_ratio == 0){
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد مستحقات ',
            ]);
        }

        if ($request->is_confirmed == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك قم باختيار حالة الدفع   ',
            ]);
        }

        if ($finance) {

            $finance->is_confirmed = $request->is_confirmed ;
            $finance->pay_status = 1 ;
        
            if($request ->is_confirmed == 1){
                $finance->net_app_ratio = $finance->net_app_ratio - $finance->last_transfered_money ;
                $finance->remain = $finance->net_app_ratio - $finance->last_transfered_money ; 
                if($finance->remain < 0):
                    $finance->remain = 0;
                endif;
                $finance->paid = $finance->paid + $finance->last_transfered_money ;
               // $finance->net_app_ratio = $finance->net_app_ratio - $finance->paid ;
                
                
                
            }elseif($request->is_confirmed == 2){

                if($request->paid != ''){
                    $finance->remain = $finance->net_app_ratio - $request->paid  ;
                    if($finance->remain < 0):
                        $finance->remain = 0;
                    endif;
                    $finance->net_app_ratio = $finance->net_app_ratio - $request->paid ;
                    $finance->paid = $finance->paid + $request->paid ;
                    
                    // if($finance->remain <=0):
                    //     $finance->net_app_ratio = $finance->net_app_ratio - $finance->paid ; ;
                    // endif;

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'لا بد من كتابة المبلغ الذى تم تحصيله',
                    ]);
                }
            }
            
             
            if ($finance->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'تم الحفظ',
                    'id' => $finance->id,
                    'paid' => $finance->paid ,
                    'remain' =>$finance->remain,
                    'appRatio' =>$finance->net_app_ratio

                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }

    public function searchFinancialAccounts( Request $request)
    {
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }
        
        $accounts = [];
        
        if($request->from != '' && $request->to != ''){
            if($request->from <= $request->to){
                // $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->whereDate('orders.created_at','>',$request->from)->whereDate('orders.created_at','<',$request->to)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.category_id as serviceType' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc')->get();
                
                $accounts = FinancialAccount::join('companies','financial_accounts.company_id','companies.id')->whereDate('financial_accounts.created_at','>=',$request->from)->whereDate('financial_accounts.created_at','<=',$request->to)->select('financial_accounts.*' , 'companies.id as company_id' , 'companies.name as company_name' , 'companies.user_id as provider_id')->get();
            }else{
                //return 'fail';
                return back()->with('error','يرجى ادخال فترة زمنية صحيحة');
            }
        }else{

            return back()->with(compact('orders'))->with('error','يرجى اختيار فترة زمنية');
        }
        
        $type = 1 ;
        return view('admin.orders.accounts' , ['accounts'=>$accounts , 'type' =>$type]);
        
    }

    public function delete(Request $request){
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }
        
        $model = Order::findOrFail($request->id);

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }
    
    public function groupDelete(Request $request){
        if (!Gate::allows('orders_manage')) {
            return abort(401);
        }

        $ids = $request->ids;

        $arrsCannotDelete = [];
        foreach ($ids as $id) {
            $model = Order::findOrFail($id);

            // if ($model->centers->count() > 0) {
            //     $arrsCannotDelete[] = $model->name;
            // } else {
            //     $model->delete();
            // }
            
            $model->delete();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ],
            'message' => $arrsCannotDelete
        ]);
    }
}
