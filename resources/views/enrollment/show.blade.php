@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="enrollment_enrollment_id">Enrollment Id</label>
                <input readonly id="enrollment_enrollment_id" name="enrollment_id" value="{{$enrollment->enrollment_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="enrollment_student">Student</label>
                <input readonly id="enrollment_student" name="student" value="{{$enrollment->student}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="enrollment_course">Course</label>
                <input readonly id="enrollment_course" name="course" value="{{$enrollment->course}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="enrollment_enrollment_date">Enrollment Date</label>
                <input readonly id="enrollment_enrollment_date" name="enrollment_date" value="{{$enrollment->enrollment_date}}" data-type="date" autocomplete="off" />
            </div>
            <div class="col m6 l4">
                <label for="enrollment_grade">Grade</label>
                <input readonly id="enrollment_grade" name="grade" value="{{$enrollment->grade}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/enrollments/{{$enrollment->enrollment_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection