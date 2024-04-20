@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/applicationses/{{$applications->application_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="applications_application_id">Application Id</label>
                <input readonly id="applications_application_id" name="application_id" value="{{old('application_id', $applications->application_id)}}" type="number" required />
                @error('application_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="applications_student">Student</label>
                <input id="applications_student" name="student" value="{{old('student', $applications->student)}}" type="number" />
                @error('student')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="applications_course">Course</label>
                <input id="applications_course" name="course" value="{{old('course', $applications->course)}}" type="number" />
                @error('course')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="applications_application_date">Application Date</label>
                <input id="applications_application_date" name="application_date" value="{{old('application_date', $applications->application_date)}}" data-type="date" autocomplete="off" />
                @error('application_date')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="applications_status">Status</label>
                <input id="applications_status" name="status" value="{{old('status', $applications->status)}}" maxlength="50" />
                @error('status')<span class="red-text">{{$message}}</span>@enderror
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