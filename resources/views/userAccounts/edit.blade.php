@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/userAccounts/{{$userAccount->id}}?ref={{urlencode($ref)}}" onsubmit="return validateForm()">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="user_account_id">Id</label>
                <input readonly id="user_account_id" name="id" value="{{old('id', $userAccount->id)}}" type="number" required />
                @error('id')<span class="red-text">{{$message}}</span>@enderror
            </div>
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
            <div class="col m6 l4">
                <label>
                    <input id="user_account_active" name="active" class="filled-in" type="checkbox" value="1" {{old('active', $userAccount->active) ? 'checked' : ''}} />
                    <span>Active</span>
                </label>
                @error('active')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col s12">
                <h5>
                </h5><label>Roles</label>
                @foreach ($roles as $role)
                <div>
                    <label>
                        <input id="user_role_role_id{{$role->id}}" name="role_id[]" type="checkbox" class="filled-in" value="{{$role->id}}" {{in_array($role->id, $userAccountUserRoles->pluck('role_id')->toArray()) ? 'checked' : ''}} />
                        <span>{{$role->name}}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Cancel</a>
                <button class="btn-small">Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
    initPage(true)
</script>
@endsection