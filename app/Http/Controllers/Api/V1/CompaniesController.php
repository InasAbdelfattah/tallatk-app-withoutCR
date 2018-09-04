<?php

namespace App\Http\Controllers\Api\V1;

use App\Conversation;
use App\Category;
use App\User;
use DB;
use App\Company;
use App\Service;
use App\CompanyWorkDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon;

class CompaniesController extends Controller
{
    function __construct(){
        app()->setlocale(request('lang'));
        $this->public_path = 'files/companies/';
       // $this->public_path_user = 'files/users/';
        $this->public_path_docs = 'files/docs/';
        $this->public_service_path = 'files/companies/services/';
    }
    
    public function updateVisitsCount($centerId){
        $company = Company::where('id',$centerId)->first();
        if(!$company){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }
        $company->visits_count += 1;
        $company->save();
        
        return response()->json([
            'status' => true,
            'visits_count' => $company->visits_count,
            'data' => []
        ]);
    }
    
    public function details(Request $request)
    {
        // $currentUser = User::where('api_token', $request->api_token)->first();
        // if(!$currentUser){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'user not found',
        //         'data' => []
        //     ]);
        // }

        $company = Company::with('images')->whereId($request->centerId)->select('id','user_id','category_id','phone','type','city_id','image','document_photo','visits_count')->first();
        if(!$company){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }
        $company->visits_count += 1;
        $company->save();

        $company->name = $company->{'name:'.app()->getlocale()};
        //$company->name_en = $company->{'name:en'};
        $company->description = $company->{'description:'.app()->getlocale()};
        //$company->description_en = $company->{'description:en'};
        $company->place = $company->place == 0 ? 'منزل' : 'مركز';
        $company->providerType = $company->type == 0 ? 'فرد' : 'مركز';

        //services 
        
        if($request->has('api_token') && $request->api_token != ''){
            $user = User::where('api_token',$request->api_token)->first();
        }else{
            $user = null ;
        }
        
        if($user){
            $services = Service::where('company_id',$company->id)->where('gender_type',$user->gender)->select('id','company_id as centerId' , 'gender_type as receiver_gender')->get();
        }else{
            $services = Service::where('company_id',$company->id)->select('id','company_id as centerId' , 'gender_type as receiver_gender')->get();
        }
        
        $services->map(function ($q) {
            $q->name = $q->{'name:'.app()->getlocale()};
            $q->description = $q->{'description:'.app()->getlocale()};
            $q->image= $request->root() . '/' . $this->public_service_path . $q->photo ;

        });
        
        $company->services = $services ;
        $company->workDays = $this->getCompanyWorkDays($company->id , app()->getlocale());
        $company->workDaysCount = $company->workDays()->count();
        $company->favorites = $company->favorites()->count();
        //$company->ratings = $company->rates()->where('user_id', auth()->id())->count();
        $company->rate = $q->rates()->avg('rate') ? $q->rates()->avg('rate') : 0;
        $company->commentsCount = $company->comments()->count();
        //$company->hasConversation = ($hasConversation) ? true : false;
        // if ($hasConversation)
        //     $company->conversationId = $hasConversation->id;


//        }
        //$company->visits = $company->visits()->count();

        /**
         * Return Data Array
         */
        return response()->json([
            'status' => true,
            'data' => $company
        ]);
    }


    public function companiesList(Request $request)
    {

        $weekMap = [
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat',
        ];
        $dt = Carbon\Carbon::now();
        $time = $dt->toTimeString();
        $day = date('D', strtotime($dt));
        $weekday = $weekMap[$dt->dayOfWeek];
        //dd($weekday);
        
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
        $skipCount = $request->get('skipCount',0);
        //$itemId = $request->itemId;

        $currentPage = $request->get('page', 1); // Default to 1
        
        
        if($request->rating){

            if($request->rating == 'top'){
                $sort = 'desc';
            }else{
                $sort = 'asc';
            }
            
            $providers = User::where('is_user',1)->where('is_provider',1)->where('is_approved',1)->where('is_suspend',0)->pluck('id')->toArray();
        

            $rates = Company::leftJoin('rates', 'rates.company_id', '=', 'companies.id')
                ->whereIn('companies.user_id', $providers )
                ->groupBy('companies.id')
                ->orderBy('rating',$sort)
                ->selectRaw('companies.*, avg(rates.rate) as rating')
                ->skip($skipCount)
                ->take($pageSize)
                ->get();


            if ($request->city) :
                $rates->filter(function ($value, $key) use ($request){
                    return $value->city_id = $request->city;
                });

            endif;

            if ($request->category) {
                $rates->filter(function ($value, $key) use ($request){
                    return $value->category_id = $request->category;
                });

            }

            $rates->map(function ($q) use ($request, $time , $weekday) {
                
                $q->name = $q->{'name:'.app()->getlocale()};
                $q->description = $q->{'description:'.app()->getlocale()};
                $q->center_photo= $request->root() . '/' . $this->public_path . $q->image ;
                $q->doc_photo= $request->root() . '/' . $this->public_path_docs . $q->document_photo ;
                $q->place = $q->place == 0 ? 'منزل' : 'مركز';
                $q->providerType = $q->type == 0 ? 'فرد' : 'مركز';
                $q->rate = $q->rates()->avg('rate') ? $q->rates()->avg('rate') : 0;
                $q->email = ($user = $this->companyCompleteFromUser($q->id)) ? $user->email : null;
                $q->city = $this->getCityForCompany($q->id);
                $q->commentsCount = $this->getCountsForCompany($q->id);
                $q->favoritesCount = $q->favorite()->count();
                $q->services = $this->getCompanyServices($q->id , $request);
                $q->workDays = $this->getCompanyWorkDays($q->id , app()->getlocale());
                
                if ($request->api_token) {
                    $user = User::where('api_token', $request->api_token)->first();
                    if ($user) {
                        $isHasFav = $q->favorite()->where('user_id', $user->id)->first();
                        $q->isFavorite = (count($isHasFav)) ? true : false;
                        
                        $userRate = $q->rates()->where('user_id',$user->id)->first();
                        $q->userRate = $userRate ? $userRate->rate : 0 ;
                    }
                }

                $workDays = CompanyWorkDay::where('company_id',$q->id)->get();
                
                $days = $workDays->pluck('day')->toArray();
                $time_range = $workDays->where('day',$weekday)->first();
                
                
                 if(in_array($weekday, $days) && ( $time >= $time_range->from && $time <= $time_range->to )){
                    
                     $q->is_open = 1;
                    
                 }else{
                     $q->is_open = 0;
                     
                 }
                 
                

            });

            return response()->json([
                'status' => true,
                'data' => $rates
            ]);

        }



        //$query = Company::orderBy('created_at', 'desc')->select();
        
        $providers = User::where('is_user',1)->where('is_provider',1)->where('is_approved',1)->where('is_suspend',0)->pluck('id')->toArray();
        
        $query = Company::whereIn('user_id', $providers )->orderBy('created_at', 'desc')->select();


        //$query->whereIsAgree(1);
        /**
         *
         * @@ Get By Name Of Company.
         */
        // if ($request->companyName) :
        //     $query->where('name', 'Like', "%$request->companyName%");
        // endif;

        /**
         * @@ Get By Name Of Product Related for Company.
         */
        // if ($request->productName) :
        //     $query->whereHas('products', function ($q) use ($request) {
        //         $q->where('name', 'like', "%$request->productName%");
        //     })->get();
        // endif;

        /**
         *
         * @@ Get By City Of Company.
         */
        if ($request->city) :
            $query->where('city_id', '=', $request->city);
        endif;


        /**
         * @@ Get By City Of Company.
         */

        // if ($request->mainCategory) {

        //     $categories = Category::whereParentId($request->mainCategory)->get();

        //     $arrIds = [];

        //     foreach ($categories as $category):
        //         $arrIds[] = $category->id;
        //     endforeach;
        //     $query->whereIn('category_id', $arrIds);

        // }
        
        // if ($request->category) {

        //     $query->where('category_id', $request->category);

        // }
        
        
        if ($request->type) {

            $query->where('type', $request->type);

        }


        /**
         * @@ Get By City Of Company.
         */

        // if ($request->subCategory) {


        //     $query->where('category_id', $request->subCategory);

        // }


        /**
         * @ If item Id Exists skipping by it.
         */
        // if ($itemId) {
        //     $query->where('id', '<=', $itemId);
        // }


        if (isset($request->filterby) && $request->filterby == 'date') {
            $query->orderBy('created_at', 'desc');
        } elseif (isset($request->filterby) && $request->filterby == 'visits') {
//            $query->whereHas('products', function ($q) use ($request) {
//                $q->where('company_id', $q->id);
//            })->get();
        }


        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        //$query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->skip($skipCount);
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */


//        if($request->visits){
//            /**
//             * @@ Get By Name Of Product Related for Company.
//             */
//
//            $query->whereHas('visits', function ($q) use ($request) {
//                    $q->orderBy('name', 'like', "%$request->productName%");
//                })->get();
//
//        }
        
        



        $companies = $query->select('id','user_id','category_id','phone','type','city_id','image','document_photo','visits_count','address')->get();
        
        
        
        
        
        $companies->map(function ($q) use ($request , $time , $weekday) {
            
            $q->name = $q->{'name:'.app()->getlocale()};
            $q->description = $q->{'description:'.app()->getlocale()};
            $q->center_photo= $request->root() . '/' . $this->public_path . $q->image ;
            $q->doc_photo= $request->root() . '/' . $this->public_path_docs . $q->document_photo ;
            $q->place = $q->place == 0 ? 'منزل' : 'مركز';
            $q->providerType = $q->type == 0 ? 'فرد' : 'مركز';
            $q->rate = $q->rates()->avg('rate') ? $q->rates()->avg('rate') : 0;
            $q->email = ($user = $this->companyCompleteFromUser($q->id)) ? $user->email : null;
            $q->city = $this->getCityForCompany($q->id);
            $q->commentsCount = $this->getCountsForCompany($q->id);
            //$q->favoritesCount = $q->favorites()->count();
            $q->services = $this->getCompanyServices($q->id , $request);
            $q->workDays = $this->getCompanyWorkDays($q->id , app()->getlocale());
             
            $workDays = CompanyWorkDay::where('company_id',$q->id)->get();
            $days = $workDays->pluck('day')->toArray();
            $time_range = $workDays->where('day',$weekday)->first();
            
            if($time_range) {
                if (in_array($weekday, $days) && ($time >= $time_range->from && $time <= $time_range->to)) {

                    $q->is_open = 1;


                } else {
                    $q->is_open = 0;

                }
                $q->current_time = $time ;
                $q->weekday = $weekday ;
                $q->timeRange = $time_range ;

                $q->from = $time_range->from ;
                $q->to = $time_range->to ;
                 $q->isbetween = $this->dateIsBetween($time_range->from , $time_range->to , $time);
                 $q->isbet = 'hhh';
            }else{
                $q->is_open = 0;
            }
            
            $services = Service::where('company_id', $q->id)->select('id', 'company_id as centerId' ,'price')->get();
            if(count($services) > 0){
                $range['from'] = $services->max('price');
                $range['to'] = $services->min('price');
            }else{
                $range = null;
            }
            $q->price_range = $range;
            
            if ($request->api_token) {
                $user = User::where('api_token', $request->api_token)->first();
                if ($user) {
                    $isHasFav = $q->favorite()->where('user_id', $user->id)->first();
                    $q->isFavorite = (count($isHasFav)) ? true : false;
                    
                    $userRate = $q->rates()->where('user_id',$user->id)->first();
                    $q->userRate = $userRate ? $userRate->rate : 0 ;
                }
            }

        });

        // if (isset($request->filterby) && $request->filterby == 'visits') {
        //     $sorted = $companies->sortByDesc('visits');
        //     $companies = $sorted->values()->all();
        // }

        // if (isset($request->filterby) && $request->filterby == 'rate') {
        //     $sorted = $companies->sortByDesc('ratings');
        //     $companies = $sorted->values()->all();
        // }
        
        
        /**
         * Return Data Array
         */
         
        if ($request->category) :
            $companies->map(function ($q) use ($request){
                $q->typeServicecount = $this->countCenterServicesByCat($q->id , $request->category);
            });
            
            $filtered = $companies->reject(function ($q){
                return $q->typeServicecount == 0;
            });
            
            //$companies = $filtered->first();
            $company = [];
            if(count($filtered) > 0){
                foreach($filtered as $filter){
                    array_push($company , $filter);
                }
            }
            
            return response()->json([
            'status' => true,
            'data' => $company
        ]);
        endif;

        return response()->json([
            'status' => true,
            'data' => $companies
        ]);
    }
    
