<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // テーブルの紐付け
    protected $table = 'books';
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    // プライマリキー
    protected $primaryKey = 'id';
    
    // 更新可能カラム
    protected $fillable  = array(
        'diary', 'spending', 'price', 'user_id',
        );
    
    public static $rules = array(
        'price' => 'required|integer|digits_between:1,9|min:1|max:999999999',
        'spending' => 'required',
        'diary' => 'required|string|max:100',
    );
    
}
