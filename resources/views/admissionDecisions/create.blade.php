@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/admissionDecisions?ref={{urlencode($ref)}}">
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="admission_decision_application">Application</label>
                <input id="admission_decision_application" name="application" value="{{old('application')}}" type="number" />
                @error('application')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision_date">Decision Date</label>
                <input id="admission_decision_decision_date" name="decision_date" value="{{old('decision_date')}}" data-type="date" autocomplete="off" />
                @error('decision_date')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision">Decision</label>
                <input id="admission_decision_decision" name="decision" value="{{old('decision')}}" maxlength="50" />
                @error('decision')<span class="red-text">{{$message}}</span>@enderror
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