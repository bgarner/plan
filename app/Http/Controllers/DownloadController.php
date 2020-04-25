<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use Carbon\Carbon;
use Storage;

class DownloadController extends Controller
{

	function single(Request $request)
	{
			$plan_id = $request->plan_id;
			$plan = Plan::where('plan_id', $request->plan_id)->first();
			$plan_day = $plan->created_at;			
			$today = $plan_day->shortEnglishDayOfWeek . "_" . $plan_day->isoFormat('YYYY_MM_DD') . "_plan";
			$filename = $today . ".txt";

			Storage::put($filename, $plan->plan);

			return response()->download($filename)->deleteFileAfterSend();
			//return Response::stream($callback, 200, $headers)->send();
	}
}
