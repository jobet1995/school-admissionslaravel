@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="admission_decision_rec_id">Rec Id</label>
                <input readonly id="admission_decision_rec_id" name="rec_id" value="{{$admissionDecision->rec_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_application">Application</label>
                <input readonly id="admission_decision_application" name="application" value="{{$admissionDecision->application}}" type="number" />
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision_date">Decision Date</label>
                <input readonly id="admission_decision_decision_date" name="decision_date" value="{{$admissionDecision->decision_date}}" data-type="date" autocomplete="off" />
            </div>
            <div class="col m6 l4">
                <label for="admission_decision_decision">Decision</label>
                <input readonly id="admission_decision_decision" name="decision" value="{{$admissionDecision->decision}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/admissionDecisions/{{$admissionDecision->rec_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection