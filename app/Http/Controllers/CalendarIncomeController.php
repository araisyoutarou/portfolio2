<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Income;

class CalendarIncomeController extends Controller
{
    public function show(Request $request){
        $selectedDate = $request->day;
        $format_str = '%Y-%m-%d';
        $is_date_str = strptime($selectedDate, $format_str);
        if(!$is_date_str)
        {
            return redirect('/');
        }
        
        list($year, $month, $day) = explode("-", $selectedDate);
        if (!checkdate($month, $day, $year))
        {
            return redirect('/');
        }
        
        $income_books = Income::where([['user_id', \Auth::user()->id], ['date', $request->day]])->get();
        // 変数の中身を初期化
        $incomes = 0;
        foreach($income_books as $column){
            // 代入を工夫
            $incomes += $column->income;
        }
        
        // 選択日付
        $showDate = date('Y年m月d日',  strtotime($selectedDate));

        return view('CalendarIncome', ['selectedDate' => $selectedDate, 'income_books' => $income_books, 'incomes' => $incomes, 'showDate' => $showDate]);
    }
    
    // 保存
    public function create(Request $request){
        // Incomeモデルにデータを保存
        // 保存した後は、CalendarMemoViewに飛ばす
        // Varidationを行う
        $request->validate(Income::$rules);
        $incomes = new Income;
        $incomes->income = $request->income;
        $incomes->income_spending = $request->income_spending;
        $incomes->income_diary = $request->income_diary;
        $incomes->user_id = $request->user()->id;
        $incomes->date = $request->selectedDate;
        
        $form = $request->all();
        // formから送られてきた_tokenを削除
        unset($form['_token']);
        // データベースに保存する
        $incomes->fill($form);
        $incomes->save();
        
        return redirect('calendar/income?day='.$request->selectedDate);
    }
    
    // パラメータ
	public function index(Request $request)
	{
		$day = $request->day;

        return view('CalendarIncome')->with('day', $day);
		
	}
	
    // 更新、削除
    public function update(Request $request)
    {
        if($request->has('upd_income')){
            // 送信されてきたフォームデータを格納する
            $incomes_forms = $request->all();
            // formから送られてきた_tokenを削除
            unset($incomes_forms['_token']);
            unset($incomes_forms['delete']);
            // "book_update" => "一括更新"を除外する。
            array_pop($incomes_forms);
            // 配列を4つに分割する
            $incomes_forms = array_chunk($incomes_forms, 5, true);
            foreach($incomes_forms as $incomes_form){
                // 配列内の現在の要素を返す,配列の一部を展開する
                $id = current(array_slice($incomes_form, 0, 1, true));
                // 更新対象を検索
                $incomes = Income::find($id);
                $arr_income = array();
                $arr_income['income'] = current(array_slice($incomes_form, 1, 1, true));
                // 数値チェック
                if(!is_numeric($arr_income['income'])){
                    return redirect('calendar/income?day='.$request->selectedDate);
                }
                $arr_income['income_spending'] = current(array_slice($incomes_form, 2, 1, true));
                $arr_income['income_diary'] = current(array_slice($incomes_form, 3, 1, true));
                if(!$arr_income['income_diary']){
                    return redirect('calendar/income?day='.$request->selectedDate);
                }
                $arr_income['date'] = current(array_slice($incomes_form, 4, 1, true));
                // 該当するデータを上書きして保存する
                if($incomes != null){
                    $incomes->fill($arr_income);
                    $incomes->save();
                }
            }
            
        }elseif($request->has('del_income')){
            $incomes_id = array();
            // 該当するBook Modelを取得
            $incomes_forms = $request->all();
            $incomes_key = array_keys($incomes_forms);
            foreach($incomes_key as $income_key){
                // キーの名前がdelete-〇かチェックする
                if(preg_match('/delete/', $income_key)){
                    $incomes_id[] = $incomes_forms[$income_key]; 
                }
            }
            $incomes = Income::find($incomes_id);
            foreach($incomes as $income){
                $income->delete();
            }
        }
        
        return redirect('calendar/income?day='.$request->selectedDate);

    }
}

