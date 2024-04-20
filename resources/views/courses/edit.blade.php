@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/courses/{{$course->course_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="course_course_id">Course Id</label>
                <input readonly id="course_course_id" name="course_id" value="{{old('course_id', $course->course_id)}}" type="number" required />
                @error('course_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="course_course_name">Course Name</label>
                <input id="course_course_name" name="course_name" value="{{old('course_name', $course->course_name)}}" maxlength="50" />
                @error('course_name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="course_department">Department</label>
                <input id="course_department" name="department" value="{{old('department', $course->department)}}" maxlength="50" />
                @error('department')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="course_credits">Credits</label>
                <input id="course_credits" name="credits" value="{{old('credits', $course->credits)}}" type="number" />
                @error('credits')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="course_program">Program</label>
                <input id="course_program" name="program" value="{{old('program', $course->program)}}" type="number" />
                @error('program')<span class="red-text">{{$message}}</span>@enderror
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