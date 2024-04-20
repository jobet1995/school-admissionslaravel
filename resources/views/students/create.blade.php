@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/students?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="student_first_name">First Name</label>
                <input id="student_first_name" name="first_name" value="{{old('first_name')}}" maxlength="50" />
                @error('first_name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_last_name">Last Name</label>
                <input id="student_last_name" name="last_name" value="{{old('last_name')}}" maxlength="50" />
                @error('last_name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_email">Email</label>
                <input id="student_email" name="email" value="{{old('email')}}" type="email" maxlength="50" />
                @error('email')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_date_of_birth">Date Of Birth</label>
                <input id="student_date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}" data-type="date" autocomplete="off" />
                @error('date_of_birth')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_phone">Phone</label>
                <input id="student_phone" name="phone" value="{{old('phone')}}" maxlength="50" />
                @error('phone')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_street_address">Street Address</label>
                <input id="student_street_address" name="streetAddress" value="{{old('streetAddress')}}" maxlength="50" />
                @error('streetAddress')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_city_address">City Address</label>
                <input id="student_city_address" name="cityAddress" value="{{old('cityAddress')}}" maxlength="50" />
                @error('cityAddress')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_postal_code">Postal Code</label>
                <input id="student_postal_code" name="postalCode" value="{{old('postalCode')}}" type="number" />
                @error('postalCode')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="student_province">Province</label>
                <input id="student_province" name="province" value="{{old('province')}}" maxlength="50" />
                @error('province')<span class="red-text">{{$message}}</span>@enderror
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