@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/faculties?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="faculty_faculty_name">Faculty Name</label>
                <input id="faculty_faculty_name" name="facultyName" value="{{old('facultyName')}}" maxlength="50" />
                @error('facultyName')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="faculty_email">Email</label>
                <input id="faculty_email" name="email" value="{{old('email')}}" type="email" required maxlength="50" />
                @error('email')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="faculty_phone">Phone</label>
                <input id="faculty_phone" name="phone" value="{{old('phone')}}" maxlength="50" />
                @error('phone')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="faculty_faculty_type">Faculty Type</label>
                <input id="faculty_faculty_type" name="facultyType" value="{{old('facultyType')}}" maxlength="50" />
                @error('facultyType')<span class="red-text">{{$message}}</span>@enderror
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