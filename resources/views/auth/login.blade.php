@extends('layout')
@section('content')
<div class="container">
    <div class="center-container">
        <div class="card-box">
            <div class="card card-width">
                <div class="card-content">
                    <span class="card-title">Login</span>
                    <i class="login mdi mdi-account-circle"></i>
                    <form method="post" action="/admin/login">
                        @csrf
                        <div class="row">
                            <div class="col s12">
                                <label for="user_account_email">Email</label>
                                <input id="user_account_email" name="email" value="{{old('email')}}" type="email" required maxlength="50" />
                            </div>
                            <div class="col s12">
                                <label for="user_account_password">Password</label>
                                <input id="user_account_password" name="password" value="{{old('password')}}" type="password" required maxlength="100" />
                            </div>
                            <div class="col s12">
                                <button class="btn-small grey fit">Login</button>
                                <a href="/admin/resetPassword">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                    @foreach($errors->all() as $message )<span class="red-text">{{$message}}</span>@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection