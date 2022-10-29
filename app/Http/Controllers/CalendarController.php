<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarView;

class CalendarController extends Controller
{
    public function show(Request $request){
		date_default_timezone_set('UTC');
		$year = $request->year;
		$month = $request->month;
		
		$yearSelection = config('select_year.select_year');
		$monthSelection = config('select_month.select_month');
		
		if(!preg_match('/^(20)[1-2][0-9]/', $year) || (!preg_match('/(0[1-9]|1[0-2])/', $month) && $month != 'year')){
			$year = date('Y');
			$month = date('m');
		}
		
		if($month == 'year'){
			$calendar = array(
				new CalendarView(strtotime($year . '-01')),
				new CalendarView(strtotime($year . '-02')), 
		        new CalendarView(strtotime($year . '-03')), 
		        new CalendarView(strtotime($year . '-04')),
		        new CalendarView(strtotime($year . '-05')),
		        new CalendarView(strtotime($year . '-06')),
		        new CalendarView(strtotime($year . '-07')),
		        new CalendarView(strtotime($year . '-08')),
		        new CalendarView(strtotime($year . '-09')),
		        new CalendarView(strtotime($year . '-10')),
		        new CalendarView(strtotime($year . '-11')),
		        new CalendarView(strtotime($year . '-12'))
		       );
		} else{
			$calendar = array(new CalendarView(strtotime($year . '-' . $month)));
		}
		
		
		return view('calendar', ["calendar" => $calendar, "year" => $year, "month" => $month, "monthSelection" => $monthSelection, "yearSelection" => $yearSelection]);
	}
}
