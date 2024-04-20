@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/admissionDecisions/{{$admissionDecision->rec_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="admission_decision_rec_id">Rec Id</label>
                <input readonly id="admission_decision_rec_id" name="rec_id" value="{{old('rec_id', $admissionDecision->rec_id)}}" type="number" required />
                @error('rec_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_application">Application</label>
                <input id="admission_decision_application" name="application" value="{{old('application', $admissionDecision->application)}}" type="number" />
                @error('application')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision_date">Decision Date</label>
                <input id="admission_decision_decision_date" name="decision_date" value="{{old('decision_date', $admissionDecision->decision_date)}}" data-type="date" autocomplete="off" />
                @error('decision_date')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision">Decision</label>
                <input id="admission_decision_decision" name="decision" value="{{old('decision', $admissionDecision->decision)}}" maxlength="50" />
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