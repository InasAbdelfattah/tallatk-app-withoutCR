<?php

namespace App\Http\Controllers\Api\V1;

use App\City;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    
    function __construct(){
        app()->setlocale(request('lang'));
    }
    
    public function index()
    {
       $cities =  City::select('id')->get();

        $cities->map(function ($q) {
            $q->name = $q->{'name:'.app()->getlocale()};
        });

        $districts =  District::select('id' ,'city_id')->get();

        $districts->map(function ($q) {
            $q->name = $q->{'name:'.app()->getlocale()};
        });

        return response()->json([
            'status' => true,
            'data' => ['citites' => $cities , 'districts' => $districts]
        ]);
    }
}
