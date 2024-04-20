@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="program_program_id">Program Id</label>
                <input readonly id="program_program_id" name="program_id" value="{{$program->program_id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="program_program_name">Program Name</label>
                <input readonly id="program_program_name" name="program_name" value="{{$program->program_name}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="program_description">Description</label>
                <input readonly id="program_description" name="description" value="{{$program->description}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="program_requirements">Requirements</label>
                <input readonly id="program_requirements" name="requirements" value="{{$program->requirements}}" maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="program_credits">Credits</label>
                <input readonly id="program_credits" name="credits" value="{{$program->credits}}" maxlength="50" />
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/programs/{{$program->program_id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection