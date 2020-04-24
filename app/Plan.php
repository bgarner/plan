<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Plan extends Model
{
		protected $table = 'plans';

    function getTodaysPlan($user_id)
    {
    	$plan = Plan::where('user_id', $user_id)
    						->whereRaw('Date(created_at) = CURDATE()')
    						->pluck('plan');
    	return $plan[0];
    }

    function getPreviousPlans($user_id)
    {
    	$plans = Plan::where('user_id', $user_id)
    				->where('created_at', '<', Carbon::today())
    				->get()
    				->take(30)
    				->each(function($p){
    					$d = Carbon::parse($p->created_at);
    					$p->plan_title = $d->shortEnglishDayOfWeek . "_" . $d->isoFormat('YYYY_MM_DD') . "_plan";
    				});
    	return $plans;
    }

    function loadPlan($id)
    {
    	$plan = Plan::where('plan_id', $id)->pluck('plan');
    	return $plan[0];
    }

    function saveCurrent($plan)
    {

    }
}
