<?php
namespace App\Calendar;
use Carbon\Carbon;
use App\Book;
use App\Income;

class CalendarWeekDay {
	protected $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}

	function getClassName(){
		return "day-" . strtolower($this->carbon->format("D"));
	}

	/**
	 * @return 
	 */
	function render(){
		return '<p class="day">' . $this->carbon->format("j"). '</p></a>';
	}
	
	function numberDay(){
		$date = $this->carbon->format("Y-m-d");
		return $date;
	}
	
	function sumPrice(){
		$books = Book::where([['user_id', \Auth::user()->id], ['date', $this->carbon->format("Y-m-d")]])->get();
        // 変数の中身を初期化
        $prices = null;
        foreach($books as $column){
            $prices += $column->price;
        }
        // $pricesがnullじゃない場合、"円"を結合する
        if($prices){
        	$prices .= "円";
        }
        
        return $prices;
	}
	
	function sumIncome(){
		$income_books = Income::where([['user_id', \Auth::user()->id], ['date', $this->carbon->format("Y-m-d")]])->get();
        // 変数の中身を初期化
        $incomes = null;
        foreach($income_books as $column){
            $incomes += $column->income;
        }
        // $pricesがnullじゃない場合、"円"を結合する
        if($incomes){
        	$incomes .= "円";
        }
        return $incomes;
	}

}