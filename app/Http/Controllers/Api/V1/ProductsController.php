<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UploadImage;
use App\User;
use Validator;

class ProductsController extends Controller
{

    public $public_path;

    public function __construct()
    {
        app()->setlocale(request('lang'));
        $this->public_service_path = 'files/companies/services/';
    }
   
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function saveProduct(Request $request)
    {

        /**
         * @ GET company...
         */
        $company = Company::whereId($request->centerId)->first();
        $user = User::where('id', $company->user_id)->first();
        $usr = auth()->user();
        if($usr->id != $company->user_id){
            return response()->json([
                'status' => false,
                'message' => 'unavailable'
            ]);
        }

        if (!$company && !$user){
            
            if($request->lang && $request->lang == 'en'):
                $msg = 'provider not found';
            else:
                $msg = 'مزود الخدمة غير موجود';
            endif;
                    
            return response()->json(['status' => false, 'message' => $msg]);
        }
        
        $rules = [
            'name' => 'required|min:3|max:50',
            //'name_en' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:1000',
            //'description_en' => 'required|min:3|max:1000',
            //'price' => 'required',
            
            'gender' => 'required',
            'serviceType_id' => 'required',
            'service_place' => 'required',
            //'image' =>'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

        $product = new Service;
        
        $product->{'description:'.app()->getlocale()} = $request->description;
        //$product->{'description:en'} = $request->description_en;
        $product->{'name:'.app()->getlocale()} = $request->name;
        //$product->{'name:en'} = $request->name_en;
        //$product->name = $request->name_ar;
        $product->price = $request->price;
        $product->min_cost = $request->min_cost;
        $product->max_cost = $request->max_cost;
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
                'data' =>$product->id
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
    
    public function uploadServiceImage(Request $request){
        
        $rules = [
            'serviceId' => 'required',
            'image' =>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }
        
        $service = Service::find($request->serviceId);
        if($service){

            $service->photo = UploadImage::uploadImage($request, 'image', $this->public_service_path);
            
            $service->save();
            
            return response()->json([
                'status' => true,
                'data' => $request->root() . '/' . $this->public_service_path . $service->photo 
            ]);

        }
        return response()->json([
                'status' => false,
                'message' => 'service not found'
            ]);
    }

    public function productsList(Request $request)
    {
        /**
         * Set Default Value For Skip Count To Avoid Error In Service.
         * @ Default Value 15...
         */
        if (isset($request->pageSize)):
            $pageSize = $request->pageSize;
        else:
            $pageSize = 15;
        endif;
        /**
         * SkipCount is Number will Skip From Array
         */
        $skipCount = $request->skipCount;
        $itemId = $request->itemId;

        $currentPage = $request->get('page', 1); // Default to 1
        
        if($request->has('api_token') && $request->api_token != ''){
            $user = User::where('api_token',$request->api_token)->first();
        }else{
            $user = null ;
        }
        
        if($user){
            // $services = Service::where('company_id',$company->id)->where('gender_type',$user->gender)->select('id','company_id as centerId' , 'gender_type as receiver_gender')->get();
            
            $query = Service::where('company_id', $request->centerId)->where('gender_type',$user->gender)->orderBy('created_at', 'desc')->select();  
            
        }else{
            // $services = Service::where('company_id',$company->id)->select('id','company_id as centerId' , 'gender_type as receiver_gender')->get();
            
            $query = Service::where('company_id', $request->centerId)
            ->orderBy('created_at', 'desc')
            ->select();
        }
        
        if ($request->service_place) :
            $query->where('service_place', '=', $request->service_place);
        endif;
        
        if ($request->gender_type && $request->gender_type != 'both'):
            $query->where('gender_type', '=', $request->gender_type);
        endif;
        
        

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount);
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $products = $query->select('id','price','photo' , 'gender_type as gender' , 'provider_type' ,'service_place' ,'serviceType_id' , 'company_id' ,'max_cost','min_cost', 'created_at')->get();

        $products->map(function ($q) use($request){

            $q->name = $q->{'name:'.app()->getlocale()};
            //$q->name_en = $q->{'name:en'};
            $q->description = $q->{'description:'.app()->getlocale()};
            //$q->description_en = $q->{'description:en'};
            $q->image= $request->root() . '/' . $this->public_service_path . $q->photo ;
            
        });

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $products
        ]);

    }


    public function update(Request $request)
    {
        $model = Service::whereId($request->serviceId)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'هذه الخدمة غير موجودة'
            ]);
        }

        if($request->has('description') && $request->description != ''):
            $model->{'description:'.app()->getlocale()} = $request->description;
        endif;

        // if($request->has('description_en') && $request->description_en != ''):
        //     $model->{'description:en'} = $request->description_en;
        // endif;

        if($request->has('name') && $request->name != ''):
            $model->{'name:'.app()->getlocale()} = $request->name;
        endif;

        // if($request->has('name_en') && $request->name_en != ''):
        //     $model->{'name:en'} = $request->name_en;
        // endif;

        if($request->has('price') && $request->price != ''):
            $model->price = $request->price;
        endif;
        
        if($request->has('min_cost') && $request->min_cost != ''):
            $product->min_cost = $request->min_cost;
        endif;
        
        if($request->has('max_cost') && $request->max_cost != ''):
            $product->max_cost = $request->max_cost;
        endif;

        if($request->has('gender') && $request->gender != ''):
            $model->gender_type = $request->gender;
        endif;

        if($request->has('provider_type') && $request->provider_type != ''):
            $model->provider_type = $request->provider_type;
        endif;

        if($request->has('serviceType_id') && $request->serviceType_id != ''):
            $model->serviceType_id = $request->serviceType_id;
        endif;

        if($request->has('service_place') && $request->service_place != ''):
            $model->service_place = $request->service_place;
        endif;

        if ($request->hasFile('image') && $request->image != ''):
            $model->photo = UploadImage::uploadImage($request, 'image', $this->public_service_path);
        endif;

        if ($model->save()) {
            return response()->json([
                'status' => true,
                'data' => $model
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Delete
     */

    public function delete(Request $request)
    {
        $model = Service::whereId($request->serviceId)->first();

        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'هذه الخدمة غير موجودة'
            ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف الخدمة بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لقد حدث خطأ, من فضلك حاول مرة آخرى'
            ]);
        }


    }

}
