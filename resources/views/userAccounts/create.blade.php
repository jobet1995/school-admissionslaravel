@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/userAccounts?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="user_account_name">Name</label>
                <input id="user_account_name" name="name" value="{{old('name')}}" required maxlength="50" />
                @error('name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="user_account_email">Email</label>
                <input id="user_account_email" name="email" value="{{old('email')}}" type="email" required maxlength="50" />
                @error('email')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label>
                    <input id="user_account_active" name="active" class="filled-in" type="checkbox" value="1" {{old('active') ? 'checked' : ''}} />
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
                        <input id="user_role_role_id{{$role->id}}" name="role_id[]" type="checkbox" class="filled-in" value="{{$role->id}}" />
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