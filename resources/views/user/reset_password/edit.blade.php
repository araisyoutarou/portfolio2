@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新しいパスワードを設定</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password_reset.update') }}">
                            @csrf
                            <input type="hidden" name="reset_token" value="{{ $userToken->token }}">
                            <div class="input-group">
                                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                                <div class="col-md-6">
                                    <input type="password" name="password" class="input {{ $errors->has('password') ? 'incorrect' : '' }}">
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                    @error('token')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">パスワードを再入力</label>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" class="input {{ $errors->has('password_confirmation') ? 'incorrect' : '' }}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit">パスワードを再設定</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection