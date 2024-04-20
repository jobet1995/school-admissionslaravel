@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="student_student_id">Student Id</label>
                <input readonly id="student_student_id" name="student_id" value="{{$student->student_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="student_first_name">First Name</label>
                <input readonly id="student_first_name" name="first_name" value="{{$student->first_name}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_last_name">Last Name</label>
                <input readonly id="student_last_name" name="last_name" value="{{$student->last_name}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_email">Email</label>
                <input readonly id="student_email" name="email" value="{{$student->email}}" type="email" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_date_of_birth">Date Of Birth</label>
                <input readonly id="student_date_of_birth" name="date_of_birth" value="{{$student->date_of_birth}}" data-type="date" autocomplete="off" />
            </div>
            <div class="col m6 l4">
                <label for="student_phone">Phone</label>
                <input readonly id="student_phone" name="phone" value="{{$student->phone}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_street_address">Street Address</label>
                <input readonly id="student_street_address" name="streetAddress" value="{{$student->streetAddress}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_city_address">City Address</label>
                <input readonly id="student_city_address" name="cityAddress" value="{{$student->cityAddress}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="student_postal_code">Postal Code</label>
                <input readonly id="student_postal_code" name="postalCode" value="{{$student->postalCode}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="student_province">Province</label>
                <input readonly id="student_province" name="province" value="{{$student->province}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/students/{{$student->student_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection