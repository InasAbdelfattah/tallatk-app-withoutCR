<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\City;
use App\User;
use App\Company;
use App\Setting;
use UploadImage;

class HomeController extends Controller
{
    public $public_path;
    public $public_path_docs ;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->public_path = 'files/companies/';
        $this->public_path_docs = 'files/docs/';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $cities->map(function ($q) {
            $q->name = $q->{'name:ar'};
        });
        return view('home',compact('cities'));
    }
    
    public function getTerms(){
        //$settings = Setting::all();
        return view('terms');
    }
    
     public function store(Request $request)
    {
        //dd($request);
        
        $rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/(05)[0-9]{8}/|unique:users,phone',
            'password' => 'required|confirmed',
            'userType' => 'required',
            'city' => 'required|integer',
            'providerType' => 'required',
            'document_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
            
            // $error_arr = validateRules($validator->errors(), $rules);
            // return response()->json(['status'=>false,'data' => $error_arr , 'message'=>'يرجى استكمال البيانات والتأكد من ادخال محتوى صالح']);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

            $user = new User();

            $user->gender = $request->gender ? $request->gender : 'male';
            $user->is_invited = $request->is_invited ? $request->is_invited : 0 ;
            $user->name = $request->name;
            $user->email = $request->email ? $request->email : '';
            $user->phone = trim($request->phone);
            $user->password = trim($request->password);
            $user->api_token = str_random(60);
            $code = rand(1000, 9999);
            $code = $user->userCode($code);
            $user->code = $code;
            $user->is_user = 1;
            $user->is_provider = 1;
            $actionCode = rand(1000, 9999);
            $actionCode = $user->actionCode($actionCode);
            $user->action_code = $actionCode;
            $user->address = $request->address ? $request->address : '';
            $user->lat = $request->lat ? $request->lat : '';
            $user->lng = $request->lng ? $request->lng : '';
            $user->save();

            $access_token = $user->createToken($request->name)->accessToken;

            $company = new Company;
            $company->user_id = $user->id;
            //$company->name = $request->name;
            $company->nameAr = '';
            $company->city_id = $request->city;
            $company->type = $request->providerType;

            if ($request->hasFile('document_photo')):
                $company->document_photo = UploadImage::uploadImage($request, 'document_photo', $this->public_path_docs);
            endif;
            $company->is_comment = 1;
            $company->is_rate = 1;
            $company->phone = '';
            $company->place = '';
            $company->facebook = '';
            $company->twitter = '';
            $company->google = '';
            $company->is_agree = 0;
            $company->is_active = 0;

            $company->address = $request->address ? $request->address : '';
            $company->lat = $request->lat ? $request->lat : '';
            $company->lng = $request->lng ? $request->lng : '';
            

            if ($request->has('image')):

                $company->image = UploadImage::uploadImage($request, 'image', $this->public_path);

            endif;

            if ($company->save()) {

                // $message = "لديك طلب إلتحاق مركز جديد للتطبيق ($company->{'name:ar'})";
                // $users = User::whereHas('roles', function ($q) {
                //     $q->where('name', 'owner');
                // })->get();

//                    event(new NotifyUsers($users, $company, $message, 0));

                // foreach ($users as $user) {
                //     event(new NotifyAdminJoinApp($user->id, $company->id, $message, 0));
                //     $user->notify(new NotifyAdminForJoinCompanies($user->id, $company->id, $message, 0));
                // }
                
             return redirect()->back()->with('success','تم التسجيل بنجاح. سيتم مراجعة البيانات من خلال مدير التطبيق');
            }
            
            return redirect()->back()->with('fail','يرجى المحاولة مرة اخرى');
    }
}
