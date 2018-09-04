<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use \App\Device;
use App\Http\Helpers\Main;
use Sms;
use App\Setting;
use App\Order;
use App\City;
use App\Company;
use App\CompanyWorkDay;

class LoginController extends Controller
{

    public $main;
    public $public_path_user;
    public $public_path_docs;

    public function __construct(Main $main)
    {

        $this->main = $main;
        $this->public_path_user = 'files/users/';
        $this->public_path_docs = 'files/docs/';
        
        app()->setlocale(request('lang'));
    }


    public function login(Request $request)
    {

        $locale = app()->getlocale() ;
        
        $rules = [
            'phone' => 'required|regex:/(05)[0-9]{8}/',
            'password' => 'required|min:3|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

        $user = User::where('phone',$request->phone)->where('is_user',1)->first();
        
        if($user){
            if($user->image != ''):
             $user->photo = $request->root() . '/' . $this->public_path_user . $user->image ;
            endif;
        }
        
        if($user):
        $user->user_city = City::where('id',$user->city)->first();
        if($user->user_city):
            $user->user_city->name = $user->user_city->{'name:'.$locale};
        endif;
        endif;
         
         
        if ($user && $user->is_provider == 1) {
            $user->center = $user->company()->with('city')->first();
            $user->center->name = $user->company->{'name:'.app()->getlocale()};
            $user->center->description = $user->company->{'description:'.app()->getlocale()};
            // if($center->document_photo != ''){
            //     $user->center->doc_photo= $request->root() . '/' . $this->public_path_docs .'/' . $center->document_photo ;
            // }
        }
            
        

        if ($user) {
            if (!$user->is_active)
                return response()->json([
                    'status' => 401,
                    'message' => 'accountnotactivated.',
                    'data' => $user
                ], 401);
        } else {
            if($locale == 'ar'):
                $msg = 'عفواً, الرقم غير الذى ادخلته غير صحيح';
            else:
                $msg = 'phone is incorrect';
            endif;
            return response()->json([
                'status' => false,
                'message' => $msg,
                'data' => $msg
            ], 404);
        }

        if ($user = Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'is_active' => 1])) {

            if (!auth()->user()->api_token) {
                auth()->user()->api_token = str_random(60);
                auth()->user()->save();
            }



            $this->manageDevices($request, auth()->user());
            //$this->makeUserOnline(auth()->user());

            $user = auth()->user();
            if($user->image != ''){
                $user->photo = $request->root() . '/' . $this->public_path_user . $user->image ;
            }

            if ($user->is_provider == 1) {
                $user->center = $user->company()->with('city')->first();

                $center = Company::where('user_id',$user->id)->first();
                if($center->document_photo != ''){
                    $user->center->doc_photo= $request->root() . '/' . $this->public_path_docs . $center->document_photo ;
                }
        
                //$reports = [];
                if($center){
                    
                    $workDays = CompanyWorkDay::where('company_id', $center->id)
                        ->select('id','day','from','to','company_id as centerId')->get();

                    if($workDays->count() > 0){
                        if($locale == 'ar'){
                            $workDays->map(function ($q) {
                                $q->name = day($q->day);
                            });
                        }else{
                            $workDays->map(function ($q) {
                                $q->name = dayEn($q->day);
                            });
                        }
                    }
                    
                    $user->workDays = $workDays ;
                
                    $totalOrders = Order::where('company_id', $center->id)->where('status',1)->get();
    
                    $totalProfit = 0 ;
                    
                    if(count($totalOrders) > 0){
                    
                        foreach($totalOrders as $order){
            
                            $totalProfit += $order->price;
                        };
                    
                    }
                    $totalAppRatio = Setting::getBody('commission') * $totalProfit /100;
            
            
                    $orders = Order::where('company_id', $center->id)->where('status',1)->get();
            
                    $profit = 0 ;
                    
                    if(count($orders) > 0){
            
                        foreach($orders as $order){
            
                            $profit += $order->price;
                        };
                    }
            
                    $appRatio = Setting::getBody('commission') * $profit /100;
            
                    $ordersCount = $orders->count();
                    
                    $reports = ['ordersCount' => $ordersCount , 'totlalProfit' => $profit , 'totalAppRatio' => $totalAppRatio ] ;
                    
                $user->reports = $reports;
                    
                }

                // return response()->json([
                //     'status' => true,
                //     'data' => $user
                // ], 200);
                //$user->categories = $this->getCategoryForCompany((int)$user->companies->category_id);
            }
            
           
            $user->user_city = City::where('id',$user->city)->first();
            
            if($user->user_city):
                $user->user_city->name = $user->user_city->{'name:'.$locale};
            endif;
            
            return response()->json([
                'status' => true,
                'data' => $user,
                
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'phoneorpasswordisincorrect',
                'data' => null
            ], 400);
        }
    
    }


    private function getCategoryForCompany($id)
    {
        $category = Category::with('parent')->whereId($id)->first();

        return $category;
    }


    public function postActivationCode(Request $request)
    {
        $locale = app()->getlocale() ;
        
        $rules = [
            'phone' => 'required|regex:/(05)[0-9]{8}/',
            'activation_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $user = User::where(['phone' => $request->phone,
            'action_code' => $request->activation_code])
            ->first();
        
                    
        if ($user && $user->is_active == 0) {
            $user->is_active = 1;
            $user->update();
            
            if($user && $user->image != ''){
            $user->photo= $request->root() . '/' . $this->public_path_user .'/' . $user->image ;
        }
        

        if ($user && $user->is_provider == 1) {
                $center = Company::where('user_id',$user->id)->first();
                $user->center = $user->company()->with('city')->first();
        
                $reports = [];
                if($center){
                    $user->center->name = $user->company->{'name:'.app()->getlocale()};
                    
                    $user->center->description = $user->company->{'description:'.app()->getlocale()};
                    
                    if($center->document_photo != ''){
                        $user->center->doc_photo= $request->root() . '/' . $this->public_path_docs . $center->document_photo ;
                    }
                    
                    $workDays = CompanyWorkDay::where('company_id', $center->id)
                        ->select('id','day','from','to','company_id as centerId')->get();

                    if($workDays->count() > 0){
                        if($locale == 'ar'){
                            $workDays->map(function ($q) {
                                $q->name = day($q->day);
                            });
                        }else{
                            $workDays->map(function ($q) {
                                $q->name = dayEn($q->day);
                            });
                        }
                    }
                    
                    $user->workDays = $workDays ;
                
                    $totalOrders = Order::where('company_id', $center->id)->where('status',1)->get();
    
                    $totalProfit = 0 ;
                    
                    if(count($totalOrders) > 0){
                    
                        foreach($totalOrders as $order){
            
                            $totalProfit += $order->price;
                        };
                    
                    }
                    $totalAppRatio = Setting::getBody('commission') * $totalProfit /100;
            
            
                    $orders = Order::where('company_id', $center->id)->where('status',1)->get();
            
                    $profit = 0 ;
                    
                    if(count($orders) > 0){
            
                        foreach($orders as $order){
            
                            $profit += $order->price;
                        };
                    }
            
                    $appRatio = Setting::getBody('commission') * $profit /100;
            
                    $ordersCount = $orders->count();
                    
                    $reports = ['ordersCount' => $ordersCount , 'totlalProfit' => $profit , 'totalAppRatio' => $totalAppRatio ] ;
                    
                    $user->reports = $reports;
                    
                }

            }


            $this->manageDevices($request, $user);
           // $this->makeUserOnline($user);

            return response()->json([
                'status' => true,
                'message' => 'activationcodecodecorrect',
                'data' => $user
            ]);


        } elseif ($user && $user->is_active == 1) {
            
            if($user && $user->image != ''){
            $user->photo= $request->root() . '/' . $this->public_path_user .'/' . $user->image ;
        }
        

        if ($user && $user->is_provider == 1) {
                $center = Company::where('user_id',$user->id)->first();
                $user->center = $user->company()->with('city')->first();
        
                $reports = [];
                if($center){
                    $user->center->name = $user->company->{'name:'.app()->getlocale()};
                    
                    $user->center->description = $user->company->{'description:'.app()->getlocale()};
                    
                    if($center->document_photo != ''){
                        $user->center->doc_photo= $request->root() . '/' . $this->public_path_docs . $center->document_photo ;
                    }
                    
                    $workDays = CompanyWorkDay::where('company_id', $center->id)
                        ->select('id','day','from','to','company_id as centerId')->get();

                    if($workDays->count() > 0){
                        if($locale == 'ar'){
                            $workDays->map(function ($q) {
                                $q->name = day($q->day);
                            });
                        }else{
                            $workDays->map(function ($q) {
                                $q->name = dayEn($q->day);
                            });
                        }
                    }
                    
                    $user->workDays = $workDays ;
                
                    $totalOrders = Order::where('company_id', $center->id)->where('status',1)->get();
    
                    $totalProfit = 0 ;
                    
                    if(count($totalOrders) > 0){
                    
                        foreach($totalOrders as $order){
            
                            $totalProfit += $order->price;
                        };
                    
                    }
                    $totalAppRatio = Setting::getBody('commission') * $totalProfit /100;
            
            
                    $orders = Order::where('company_id', $center->id)->where('status',1)->get();
            
                    $profit = 0 ;
                    
                    if(count($orders) > 0){
            
                        foreach($orders as $order){
            
                            $profit += $order->price;
                        };
                    }
            
                    $appRatio = Setting::getBody('commission') * $profit /100;
            
                    $ordersCount = $totalOrders->count();
                    
                    $reports = ['ordersCount' => $ordersCount , 'totlalProfit' => $profit , 'totalAppRatio' => $totalAppRatio];
                    
                    $user->reports = $reports;
                    
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'activatedbefore',
                'data' => $user
            ], 400);
        } else {
            
            if($user && $user->image != ''){
            $user->photo= $request->root() . '/' . $this->public_path_user .'/' . $user->image ;
        }
        

        if ($user && $user->is_provider == 1) {
                $center = Company::where('user_id',$user->id)->first();
                $user->center = $user->company()->with('city')->first();
        
                $reports = [];
                if($center){
                    $user->center->name = $user->company->{'name:'.app()->getlocale()};
                    
                    $user->center->description = $user->company->{'description:'.app()->getlocale()};
                    
                    if($center->document_photo != ''){
                        $user->center->doc_photo= $request->root() . '/' . $this->public_path_docs . $center->document_photo ;
                    }
                    
                    $workDays = CompanyWorkDay::where('company_id', $center->id)
                        ->select('id','day','from','to','company_id as centerId')->get();

                    if($workDays->count() > 0){
                        if($locale == 'ar'){
                            $workDays->map(function ($q) {
                                $q->name = day($q->day);
                            });
                        }else{
                            $workDays->map(function ($q) {
                                $q->name = dayEn($q->day);
                            });
                        }
                    }
                    
                    $user->workDays = $workDays ;
                
                    $totalOrders = Order::where('company_id', $center->id)->where('status',1)->get();
    
                    $totalProfit = 0 ;
                    
                    if(count($totalOrders) > 0){
                    
                        foreach($totalOrders as $order){
            
                            $totalProfit += $order->price;
                        };
                    
                    }
                    $totalAppRatio = Setting::getBody('commission') * $totalProfit /100;
            
            
                    $orders = Order::where('company_id', $center->id)->where('status',1)->get();
            
                    $profit = 0 ;
                    
                    if(count($orders) > 0){
            
                        foreach($orders as $order){
            
                            $profit += $order->price;
                        };
                    }
            
                    $appRatio = Setting::getBody('commission') * $profit /100;
            
                    $ordersCount = $orders->count();
                    
                    $reports = ['ordersCount' => $ordersCount , 'totlalProfit' => $profit , 'totalAppRatio' => $totalAppRatio ] ;
                    
                    $user->reports = $reports;
                    
                }

            }


            return response()->json([
                'status' => 'false',
                'message' => 'activationcodeisincorrect',
                'data' => $user
            ]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @@ Resend Activation Code.
     */

    public function resendActivationCode(Request $request)
    {

        $rules = [
            'phone' => 'required|regex:/(05)[0-9]{8}/',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $user = User::where('phone',$request->phone)->first();
        if ($user) {
            $code = rand(1000, 9999);
            $activation_code = $user->actionCode($code);
            $user->action_code = $activation_code;
            if ($user->save()) {
                
                $phone = filter_mobile_number($user->phone);
                
                //$s = Sms::sendActivationCode('activation code:'.$user->action_code , $phone);
                
                $s = sendActivationCode('activation code:'.$user->action_code , $phone);

                return response()->json([
                    'status' => true,
                    'message' => 'the activation code has been sent successfully.',
                    'code' => $user->action_code,
                    's' => $s,
                    'phone' => $phone ,
                    'uphone' => $user->phone
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'accountnotfound'
            ], 400);
        }

    }


    /**
     * @param $user
     * @return mixed
     * @make User online Over All Application.
     */


    private function makeUserOnline($user)
    {
        $user->is_online = 1;
        return $user->save();
    }


    /**
     * @param $request
     * @@ User Device Management
     */
    private function manageDevices($request, $user = null)
    {

        if ($request->playerId) {
            //$devices = Device::where('device',$request->playerId)->toArray();
            
            $devices = Device::where('device',$request->playerId)->where('user_id',$user->id)->first();
            
            
            if ( !$devices) {
                $device = new Device;
                $device->device = $request->playerId;
                $device->user_id = $user->id;
                $device->save();
            }
            
            
            // if (in_array($request->playerId, $devices)) {
            //     $device = Device::where('device',$request->playerId)->first();
            //     $device->user_id = $user->id;
            //     $device->save();
            // }else {
            //     $device = new Device;
            //     $device->device = $request->playerId;
            //     $device->user_id = $user->id;
            //     $device->save();
            //     //$user->devices()->save($device);
            // }
        }
    }
}
