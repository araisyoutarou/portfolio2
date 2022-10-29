<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    // テーブルの紐付け
    protected $table = 'incomes';
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    // プライマリキー
    protected $primaryKey = 'income_id';
    
    // 更新可能カラム
    protected $fillable  = array(
        'income', 'income_spending', 'income_diary', 'user_id',
        );
        
    public static $rules = array(
        'income' => 'required|integer|digits_between:1,9|min:1|max:999999999',
        'income_spending' => 'required',
        'income_diary' => 'required|string|max:100',
    );
}
