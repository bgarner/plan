<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use Carbon\Carbon;

class SingleviewController extends Controller
{
    function index(Request $request)
    {
		$dt = new Carbon();
		$today = $dt->shortEnglishDayOfWeek . "_" . $dt->isoFormat('YYYY_MM_DD') . "_plan";

		if($request->plan_id) {
			$plan = Plan::where('plan_id', $request->plan_id)->first();
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