    private function countCenterServicesByCat($centerId , $typeId)
    {
        $services = Service::where('company_id',$centerId)->get();
        if($services){
            $ids = $services ->pluck('id')->toArray();
            
            $service = Service::whereIn('id', $ids )->where('serviceType_id',$typeId)->count();
            
            return $service ;
            
        }
        
        return 0;
        
    }


    public function commentList(Request $request)
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

        $query = Comment::with('user')
            ->where('commentable_id', $request->companyId)
            ->orderBy('created_at', 'desc')
            ->select();

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        if (isset($request->filterby) && $request->filterby == 'date') {
            $query->orderBy('created_at', 'desc');
        }
        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $comments = $query->get();

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $comments
        ]);

    }
    
    
    
    private function dateIsBetween($from, $to, $date) {
    $date = is_int($date) ? $date : strtotime($date); // convert non timestamps
    $from = is_int($from) ? $from : strtotime($from); // ..
    $to = is_int($to) ? $to : strtotime($to);         // ..
    return ($date > $from) && ($date < $to); // extra parens for clarity
}

    /**
     * @param $company
     * @return array|null
     */
     
     
     

    private function getCountsForCompany($company)
    {
        $company = Company::with('comments')->whereId($company)->first();

        return ($company && $company->comments) ? $company->comments->count() : NULL;
    }

    /**
     * @param $company
     * @return array|null
     */

    private function getCompanyServices($company ,$request )
    {
        if ($request->has('api-token') && $request->api_token != '') {
            $user = User::where('api_token', $request->api_token)->first();

            if ($user) {
                $services = Service::where('company_id', $company)->where('gender_type', $user->gender)->select('id', 'company_id as centerId' ,'price')->get();
            }
        }else {
            $services = Service::where('company_id', $company)->select('id', 'company_id as centerId' ,'price','photo')->get();
        }

        //$services = Service::where('company_id', $company)->select('id', 'company_id as centerId' ,'price')->get();

        $services->map(function ($q) use($request){
            $q->name = $q->{'name:' . app()->getlocale()};
            $q->description = $q->{'description:' . app()->getlocale()};
            $q->image= $request->root() . '/' . $this->public_service_path . $q->photo ;

        });
        return $services ? $services : NULL;
    }


    private function getCompanyWorkDays($company , $locale)
    {
         $workDays = CompanyWorkDay::where('company_id',$company)->select('id','day' ,'from' ,'to' , 'company_id as centerId')->get();
        //$workDays = Company::with('workDays')->get();

        // $workDays->map(function ($q) {
        //     $q->name_ar = day($q->day);
        //     $q->name_en = $q->day;
            
        // });
        
        

        if($workDays->count() > 0){
            if($locale == 'ar'){
                $workDays->map(function ($q) {
                    $q->name = day($q->day);
                });
            }else{
                $workDays->map(function ($q) {
                    $q->name = $q->day;
                });
            }
        }
        return $workDays ? $workDays : NULL;
    }

    /**
     * @param $company
     * @return array|null
     */

    private function getMembershipForCompany($company)
    {
        $company = Company::with('membership')->whereId($company)->first();
        return ($company && $company->membership) ? [
            'id' => $company->membership->id,
            'name' => $company->membership->name,
            'color' => $company->membership->color
        ] : NULL;
    }

    /**
     * @param $company
     * @return null
     */
    private function getCityForCompany($company)
    {
        $company = Company::with('city')->whereId($company)->first();
        return ($company && $company->city) ? $company->city->name : NULL;
    }


    /**
     * @param $company
     * @return mixed
     */
    private function companyCompleteFromUser($company)
    {
        $company = Company::with('user')->whereId($company)->first();
        return ($company && $company->user) ? $company->user : NULL;
    }

}
