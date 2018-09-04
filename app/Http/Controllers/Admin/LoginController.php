<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function __construct()
    {


    }

    /**
     * @return string
     * @@ return login view
     * @@ access file login.blade.php from views.admin.login
     */


    public function login()
    {

        if (auth()->check() && auth()->user()->hasAnyRoles()) {
            return redirect(route('admin.home'));
            // return view('admin.auth.login');
        }
        return view('admin.auth.login');
    }


    public function postLogin(Request $request)
    {


        //return $request->all();
        $this->validate($request, [
            'provider' => 'required',
            'password' => 'required'
        ]);

        $field = filter_var($request->provider, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $remember = $request->remember != ''? true : false;

        if (Auth::attempt([$field => $request->provider, 'password' => $request->password ],$remember)) {
            $user = Auth()->user();
            if($user->is_active !=1):
                Auth::logout();
                session()->flash('error', 'لا يمكنك الدخول على حسابك نظرا لتعطل حسابك');
                
                return redirect()->back()->withInput();
            endif;
            return redirect()->route('admin.home');
        }

        session()->flash('error', 'اسم المستخدم او كلمة المرور غير صحيح');
        return redirect()->back()->withInput();

    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route('admin.login'));

    }

}
