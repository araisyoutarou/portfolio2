<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// パスワードリセット関連
Route::prefix('password_reset')->name('password_reset.')->group(function () {
    Route::prefix('email')->name('email.')->group(function () {
        // パスワードリセットメール送信フォームページ
        Route::get('/', [PasswordController::class, 'emailFormResetPassword'])->name('form');
        // メール送信処理
        Route::post('/', [PasswordController::class, 'sendEmailResetPassword'])->name('send');
        // メール送信完了ページ
        Route::get('/send_complete', [PasswordController::class, 'sendComplete'])->name('send_complete');
    });
    // パスワード再設定ページ
    Route::get('/edit', [PasswordController::class, 'edit'])->name('edit');
    // パスワード更新処理
    Route::post('/update', [PasswordController::class, 'update'])->name('update');
    // パスワード更新終了ページ
    Route::get('/edited', [PasswordController::class, 'edited'])->name('edited');
});


Auth::routes();
Route::group(['middleware' => 'auth'], function() {
   // カレンダー画面
   Route::get('/', 'CalendarController@show')->name('top_page');
   // 支出登録画面
   Route::get('calendar/memo', 'CalendarMemoController@show')->name('price_page');
   // データ画面
   Route::get('debug', 'DebugController@show')->name('debug');
   // パラメータ＿支出
   Route::get('calendar/memo/index', 'CalendarMemoController@index')->name('index_page');
   // 収入登録画面
   Route::get('calendar/income', 'CalendarIncomeController@show')->name('income_page');
   // パラメータ＿収入
   Route::get('calendar/income/index', 'CalendarIncomeController@index')->name('index_income_page');
   // 円グラフ
   Route::get('/chart', 'PlaceController@show')->name('chart_page');
   // 新規登録(支出)
   Route::post('/create', 'CalendarMemoController@create')->name('create_page');
   // 更新＆削除(支出)
   Route::post('/update_delete', 'CalendarMemoController@update')->name('update_delete_page');
   // 新規登録(収入)
   Route::post('/create_income', 'CalendarIncomeController@create')->name('create_income_page');
   // 更新＆削除(収入)
   Route::post('/update_income', 'CalendarIncomeController@update')->name('update_income_page');
});
