<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek {

	protected $carbon;
	protected $index = 0;

// $dateは、calendarviewの初日を引数にしている。
// 15行目では、今月の１日を$this->carbonに代入している。
// $this->carbonは、8行目とつながっている。
	function __construct($date, $index = 0){
		$this->carbon = new Carbon($date);
		$this->index = $index;
	}

	function getClassName(){
		return "week-" . $this->index;
	}

	/**
	 * @return CalendarWeekDay[]
	 */
	function getDays(){

		$days = [];

		//開始日〜終了日
		$startDay = $this->carbon->copy()->startOfWeek();
		$lastDay = $this->carbon->copy()->endOfWeek();

		//作業用
		$tmpDay = $startDay->copy();

		//月曜日〜日曜日までループ
		//作業日が月末以下である限りループする
		while($tmpDay->lte($lastDay)){

			//前の月、もしくは後ろの月の場合は空白を表示
			if($tmpDay->month != $this->carbon->month){
				$day = new CalendarWeekBlankDay($tmpDay->copy());
				$days[] = $day;
				$tmpDay->addDay(1);
				continue;	
			}
				
			//今月
			$day = new CalendarWeekDay($tmpDay->copy());	
			$days[] = $day;
			//翌日に移動
			$tmpDay->addDay(1);
		}
		
		return $days;
	}
}