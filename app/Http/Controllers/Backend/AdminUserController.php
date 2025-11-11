<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Role;
use Carbon\Carbon;
use Auth;
use DB;


class AdminUserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    // create
    public function create(){
        $allRole=Role::where('is_deleted',0)->get();
        return view('backend.adminuser.create',compact('allRole'));
    }
    // store
    public function store(Request $request){
        $this->validate($request, [
            'user_name'   => 'required',
            'name'   => 'required',
            'email'   => 'required',
            'password' => 'required|min:3',
            'confirmm_password' => 'required|same:password'
        ]);
        $insert=Admin::insertGetId([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'user_name'=>$request->user_name,
            'address'=>$request->address,
            'user_role'=>$request->user_role,
            'password' => Hash::make($request['password']),
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        if($request->hasFile('image')){
            $imagef = $request->file('image');
            $ImageName = 'image_' . '_' . time() . '.' . $imagef->getClientOriginalExtension();
            $newfile =$imagef->move(public_path('uploads/logo/'),$ImageName);
            Admin::where('id', $insert)->update([
                'image' => $ImageName,
            ]);
        }
        if($insert){

            $notification=array(
                'messege'=>'Create success',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);

        }else{
            $notification=array(
                'messege'=>'Create Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
     // index
    public function index(){
        $allData=Admin::where('is_deleted',0)->get();
        return view('backend.adminuser.index',compact('allData'));
    }
    // edit
    public function edit($id){
        $edit=Admin::where('id',$id)->first();
        $allRole=Role::where('is_deleted',0)->get();
        return view('backend.adminuser.update',compact('edit','allRole'));
    }
    public function update(Request $request){
        $insert=Admin::where('id',$request->id)->update([
            'category_name'=>$request->category_name,
            'updated_by'=>Auth::user()->id,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);
        if($insert){
            $notification=array(
            'messege'=>'Create success',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'Create Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
    // delete
    public function delete($id){
        $delete=Admin::where('id',$id)->update([
            'is_deleted'=>1,
            'deleted_by'=>Auth::user()->id,
        ]);
        if($delete){
            $notification=array(
            'messege'=>'Delete success',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'Delete Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
    // active
    public function active($id){
        $active=Admin::where('id',$id)->update([
            'is_active'=>1,
        ]);
        if($active){
            $notification=array(
            'messege'=>'Update success',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'Update Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
    // DeActive
    public function deActive($id){
        $active=Admin::where('id',$id)->update([
            'is_active'=>0,
        ]);
        if($active){
            $notification=array(
            'messege'=>'Update success',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'Update Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
    // password
    public function passUpdate(Request $request){
        
        $this->validate($request, [
            'password' => 'required|min:3',
            'confirmm_password' => 'required|same:password'
        ]);
        $passUpdate=Admin::where('id',$request->id)->update([
            'password' => Hash::make($request['password']),
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
   
        if($insert){
            $notification=array(
                'messege'=>'Create success',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);

        }else{
            $notification=array(
                'messege'=>'Create Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }


    }
}
