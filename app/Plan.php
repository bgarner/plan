<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Plan extends Model
{
		protected $table = 'plans';
		protected $fillable = ['id', 'plan_id', 'user_id', 'created_at', 'updated_at'];

    function getTodaysPlan($user_id)
    {
    	$plan = Plan::where('user_id', $user_id)
    						->whereRaw('Date(created_at) = CURDATE()')
    						->first();
        //dd($plan);
    	if(is_null($plan)){
    		return null;
    	} 
    	return $plan;
    }

    function getPreviousPlans($user_id)
    {
    	$plans = Plan::where('user_id', $user_id)
    				->where('created_at', '<', Carbon::today())
                    ->orderBy('created_at', 'desc')
    				->get()
    				->take(30)
    				->each(function($p){
    					$d = Carbon::parse($p->created_at);
    					$p->plan_title = $d->shortEnglishDayOfWeek . "_" . $d->isoFormat('YYYY_MM_DD') . "_plan";
    				});
    	if( count($plans) < 1){
    		return;
    	}
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
