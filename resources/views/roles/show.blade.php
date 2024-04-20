@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="role_id">Id</label>
                <input readonly id="role_id" name="id" value="{{$role->id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="role_name">Name</label>
                <input readonly id="role_name" name="name" value="{{$role->name}}" required maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/roles/{{$role->id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection