@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/classes?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="class_class_id">Class Id</label>
                <input id="class_class_id" name="class_id" value="{{old('class_id')}}" type="number" required />
                @error('class_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="class_student">Student</label>
                <input id="class_student" name="student" value="{{old('student')}}" type="number" />
                @error('student')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="class_course">Course</label>
                <input id="class_course" name="course" value="{{old('course')}}" type="number" />
                @error('course')<span class="red-text">{{$message}}</span>@enderror
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