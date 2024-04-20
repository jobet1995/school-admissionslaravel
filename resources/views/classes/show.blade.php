@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="class_class_id">Class Id</label>
                <input readonly id="class_class_id" name="class_id" value="{{$class->class_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="class_student">Student</label>
                <input readonly id="class_student" name="student" value="{{$class->student}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="class_course">Course</label>
                <input readonly id="class_course" name="course" value="{{$class->course}}" type="number" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/classes/{{$class->class_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection