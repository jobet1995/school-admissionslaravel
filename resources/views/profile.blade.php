@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/updateProfile" onsubmit="return validateForm()">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="user_account_name">Name</label>
                <input id="user_account_name" name="name" value="{{old('name', $userAccount->name)}}" required maxlength="50" />
                @error('name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="user_account_email">Email</label>
                <input id="user_account_email" name="email" value="{{old('email', $userAccount->email)}}" type="email" required maxlength="50" />
                @error('email')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="user_account_password">Password</label>
                <input id="user_account_password" name="password" type="password" placeholder="New password" maxlength="100" />
                @error('password')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="user_account_password2">Confirm password</label>
                <input data-match="user_account_password" id="user_account_password2" name="password2" type="password" placeholder="New password" maxlength="100" />
                @error('password')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col s12">
                <button class="btn-small">Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
    initPage(true)
</script>
@endsection