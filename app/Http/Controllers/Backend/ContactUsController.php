<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Carbon\Carbon;
use DB;
use Auth;

class ContactUsController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    // contact
    public function index(){
        $allData=Contact::where('is_deleted',0)->orderBy('id','DESC')->get();
        return view('backend.contact.index',compact('allData'));
    }
    // view
    public function view($id){
        $data=Contact::where('id',$id)->first();
        return view('backend.contact.view',compact('data'));
    }
}
