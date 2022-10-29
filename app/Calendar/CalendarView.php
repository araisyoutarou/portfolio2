<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarView {

	private $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}
	/**
	 * タイトル
	 * getTitle関数とは、題名（viewファイルで表示したカレンダーの〇年〇月）を取得する際に使用する。
	 */
	public function getTitle(){
		return $this->carbon->format('Y年n月');
	}

	/**
	 * カレンダーを出力する
	 */
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th class="saturday">土</th>';
        $html[] = '<th class="sunday">日</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';
		
		$html[] = '<tbody>';
		
		//getWeeksは、指定された年月日から、その日の曜日を算出する。
		$weeks = $this->getWeeks();
		foreach($weeks as $week){
			$html[] = '<tr class="'.$week->getClassName().'">';
			$days = $week->getDays();
			foreach($days as $day){
				// cssのクラス名動的
				$html[] = '<td class="'.$day->getClassName().'">';
				// パラメータ
				$html[] = '<a href="'.route('price_page', ['day' => $day->numberDay()]).'">';
                // カレンダーの数字
				$html[] = $day->render();
				// 支出の合計
				$html[] = '<p class="sumPrice">'.$day->sumPrice().'</p>';
				// 収支の合計
				$html[] = '<p class="sumIncome">'.$day->sumIncome().'</p>';
				$html[] = '</td>';
			}
			$html[] = '</tr>';
		}
		
		$html[] = '</tbody>';
		
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}
	
	//週の追加
	protected function getWeeks(){
		$weeks = [];

		//初日
		// firstOfMonthでは、取得する月数が決定されている。
		$firstDay = $this->carbon->copy()->firstOfMonth();
		

		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth();

		//1週目
		//初日を指定してCalendarWeekを実行している。
		$week = new CalendarWeek($firstDay->copy());
		$weeks[] = $week;

		//作業用の日
		$tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

		//月末までループさせる
		//作業日が月末以下である限りループする。
		while($tmpDay->lte($lastDay)){
			//週カレンダーViewを作成する
			$week = new CalendarWeek($tmpDay, count($weeks));
			$weeks[] = $week;
			
            //次の週=+7日する
			$tmpDay->addDay(7);
		}

		return $weeks;
	}
}