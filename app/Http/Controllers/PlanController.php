<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class PlanController extends Controller
{
	function index()
	{

	}

	function create()
	{

	}

	function store(Request $request)
	{
		$plan_id = sha1(time() . time() . $request->plan . $request->user_id);
		$plan = new Plan;
		$plan->plan_id = $plan_id;
		$plan->user_id = $request->user_id;
		$plan->plan = $request->plan;
		$plan->save();
		return $plan->plan_id;
	}

	function show(Request $request)
	{
		//fetch a plan
		return Plan::where('plan_id', $request->plan_id)->get();
	}

	function edit()
	{

	}

	function update(Request $request)
	{
		$plan = Plan::where('plan_id', $request->plan_id)->first();
		// return $request->plan;
		if($plan) {
				$plan->plan = $request->plan;
				$plan->save();
				return $plan;
		} else {
			return "bad plan id";
		}
	}

	function destroy()
	{

	}

}
