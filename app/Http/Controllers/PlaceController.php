<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Income;

class PlaceController extends Controller
{
    public function show(Request $request)
    {
        date_default_timezone_set('UTC');
		$year = $request->year;
		$month = $request->month;
		$syokuhi = 0;
		$gaisyoku = 0;
		$nitiyouhin = 0;
		$suidoukounetuhi = 0;
		$tuusinnhi = 0;
		$koutuuhi = 0;
		$cardkessai = 0;
		$zeikin = 0;
		$sonota = 0;
		$message = null;
		$yearSelection = config('select_year.select_year');
		$monthSelection = config('select_month.select_month');
		
		if(!preg_match('/^(20)[1-2][0-9]/', $year) || (!preg_match('/(0[1-9]|1[0-2])/', $month) && $month != 'year')){
			$year = date('Y');
			$month = date('m');
		}
		
		if($month != 'year'){
		    $condYearMonth = $year . '-' . $month;
		}
		
        // ソート済みの配列を返す
        $keys = ['食費','外食','日用品','水道光熱費','通信費','交通費','カード決済','税金','その他'];
        // 前方一致
        if($month == 'year'){
            $spendings = Book::where([['user_id', \Auth::user()->id]])->where('date', 'like', $year . '%')->get();
        } else{
            $spendings = Book::where([['user_id', \Auth::user()->id]])->where('date', 'like', $condYearMonth . '%')->get();
        }
        
        foreach($spendings as $spending){
            switch($spending->spending){
                case '食費':
                $syokuhi += $spending->price;
                break;
                
                case '外食':
                $gaisyoku += $spending->price;
                break;
                
                case '日用品':
                $nitiyouhin += $spending->price;
                break;
                
                case '水道光熱費':
                $suidoukounetuhi += $spending->price;
                break;
                
                case '通信費':
                $tuusinnhi += $spending->price;
                break;
                
                case '交通費':
                $koutuuhi += $spending->price;
                break;
                
                case 'カード決済':
                $cardkessai += $spending->price;
                break;
                
                case '税金':
                $zeikin += $spending->price;
                break;
                
                default:
                $sonota += $spending->price;
                break;
            }
        }
        
        $counts = [$syokuhi,$gaisyoku,$nitiyouhin,$suidoukounetuhi,$tuusinnhi,$koutuuhi,$cardkessai,$zeikin,$sonota];
        
        if($counts == [0,0,0,0,0,0,0,0,0]){
            $message = '保存しているデータが無いため、グラフを表示できません';
        }
      
        // 支出の合計
        if($month != 'year'){
            $books = Book::where([['user_id', \Auth::user()->id]])->where('date', 'like', $condYearMonth . '%')->get();
        }else{
            $books = Book::where([['user_id', \Auth::user()->id]])->where('date', 'like', $year . '%')->get();
        }
        
        $prices = 0;
        foreach($books as $column){
            $prices += $column->price;
        }
        
        // 収入の合計
        if($month != 'year'){
            $income_books = Income::where([['user_id', \Auth::user()->id]])->where('date', 'like', $condYearMonth . '%')->get();
        }else{
            $income_books = Income::where([['user_id', \Auth::user()->id]])->where('date', 'like', $year . '%')->get();
        }
        
        $incomes = 0;
        foreach($income_books as $column){
            $incomes += $column->income;
        }
        
        return view('chart',['year' => $year, 'month' => $month, 'keys' => $keys, 'counts' => $counts, 'prices' => $prices, 'books' => $books, 
        'incomes' => $incomes, 'income_books' => $income_books, 'message' => $message, "monthSelection" => $monthSelection, "yearSelection" => $yearSelection]);
   }
}
