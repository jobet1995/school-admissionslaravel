@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/enrollments/{{$enrollment->enrollment_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="enrollment_enrollment_id">Enrollment Id</label>
                <input readonly id="enrollment_enrollment_id" name="enrollment_id" value="{{old('enrollment_id', $enrollment->enrollment_id)}}" type="number" required />
                @error('enrollment_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="enrollment_student">Student</label>
                <input id="enrollment_student" name="student" value="{{old('student', $enrollment->student)}}" type="number" />
                @error('student')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="enrollment_course">Course</label>
                <input id="enrollment_course" name="course" value="{{old('course', $enrollment->course)}}" type="number" />
                @error('course')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="enrollment_enrollment_date">Enrollment Date</label>
                <input id="enrollment_enrollment_date" name="enrollment_date" value="{{old('enrollment_date', $enrollment->enrollment_date)}}" data-type="date" autocomplete="off" />
                @error('enrollment_date')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="enrollment_grade">Grade</label>
                <input id="enrollment_grade" name="grade" value="{{old('grade', $enrollment->grade)}}" maxlength="50" />
                @error('grade')<span class="red-text">{{$message}}</span>@enderror
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