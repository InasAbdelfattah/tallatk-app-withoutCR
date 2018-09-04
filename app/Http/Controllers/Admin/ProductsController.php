<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller
{

    function __construct(){
        app()->setlocale(request('lang'));
    }
    
    public function delete(Request $request)
    {

        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $model = Service::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'عفواً, هذه الخدمة غير موجود او ربما تم حذفها'
            ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف الخدمة بنجاح'
            ]);
        }

    }

    public function update(Request $request)
    {

        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $model = Service::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'عفواً, هذه الخدمة غير موجود او ربما تم حذفها'
            ]);
        }
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

        $query = Service::with('company')
            ->where('company_id', $request->centerId)
            ->orderBy('created_at', 'desc')
            ->select();

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $products = $query->select('name', 'description', 'gender_type', 'provider_type', 'service_place', 'serviceType_id', 'company_id as centerId', 'district_id', 'price')->get();
        
        $products->map(function ($q) {
            $q->name = $q->{'name:'.app()->getlocale()};
            $q->description = $q->{'description:'.app()->getlocale()};
        });

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $products
        ]);

    }

}
