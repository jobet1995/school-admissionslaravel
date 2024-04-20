@extends('layout')
@section('content')
<div class="container">
    <div class="center-container">
        <div class="card-box">
            <div class="card card-width">
                <div class="card-content">
                    <span class="card-title">Change Password</span>
                    <i class="login mdi mdi-account-circle"></i>
                    <form method="post" action="/admin/changePassword/{{$token}}" onsubmit="return validateForm()">
                        @csrf
                        <div class="row">
                            <div class="col s12">
                                <label for="user_account_password">Password</label>
                                <input id="user_account_password" name="password" value="{{old('password')}}" type="password" required maxlength="100" />
                            </div>
                            <div class="col s12">
                                <label for="user_account_password2">Confirm password</label>
                                <input data-match="user_account_password" id="user_account_password2" name="password2" value="{{old('password')}}" type="password" required maxlength="100" />
                            </div>
                            <div class="col s12">
                                <button class="btn-small grey fit">Change Password</button>
                            </div>
                        </div>
                    </form>
                    @if(isset($success))<span class="green-text">Change password done</span>@endif
                    @if(isset($error))<span class="red-text">Token not found!</span>@endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection