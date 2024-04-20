@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/roles?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="role_name">Name</label>
                <input id="role_name" name="name" value="{{old('name')}}" required maxlength="50" />
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