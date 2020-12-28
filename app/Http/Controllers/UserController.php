<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Roles;
use App\Admin;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function index_shop()
    {
        $this->AuthLogin();
        $admin = Admin::orderBy('admin_id', 'DESC')->where('roles_id', 2)->paginate(5);
        return view('admin.users.all_shop')->with(compact('admin'));
    }

    public function index_admin()
    {
        $this->AuthLogin();
        $admin = Admin::orderBy('admin_id', 'DESC')->where('roles_id', 1)->paginate(5);
        return view('admin.users.all_admin')->with(compact('admin'));
    }

    public function index_users()
    {
        $this->AuthLogin();
        $admin = Admin::orderBy('admin_id', 'DESC')->where('roles_id', 0)->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
    }

    public function add_admin()
    {
        $this->AuthLogin();
        return view('admin.users.add_admin');
    }

    public function assign_roles(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        Admin::where('admin_email', $data['admin_email'])->update(array('roles_id' => '2'));
        return redirect()->back();
    }

    public function store_users(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->roles_id = 1;
        $check = Admin::where('admin_email', '=', $admin->admin_email)->first();
        if ($check === null) {
            $admin->save();
            Session()->put('message', 'Thêm admin thành công');
            return Redirect::to('users-admin');
        } else {
            return redirect('add-users')->with('message', 'Tài khoản đã tồn tại');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
