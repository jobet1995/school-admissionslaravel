@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/userRoles/{{$userRole->user_id}}/{{$userRole->role_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="user_role_user_id">User Id</label>
                <input readonly id="user_role_user_id" name="user_id" value="{{old('user_id', $userRole->user_id)}}" type="number" required />
                @error('user_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="user_role_role_id">Role Id</label>
                <input readonly id="user_role_role_id" name="role_id" value="{{old('role_id', $userRole->role_id)}}" type="number" required />
                @error('role_id')<span class="red-text">{{$message}}</span>@enderror
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