@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/roles/{{$role->id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="role_id">Id</label>
                <input readonly id="role_id" name="id" value="{{old('id', $role->id)}}" type="number" required />
                @error('id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="role_name">Name</label>
                <input id="role_name" name="name" value="{{old('name', $role->name)}}" required maxlength="50" />
                @error('name')<span class="red-text">{{$message}}</span>@enderror
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