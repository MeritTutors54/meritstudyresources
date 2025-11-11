<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Contact;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard(): View
    {
        $activityLogs = AdminActivity::getActivityLogs(limit: 7);

        return view('backend.dashboard.index')
            ->with([
                'activityLogs' => $activityLogs,
            ]);
    }

    // admin password change
    public function passchange($id)
    {
        return view('backend.login.passchange');
    }

    // pass change
    public function passchangeresult(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:3',
            'oldpass' => 'required|min:3',
        ]);
        $password = Auth::user()->password;
        $oldpass = $request->oldpass;
        $newpass = $request->password;
        $confirm = $request->password_confirmation;
        if (Hash::check($oldpass, $password)) {
            if ($newpass === $confirm) {
                $user = Admin::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::logout();
                $notification = array(
                    'messege' => 'Password Changed Successfully ! Now Login with Your New Password',
                    'alert-type' => 'success'
                );
                return Redirect()->route('admin.login')->with($notification);
            } else {
                $notification = array(
                    'messege' => 'New password and Confirm Password not matched!',
                    'alert-type' => 'error'
                );
                return Redirect()->back()->with($notification);
            }
        } else {
            $notification = array(
                'messege' => 'Old Password not matched!',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }


    public function adminupdate($id)
    {
        // return "ok";
        $edit = Admin::where('id', $id)->first();
        return view('backend.login.adminprofileupdate', compact('edit'));
    }

    public function adminupdatesubmit(Request $request)
    {


        $validatedData = $request->validate([
            'user_name' => 'required|unique:admins,user_name,' . $request->id,
            'email' => 'required',
            'name' => 'required',
        ]);
        $update = Admin::where('id', $request->id)->update([
            'user_name' => $request->user_name,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $ImageName = 'Admin_image_' . '_' . time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/adminImage/'), $ImageName);
            Admin::where('id', $request->id)->update([
                'image' => $ImageName,
            ]);

        }
        if ($update) {

            $notification = array(
                'messege' => 'Update success',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {
            $notification = array(
                'messege' => 'Update Faild',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

    }
}
