<?php

namespace app\Common;

use Illuminate\Http\Request;
class MatchClass
{
    public static function match(Request $request)
    {
        $year = $request->year;
		$month = $request->month;
		if(!preg_match('/^(20)[1-2][0-9]/', $year) || (!preg_match('/(0[1-9]|1[0-2])/', $month) && $month != 'year')){
			$year = date('Y');
			$month = date('m');
		}
		
    }
}