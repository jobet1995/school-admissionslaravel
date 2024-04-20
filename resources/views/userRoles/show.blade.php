@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="user_role_user_id">User Id</label>
                <input readonly id="user_role_user_id" name="user_id" value="{{$userRole->user_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="user_role_role_id">Role Id</label>
                <input readonly id="user_role_role_id" name="role_id" value="{{$userRole->role_id}}" type="number" required />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/userRoles/{{$userRole->user_id}}/{{$userRole->role_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection