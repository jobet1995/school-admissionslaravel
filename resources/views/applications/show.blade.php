@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="applications_application_id">Application Id</label>
                <input readonly id="applications_application_id" name="application_id" value="{{$applications->application_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="applications_student">Student</label>
                <input readonly id="applications_student" name="student" value="{{$applications->student}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="applications_course">Course</label>
                <input readonly id="applications_course" name="course" value="{{$applications->course}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="applications_application_date">Application Date</label>
                <input readonly id="applications_application_date" name="application_date" value="{{$applications->application_date}}" data-type="date" autocomplete="off" />
            </div>
            <div class="col m6 l4">
                <label for="applications_status">Status</label>
                <input readonly id="applications_status" name="status" value="{{$applications->status}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/applicationses/{{$applications->application_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection