<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use Carbon\Carbon;

class SingleviewController extends Controller
{
    function index(Request $request)
    {
		if($request->plan_id) {
			$plan = Plan::where('plan_id', $request->plan_id)->first();
			$plan_day = $plan->created_at;			
			$today = $plan_day->shortEnglishDayOfWeek . "_" . $plan_day->isoFormat('YYYY_MM_DD') . "_plan";

			if($plan) {
		  	//got the ID
		  	return view('planview')
		      ->with("today", $today)
		      ->with("plan", $plan);    
			} else {
		  	//don't know that ID
		  	abort(404);
			}
    }
  }
}
