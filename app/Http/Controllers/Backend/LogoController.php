<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Logo;
use Auth;
use Image;
class LogoController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
      }
    public function index(){
        $data=Logo::first();
        return view('backend.logo.index',compact('data'));
    }
    //update
    public function update(Request $request){
       
        $id=$request->id;
    	$update=Logo::where('id',$id)->update([
    	   'updated_at'=>Carbon::now()->toDateTimeString(),
    	]);
    	if($request->hasFile('logo')){

                $image = $request->file('logo');
                $ImageName = 'LOGO_' . '_' . time() . '.' . $image->getClientOriginalExtension();
                $request->logo->move('uploads/logo/', $ImageName);
                Logo::where('id', $id)->update([
                    'logo' => $ImageName,
                ]);
        }
        if($request->hasFile('favicon')){

                $imagef = $request->file('favicon');
                $ImageName = 'FAV_' . '_' . time() . '.' . $imagef->getClientOriginalExtension();
                $newfile =$imagef->move('uploads/logo/',$ImageName);
                Logo::where('id', $id)->update([
                    'favicon' => $ImageName,
                ]);

        }
	    if($request->hasFile('Lazy_loader')){
	            $imagel = $request->file('Lazy_loader');
	            $ImageName = '_' . '_' . time() . '.' . $imagel->getClientOriginalExtension();
	            $newfile =$imagel->move('uploads/logo/',$ImageName);
	            Logo::where('id', $id)->update([
	                'lazyloader' => $ImageName,
	            ]);

	    }
	    if($update){
	    	$notification = array(
	          'messege' => 'Update Success!',
	          'alert-type' =>'success'
	      	);
	      	return redirect()->back()->with($notification);
	    }else{

	    	$notification = array(
	          'messege' => 'Update Faild!',
	          'alert-type' =>'error'
	      	);
	      	return redirect()->back()->with($notification);
	    }
    }
}
