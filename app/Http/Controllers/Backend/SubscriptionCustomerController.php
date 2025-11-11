<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Subscription;
class SubscriptionCustomerController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    // list
    public function index(){

        $subscriptions = Subscription::query()->active()->get();
        dd($subscriptions);
    }
}
