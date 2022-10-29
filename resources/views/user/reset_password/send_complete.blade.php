@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">パスワードリセットメールを送信しました。</div>

                    <a href="{{ route('login') }}">TOPへ</a>
                </div>
            </div>
        </div>
    </div>
@endsection