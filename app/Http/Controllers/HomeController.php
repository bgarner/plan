<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Plan;
use App\Preference;
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
    public function index(Request $request)
    {
        $dt = new Carbon();
        $today = $dt->shortEnglishDayOfWeek . "_" . $dt->isoFormat('YYYY_MM_DD') . "_plan";

        if (Auth::check()) {
            $darkmode = Preference::where('user_id', Auth::user()->id)->pluck('darkmode');
            
            if(is_null($darkmode)) {
                $darkmode = 0;
            }

            $p = new Plan;
            $p->todays = $p->getTodaysPlan(Auth::user()->id);
            $p->prev_plans = $p->getPreviousPlans(Auth::user()->id);
            // dd($darkmode);
            return view('home')
                ->with("user_id", Auth::user()->id)
                ->with("today", $today)
                ->with("darkmode", $darkmode[0])
                ->with("plan", $p);
        }
        return view('home')
            ->with("today", $today);
    }
}
