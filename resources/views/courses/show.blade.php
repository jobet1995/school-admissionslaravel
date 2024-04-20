@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="course_course_id">Course Id</label>
                <input readonly id="course_course_id" name="course_id" value="{{$course->course_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="course_course_name">Course Name</label>
                <input readonly id="course_course_name" name="course_name" value="{{$course->course_name}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="course_department">Department</label>
                <input readonly id="course_department" name="department" value="{{$course->department}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="course_credits">Credits</label>
                <input readonly id="course_credits" name="credits" value="{{$course->credits}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="course_program">Program</label>
                <input readonly id="course_program" name="program" value="{{$course->program}}" type="number" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/courses/{{$course->course_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection