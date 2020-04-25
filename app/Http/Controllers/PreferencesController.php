<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Preference;

class PreferencesController extends Controller
{
	function get(Request $request)
	{
		return Preference::where('user_id', $request->user_id)->pluck('darkmode');
	}	

	function set(Request $request)
	{
		$pref = Preference::where('user_id', $request->user_id)->first();
		if($pref) {
			$pref->darkmode = $request->darkmode;
			$pref->save();
			return $pref;
		} else {
			$pref = new Preference;
			$pref->user_id = $request->user_id;
			$pref->darkmode = $request->darkmode;
			$pref->save();
			return $pref;
		}
	}
}
