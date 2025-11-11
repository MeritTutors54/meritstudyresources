<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionType;
use App\Models\MeritSubscription;
use Carbon\Carbon;
use DB;
use Auth;

class MeritSubscriptionController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    // create
    public function create(){
        $allSubType=SubscriptionType::get();
        return view('backend.subscription.create',compact('allSubType'));
    }
    // store
    public function store(Request $request){
        $insert=MeritSubscription::insert([
            'title'=>$request->title,
            'sub_title'=>$request->sub_title,
            'price'=>$request->price,
            'subscription_type'=>$request->subscription_type,
            'type'=>$request->type,
            'access_details'=>json_encode($request->access_details),
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
     // index
    public function index(){
        $allData=MeritSubscription::where('is_deleted',0)->get();
        return view('backend.subscription.index',compact('allData'));
    }
    // edit
    public function edit($id){
        $allSubType=SubscriptionType::get();
        $edit=MeritSubscription::where('id',$id)->first();
        return view('backend.subscription.update',compact('edit','allSubType'));
    }
    public function update(Request $request){
        $insert=MeritSubscription::where('id',$request->id)->update([
            'title'=>$request->title,
            'sub_title'=>$request->sub_title,
            'price'=>$request->price,
            'subscription_type'=>$request->subscription_type,
            'type'=>$request->type,
            'access_details'=>json_encode($request->access_details),
            'updated_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        if($insert){
            $notification=array(
            'messege'=>'Updated success',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'Updated Faild',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        }
    }
    // delete
    public function delete($id){
        $delete=MeritSubscription::where('id',$id)->update([
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
        $active=MeritSubscription::where('id',$id)->update([
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
        $active=MeritSubscription::where('id',$id)->update([
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
}
