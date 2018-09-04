<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use UploadImage;
use Image;
use Validator;

use App\Order;
use App\City;
use App\Company;
use App\Service;
use App\CompanyWorkDay;
use App\Category;

use App\Notification;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class UsersController extends Controller
{
    public $public_path;
    public $public_path_comp;
    public $public_path_docs ;
    public $public_service_path ;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->public_path = 'files/users/';
        $this->public_path_comp = 'files/companies/';
        $this->public_path_docs = 'files/docs/';
        $this->public_service_path = 'files/companies/services/';
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('admin_manage')) {
            return abort(401);
        }
        
        $users = User::with('roles')->where('is_user',0)->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('admin_manage')) {
            return abort(401);
        }

        $roles = Role::get();

        $roles = $roles->reject(function ($q) {
            return $q->name == 'owner';
        });

//        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  StoreUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        
        if (!Gate::allows('admin_manage')) {
            return abort(401);
        }

            $user = new User;
           
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->api_token = str_random(60);
            $user->remember_token = csrf_token();
            $user->password = bcrypt(trim($request->password));

            $user->gender = 'male';
            $user->is_invited = 0;
            $user->is_active = $request->is_active ? $request->is_active : 0;
            $user->is_suspend = 0;
            $user->is_online = 0;
            $user->is_user = 0;
            $user->address = $request->address;


            /**
             * @ Store Image With Image Intervention.
             */

            if ($request->hasFile('image')):
                $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            endif;


            $code = rand(10000000, 99999999);
            $code = $user->userCode($code);
            $user->code = $code;
            $user->action_code = $code;

            $user->save();

            if($request->has('roles') && count($request->roles) > 0 ){
                foreach ($request->input('roles') as $role) {
                    $user->assign($role);
                }
            }


          //  session()->flash('success', 'لقد تم إضافة المستخدم بنجاح.');

            return redirect()->route('users.index')->with('success', 'لقد تم إضافة المستخدم بنجاح.');

    }

    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('admin_manage')) {
            return abort(401);
        }
        $roles = Role::get();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'roles'));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        if (!Gate::allows('admin_manage')) {
            return abort(401);
        }
//      $roles = Role::get()->pluck('name', 'name');
        $roles = Role::get();
        $roles = $roles->reject(function ($q) {
            return $q->name == 'owner';
        });
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    public function editUser($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
//      $roles = Role::get()->pluck('name', 'name');
        $roles = Role::get();
        $roles = $roles->reject(function ($q) {
            return $q->name == 'owner';
        });
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUsersRequest $request, $id)
    {
        // if (!Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        $user = User::findOrFail($id);

        //$user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->is_active = $request->is_active;
        $user->is_suspend = $request->is_suspend;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // $user->lat = $request->lat;
        // $user->lng = $request->lng;
        $user->address = $request->address;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):

            $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            if (isset($request->oldImage) && $request->oldImage != '') {
                $regularPath = str_replace($request->root() . '/', '', $request->oldImage);
                //dd($regularPath);
                if (\File::exists(public_path($regularPath))):
                    \File::delete(public_path($regularPath));
                endif;
    
            }

        endif;

        $user->save();

        if(count($user->roles) > 0 ){
            foreach ($user->roles as $role) {
                $user->retract($role);
            }
        }

        if($request->has('roles') && count($request->roles) > 0 ){
            foreach ($request->input('roles') as $role) {
                $user->assign($role);
            }
    }   

       // session()->flash('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");

        // return redirect()->route('users.index')->with('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");
        return redirect()->back()->with('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");
    }

    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        
        $orders = Order::where('user_id',$user->id)->orWhere('provider_id',$user->id)->where('status',0)->get();
            
        if(count($orders) > 0){
            
            return response()->json([
                'status' => false,
                'message' => 'لا يمكنك حذف المستخدم لوجود طلبات سارية خاصة به',
            ]);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index');
    }


    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
// $user = User::findOrFail($request->id);
//         $orders = Order::where('user_id',$user->id)->orWhere('provider_id',$user->id)->where('status',0)->get();
        
//         dd(count($orders));
//         if (!Gate::allows('users_manage')) {
//             return abort(401);
//         }
        
        
        $user = User::findOrFail($request->id);
        
        $orders = Order::where('user_id',$user->id)->orWhere('provider_id',$user->id)->where('status',0)->get();
            
        if(count($orders) > 0){
            
            return response()->json([
                'status' => false,
                'message' => 'لا يمكنك حذف المستخدم لوجود طلبات سارية خاصة به',
            ]);
        }
        
        $userId = $user->id ;
        
        
        
        $title = 'ادارة التطبيق';
        $msg = 'تم حذف حسابك من قبل ادارة التطبيق';
        
        $this->sendSingleNotification($title , $msg , $userId,
                'user_delete'); 
                
        $user->delete();
        
               
        

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

        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $ids = $request->ids;
        foreach ($ids as $id) {
            $user = User::findOrFail($id);
            $user->delete();
        }


        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);
    }


    public function groupSuspend(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }


        $ids = $request->ids;
        $suspended_users = [];
        foreach ($ids as $id) {
            $user = User::findOrFail($id);

            if($user->is_suspend == 1){

                //array_push($suspended_users, $user->id);
                return response()->json([
                'status' => false,
                'message' => 'يوجد مستخدمين محظورين من قبل',
            ]);
            }

            $user->is_suspend = 1 ;

            $user->save();
        }

        if(count($suspended_users) > 0){

            return response()->json([
                'status' => false,
                'message' => 'يوجد مستخدمين محظورين من قبل',
            ]);
        }
        

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->ids
            ]
        ]);


    }


    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    function filter(Request $request)
    {

        $name = $request->keyName;

        $page = $request->pageSize;

        ## GET ALL CATEGORIES PARENTS
        $query = User::with('roles')->select();
        // $categories = Category::paginate($pageSize);


        if ($name != '') {
            $query->where('name', 'like', "%$name%");
        }

        $query->orderBy('created_at', 'DESC');
        $users = $query->paginate(($page) ?: 10);

        if ($name != '') {
            $users->setPath('users?name=' . $name);
        } else {
            $users->setPath('users');
        }


        if ($request->ajax()) {
            return view('admin.users.load', ['users' => $users])->render();
        }
        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.users.index')
            ->with(compact('users'));
    }

     /**
     * Display a list of providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewProvidersRequests()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        
        //is_approved = [0 => new , 1 => approved , 2 => rejected]
        $providers = User::join('companies','users.id','companies.user_id')->where('users.is_user',1)->where('users.is_provider',1)->where('users.is_approved',0)->select('users.*','companies.id as company_id' , 'companies.nameAr as company_name')->orderBy('id','DESC')->get();
        
        //dd($providers);
        
        return view('admin.users.providers_orders', compact('providers'));
    }

    /**
     * Display a list of providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProviders()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $users = User::join('companies','users.id','companies.user_id')->where('users.is_user',1)->where('users.is_provider',1)->where('users.is_approved',1)->select('users.*','companies.id as company_id' , 'companies.name as company_name')->orderBy('users.id','desc')->get();
        
        return view('admin.users.providers', compact('users'));
    }

    /**
     * Display a listing of app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $users = User::where('is_user',1)->where('is_provider',0)->orderBy('id','desc')->get();
        
        return view('admin.users.users', compact('users'));
    }

    public function activation(Request $request)
    {

        if ($request->agree == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك قم باختيار او رفض مزود الخدمة    ',
            ]);
        }

        if ($request->agree == 2 && $request->reason == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك ادخل سبب الرفض  ',
            ]);
       }

        $provider = User::find($request->providerId);
        if ($provider) {

            $provider->is_approved = $request->agree;
            $provider->reject_reason = $request->reason ? $request->reason : '';

            // send activation code to provider here
            if($request->agree == 1){
                $msg = 'تم قبول مزود الخدمة' ;
            }else{
                $msg = 'تم رفض مزود الخدمة';
            }
            if ($provider->save()) {
                return response()->json([
                    'status' => true,
                    'message' => $msg,
                    'id' => $provider->id
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }
    
    public function editProfile($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        return view('admin.users.profile_edit', compact('user'));
    }
    
    public function profile($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(StoreUsersRequest $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $user = User::findOrFail($id);

        //$user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        //$user->is_active = $request->is_active;
        //$user->is_suspend = $request->is_suspend;

        if ($request->password) {
            $user->password = trim($request->password);
        }

        // $user->lat = $request->lat;
        // $user->lng = $request->lng;
        $user->address = $request->address;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):

            $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            if (isset($request->oldImage) && $request->oldImage != '') {
                $regularPath = str_replace($request->root() . '/', '', $request->oldImage);
                //dd($regularPath);
                if (\File::exists(public_path($regularPath))):
                    \File::delete(public_path($regularPath));
                endif;
    
            }

        endif;

        $user->save();
        
       // session()->flash('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
    
    public function createProvider(){
        
        $cities = City::all();
        $services = Service::all();
        $services->map(function ($q) {
             $q->name= $q->{'name:ar'}; 
         });
        return view('admin.users.create_provider',compact('cities' ,'services'));
    }
    public function storeProvider(Request $request)
    {
        //dd($request);
        
        $rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/(05)[0-9]{8}/|unique:users,phone',
            'password' => 'required|confirmed',
            'city' => 'required|integer',
            'providerType' => 'required',
            'document_photo' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput();
            
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
            $user->city = $request->city;
            $user->address = $request->address ? $request->address : '';
            $user->lat = $request->lat ? $request->lat : '';
            $user->lng = $request->lng ? $request->lng : '';
            $user->is_active = 1;
            $user->is_approved = 1;
            
            if ($request->hasFile('image')):
                $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            endif;
            
            $user->save();

            $access_token = $user->createToken($request->name)->accessToken;
//`name`, `user_id`, `nameAr`, `is_comment`, `category_id`, `phone`, `place`, `type`, `document_photo`, `is_rate`, `description`, `city_id`, `district_id`, `address`, `facebook`, `twitter`, `google`, `lat`, `lng`, `is_agree`, `is_active`, `created_at`, `updated_at`, `image`, `visits_count`
            $company = new Company;
            $company->user_id = $user->id;
            //$company->name = $request->name;
            $company->nameAr = $request->name;
            $company->{'name:ar'} = $request->name_ar;
            $company->{'name:en'} = $request->name_en;
            $company->{'description:ar'} = $request->description_ar;
            $company->{'description:en'} = $request->description_en;
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
            $company->district_id = 0;
            $company->visits_count = 0;

            $company->address = $request->address ? $request->address : '';
            $company->lat = $request->lat ? $request->lat : '';
            $company->lng = $request->lng ? $request->lng : '';
            

            if ($request->has('image')):

                $company->image = UploadImage::uploadImage($request, 'image', $this->public_path_comp);

            endif;
            
            if($request->has('workDays')){
                $days = json_decode($request->workDays);
                //dd($days);
                if(count($days) > 0){
                    $old_days = CompanyWorkDay::where('company_id',$company->id)->get();
                        if(count($old_days) > 0){
                            foreach($old_days as $old){
                                $old->delete();
                            }
                        }
                    foreach($days as $day){
                        $model = new CompanyWorkDay;
                        $model->company_id = $company->id;
                        $model->day = $day->day;
                        $model->from = $day->from;
                        $model->to = $day->to;
                        $model->save();
                    }
                }
            }
            
            if($request->has('services')){
                //$days = json_decode($request->workDays);
                //dd($days);
                if(count($services) > 0){
                    foreach($services as $day){
                        $model = new Service;
                        $model->company_id = $company->id;
                        $model->day = $day->day;
                        $model->from = $day->from;
                        $model->to = $day->to;
                        $model->save();
                    }
                }
            }

            if ($company->save()) {

             return redirect()->route('users.app_providers')->with('success','تم التسجيل بنجاح');
            }
            
            return redirect()->back()->with('error','يرجى المحاولة مرة اخرى');
    }
    
     public function editProvider($id){
        
        $user = User::find($id);
        $services = Service::all();
        $services->map(function ($q) {
             $q->name= $q->{'name:ar'}; 
         });
         
        $categories = Category::select('id','name_ar as name')->whereParentId(0)->get();
        
        if($user):
            $company = Company::where('user_id',$user->id)->first();
        else:
            $company = null;
        endif;
        
        $cities = City::all();
        $services->map(function ($q) {
             $q->name= $q->{'name:ar'}; 
         });
        return view('admin.users.edit_provider',compact('cities' ,'services' , 'user' ,'company' , 'categories'));
    }
    
    public function updateProvider(Request $request , $id)
    {
        //dd($request);
        
        $user = User::find($id);
        
        if($user):
            $company = Company::where('user_id',$user->id)->first();
        else:
            $company = null;
        endif;
        
        $rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/(05)[0-9]{8}/|unique:users,phone,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,

            'password' => 'confirmed',
            'city' => 'required|integer',
            'providerType' => 'required',
            'document_photo' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput();
            
            // $error_arr = validateRules($validator->errors(), $rules);
            // return response()->json(['status'=>false,'data' => $error_arr , 'message'=>'يرجى استكمال البيانات والتأكد من ادخال محتوى صالح']);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

            $user = User::find($id);

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
            $user->is_active = 1;
            $user->is_approved = 1;
            
            if ($request->hasFile('image')):
                $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            endif;
            
            $user->save();

            $access_token = $user->createToken($request->name)->accessToken;
            if($company){
                $company->user_id = $user->id;
                //$company->name = $request->name;
                $company->nameAr = $request->name;
                $company->{'name:ar'} = $request->name_ar;
                $company->{'name:en'} = $request->name_en;
                $company->{'description:ar'} = $request->description_ar;
                $company->{'description:en'} = $request->description_en;
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
                $company->district_id = 0;
                $company->visits_count = 0;
    
                $company->address = $request->address ? $request->address : '';
                $company->lat = $request->lat ? $request->lat : '';
                $company->lng = $request->lng ? $request->lng : '';
            

                if ($request->has('image')):
    
                    $company->image = UploadImage::uploadImage($request, 'image', $this->public_path_comp);
    
                endif;
            
                if($request->has('workDays')){
                    $days = json_decode($request->workDays);
                    //dd($days);
                    if(count($days) > 0){
                        $old_days = CompanyWorkDay::where('company_id',$company->id)->get();
                            if(count($old_days) > 0){
                                foreach($old_days as $old){
                                    $old->delete();
                                }
                            }
                        foreach($days as $day){
                            $model = new CompanyWorkDay;
                            $model->company_id = $company->id;
                            $model->day = $day->day;
                            $model->from = $day->from;
                            $model->to = $day->to;
                            $model->save();
                        }
                    }
                }
                
                if($request->has('services')){
                    //$days = json_decode($request->workDays);
                    //dd($days);
                    if(count($services) > 0){
                        foreach($services as $day){
                            $model = new Service;
                            $model->company_id = $company->id;
                            $model->day = $day->day;
                            $model->from = $day->from;
                            $model->to = $day->to;
                            $model->save();
                        }
                    }
                }
                
                $company->save();
                
            }    
            return redirect()->route('users.app_providers')->with('success','تم الحفظ بنجاح');
            //return redirect()->back()->with('error','');
    }
    
    
    public function saveService(Request $request)
    {

        /**
         * @ GET company...
         */
        $company = Company::whereId($request->centerId)->first();
        $user = User::where('id', $company->user_id)->first();
        //$usr = auth()->user();
        if (!$company && !$user){
           
                $msg = 'مزود الخدمة غير موجود';
                    
            return response()->json(['status' => false, 'message' => $msg]);
        }
        
        $rules = [
            'name_ar' => 'required|min:3|max:50',
            'name_en' => 'required|min:3|max:50',
            'description_ar' => 'required|min:3|max:1000',
            'description_en' => 'required|min:3|max:1000',
            'price' => 'required',
            'gender' => 'required',
            'serviceType_id' => 'required',
            'service_place' => 'required',
            //'image' =>'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
           
        }

        $product = new Service;
        
        $product->{'description:ar'} = $request->description_ar;
        $product->{'description:en'} = $request->description_en;
        $product->{'name:ar'} = $request->name_ar;
        $product->{'name:en'} = $request->name_en;
        //$product->name = $request->name_ar;
        $product->price = $request->price;
        $product->gender_type = $request->gender;
        $product->provider_type = $request->provider_type? $request->provider_type : $user->gender;
        $product->serviceType_id = $request->serviceType_id;
        $product->service_place = $request->service_place;
        $product->provider_id = $company->user_id ;
        $product->district_id = 0;
        $product->seen_count = 0;
        $product->status = 0;

        if ($request->image):
            $product->photo = UploadImage::uploadImage($request, 'image', $this->public_service_path);
        else:
            $product->photo = '';
        endif;

        if ($company->products()->save($product)) {
            return response()->json([
                'status' => true,
                'data' =>$product->id,
                'message' =>'تم اضافة الخدمة بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
    
    public function saveWorkday(Request $request){
        
        $company = Company::whereId($request->centerId)->first();
        $user = User::where('id', $company->user_id)->first();
        if (!$company && !$user){
           
                $msg = 'مزود الخدمة غير موجود';
                    
            return response()->json(['status' => false, 'message' => $msg]);
        }
        
        $rules = [
            'day'      => 'string|required|min:3|max:3',
            //'day'      => 'date_format:"D"|required',
            'from'     => 'date_format:"H:i"|required|before:to',
            'to'       => 'date_format:"H:i"|required|after:from',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
           
        }
        
        $model = new CompanyWorkDay;
        $model->company_id = $company->id;
        $model->day = $request->day;
        $model->from = $request->from;
        $model->to = $request->to;
        
        if ($model->save()) {
            return response()->json([
                'status' => true,
                'data' =>$model->id,
                'message' =>'تم اضافة يوم العمل بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
                    
    }
     
    public function deleteWorkday(Request $request){
        $model = CompanyWorkDay::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'عفواً, هذا اليوم غير  موجود او ربما تم حذفه'
            ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف اليوم بنجاح'
            ]);
        }
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
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($msg)
            ->setSound('default');
        $notificationBuilder->setClickAction("FCM_PLUGIN_ACTIVITY");
        $dataBuilder = new PayloadDataBuilder();
        
        $dataBuilder->addData(['message' => $msg , 'title'=>$title ,'type' =>'user_delete']);
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
            
            if ($model->is_suspend == 1) {
                //->is_active = 0;
                $msg = 'تم تعطيل مزود الخدمة';
            }
            
            if ($model->is_suspend != 1) {
                //$model->is_active = 1;
                $msg = 'تم تفعيل مزود الخدمة';
            }
            
            //$model->is_active = !($model->is_active);
            $model->is_suspend	= !($model->is_suspend);

            if ($model->save()) {
                return response()->json([
                    'status' => true,
                    'message' => $msg,
                    'id' => $model->id
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
