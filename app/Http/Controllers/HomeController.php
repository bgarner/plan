<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Plan;
use Date;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dt = new Carbon();
        $today = $dt->shortEnglishDayOfWeek . "_" . $dt->isoFormat('YYYY_MM_DD') . "_plan";

        if (Auth::check()) {
            $plan = new Plan;
            $plan->todays = $plan->getTodaysPlan(Auth::user()->id);
            $plan->prev_plans = $plan->getPreviousPlans(Auth::user()->id);
            return view('home')
                ->with("today", $today)
                ->with("plan", $plan->todays)
                ->with("prev_plans", $plan->prev_plans);
        }
        return view('home')
            ->with("today", $today);
    }
}
