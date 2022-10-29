<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class CalendarMemoController extends Controller
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
        
        $books = Book::where([['user_id', \Auth::user()->id], ['date', $selectedDate]])->get();
        // 変数の中身を初期化
        $prices = 0;
        foreach($books as $column){
            $prices += $column->price;
        
        }
        
        // 選択日付
        $showDate = date('Y年m月d日',  strtotime($selectedDate));
        
        return view('CalendarMemo', ['selectedDate' => $selectedDate, 'books' => $books, 'prices' => $prices, 'showDate' => $showDate]);
    }
    
    // 保存
    public function create(Request $request){
        // bookモデルにデータを保存
        // 保存した後は、CalendarMemoViewに飛ばす
        // Varidationを行う
        $request->validate(Book::$rules);
        $books = new Book;
        $books->price = $request->price;
        $books->spending = $request->spending;
        $books->diary = $request->diary;
        $books->user_id = $request->user()->id;
        $books->date = $request->selectedDate;
        
        $form = $request->all();
        // formから送られてきた_tokenを削除
        unset($form['_token']);
        // データベースに保存する
        $books->fill($form);
        $books->save();
        
        return redirect('calendar/memo?day='.$request->selectedDate);
    }
    
  
    // パラメータ
	public function index(Request $request)
	{
		$day = $request->day;

        return view('CalendarMemo')->with('day', $day);
	}
	
	// 更新、削除
    public function update(Request $request)
    {
        if($request->has('upd_book')){
            // 送信されてきたフォームデータを格納する
            $books_forms = $request->all();
            // formから送られてきた_tokenを削除
            unset($books_forms['_token']);
            unset($books_forms['delete']);
            // "book_update" => "一括更新"を除外する。
            array_pop($books_forms);
            // 配列を5つに分割する
            $books_forms = array_chunk($books_forms, 5, true);
            foreach($books_forms as $books_form){
                // 配列内の現在の要素を返す,配列の一部を展開する
                $id = current(array_slice($books_form, 0, 1, true));
                // 更新対象を検索
                $books = Book::find($id);
                $arr_book = array();
                $arr_book['price'] = current(array_slice($books_form, 1, 1, true));
                // 数値チェック
                if(!is_numeric($arr_book['price'])){
                    return redirect('calendar/memo?day='.$request->selectedDate);
                }
                $arr_book['spending'] = current(array_slice($books_form, 2, 1, true));
                $arr_book['diary'] = current(array_slice($books_form, 3, 1, true));
                if(!$arr_book['diary']){
                    return redirect('calendar/memo?day='.$request->selectedDate);
                }
                $arr_book['date'] = current(array_slice($books_form, 4, 1, true));
                // 該当するデータを上書きして保存する
                if($books != null){
                    $books->fill($arr_book);
                    $books->save();
                }
            }
            
        }elseif($request->has('del_book')){
            $books_id = array();
            // 該当するBook Modelを取得
            $books_forms = $request->all();
            $books_key = array_keys($books_forms);
            foreach($books_key as $book_key){
                // キーの名前がdelete-〇かチェックする
                if(preg_match('/delete/', $book_key)){
                    $books_id[] = $books_forms[$book_key];
                }
            }
            $books = Book::find($books_id);
            foreach($books as $book){
                $book->delete();
            }
        }
        
        return redirect('calendar/memo?day='.$request->selectedDate);

    }

}

