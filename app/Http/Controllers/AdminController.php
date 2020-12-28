<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Social;
use Laravel\Socialite\Facades\Socialite;
use App\Login;
use App\Admin;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function register_shop()
    {
        return view('admin_signup');
    }

    public function validation($request)
    {
        return $this->validate($request, [
            'admin_name' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_phone' => 'required|max:255',
            'admin_password' => 'required|max:255',
        ]);
    }

    public function register(Request $request)
    {
        $this->validation($request);
        $data = $request->all();
        $admin = new Admin();
        $admin->roles_id = 0;
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);
        $check = Admin::where('admin_email', '=', $admin->admin_email)->first();
        if ($check === null) {
            $admin->save();
            return redirect('send-mail');
            // return redirect('/admin')->with('message', 'Bạn đã đăng kí, hãy đợi admin duyệt đơn của bạn');
        } else return redirect('/register-shop')->with('message', 'Tài khoản đã tồn tại, vui lòng nhập lại');
    }

    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
        if ($account) {
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id', $account->user)->first();
            if ($account_name->roles_id == 2) {
                Session()->put('admin_name', $account_name->admin_name);
                Session()->put('admin_id', $account_name->admin_id);
                Session()->put('roles_id', $account_name->roles_id);
                return redirect('/dashboard-shop')->with('message', 'Đăng nhập Admin thành công');
            } else if ($account_name->roles_id == 0) {
                return redirect('/admin')->with('message', 'Bạn đã đăng kí, hãy đợi admin duyệt đơn của bạn');
            }
        } else {

            $social = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'roles_id' => '0',
                    'admin_password' => '',
                    'admin_phone' => ''
                ]);
            }
            $social->login()->associate($orang);
            $social->save();

            $account_name = Login::where('admin_id', $account->user)->first();
            Session()->put('admin_name', $account_name->admin_name);
            Session()->put('admin_id', $account_name->admin_id);
            Session()->put('roles_id', $account_name->roles_id);
            return redirect('/dashboard-shop')->with('message', 'Đăng nhập Admin thành công');
        }
    }

    public function AuthLogin()
    {
        $admin_id = Session()->get('admin_id');
        $roles_id = Session()->get('roles_id');
        if ($admin_id && $roles_id == 1) {
            return Redirect::to('dashboard-admin');
        } else if ($admin_id && $roles_id == 2) {
            return Redirect::to('dashboard-shop');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function index()
    {
        return view('admin_login');
    }

    public function show_dashboard_admin()
    {
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function show_dashboard_shop()
    {
        $this->AuthLogin();
        return view('admin.dashboard_shop');
    }

    public function dashboard(Request $request)
    {
        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
        ]);

        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login_admin = Login::where('roles_id', '1')
            ->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        $login_shop = Login::where('roles_id', '2')
            ->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        $login_user = Login::where('roles_id', '0')
            ->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if ($login_admin) {
            $login_count = $login_admin->count();
            if ($login_count > 0) {
                Session()->put('admin_name', $login_admin->admin_name);
                Session()->put('admin_id', $login_admin->admin_id);
                Session()->put('roles_id', $login_admin->roles_id);
                return Redirect::to('/dashboard-admin');
            }
        } else if ($login_shop) {
            $login_count = $login_shop->count();
            if ($login_count > 0) {
                Session()->put('admin_name', $login_shop->admin_name);
                Session()->put('admin_id', $login_shop->admin_id);
                Session()->put('roles_id', $login_shop->roles_id);
                return Redirect::to('/dashboard-shop');
            }
        } else if ($login_user) {
            Session()->put('message', 'Bạn đã đăng kí, hãy đợi admin duyệt đơn của bạn');
            return Redirect::to('/admin');
        } else {
            Session()->put('message', 'Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
        }
    }

    public function logout()
    {
        $this->AuthLogin();
        Session()->put('admin_name', null);
        Session()->put('admin_id', null);
        Session()->put('roles_id', null);
        return Redirect::to('/admin');
    }
}
