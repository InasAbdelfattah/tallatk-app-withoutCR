<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Company;
use App\Service;
use App\Order;
use App\User;
use App\Rate;
use App\Support;
use App\Abuse;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use willvincent\Rateable\Rating;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{

    public function index()
    {
        $data['centersCount'] = Company::count();
        $data['usersCount'] = User::where('is_user',1)->where('is_provider',0)->get()->count();
        $data['providersCount'] = User::where('is_user',1)->where('is_provider',1)->where('is_approved',1)->get()->count();
        $data['services_app'] = Service::get()->count();
        $data['orders'] = Order::get()->count();
        $data['read_contacts'] = Support::whereParentId(0)->where('is_read',1)->get()->count();
        $data['notread_contacts'] = Support::whereParentId(0)->where('is_read',0)->get()->count();
        $data['notadoptedreports'] = Abuse::where('is_adopt',0)->get()->count();
        $data['mens_count'] = User::where('is_user',1)->where('is_provider',0)->where('gender','male')->get()->count();
        $data['womens_count'] = User::where('is_user',1)->where('is_provider',0)->where('gender','female')->get()->count();
        $data['categoriesCount'] = Category::all()->count();
        return view('admin.home.index')->with(compact('data'));
    }
}
