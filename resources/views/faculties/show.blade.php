@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="faculty_faculty_id">Faculty Id</label>
                <input readonly id="faculty_faculty_id" name="faculty_id" value="{{$faculty->faculty_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="faculty_faculty_name">Faculty Name</label>
                <input readonly id="faculty_faculty_name" name="facultyName" value="{{$faculty->facultyName}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="faculty_email">Email</label>
                <input readonly id="faculty_email" name="email" value="{{$faculty->email}}" type="email" required maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="faculty_phone">Phone</label>
                <input readonly id="faculty_phone" name="phone" value="{{$faculty->phone}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="faculty_faculty_type">Faculty Type</label>
                <input readonly id="faculty_faculty_type" name="facultyType" value="{{$faculty->facultyType}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/faculties/{{$faculty->faculty_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection