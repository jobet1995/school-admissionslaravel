@extends('layout')
@section('content')
<div class="container">
    <div class="center-container">
        <div class="card-box">
            <div class="card card-width">
                <div class="card-content">
                    <span class="card-title">Reset Password</span>
                    <i class="login mdi mdi-account-circle"></i>
                    <form method="post" action="/admin/resetPassword">
                        @csrf
                        <div class="row">
                            <div class="col s12">
                                <label for="user_account_email">Email</label>
                                <input id="user_account_email" name="email" value="{{old('email')}}" type="email" required maxlength="50" />
                            </div>
                            <div class="col s12">
                                <button class="btn-small grey fit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    @if(isset($success))<span class="green-text">A reset password link has been sent to your email</span>@endif
                    @if(isset($error))<span class="red-text">Email not found!</span>@endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection