@extends('layout')
@section('content')
<div class="container">
    <form method="post" action="/admin/programs/{{$program->program_id}}?ref={{urlencode($ref)}}">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col m6 l4">
                <label for="program_program_id">Program Id</label>
                <input readonly id="program_program_id" name="program_id" value="{{old('program_id', $program->program_id)}}" type="number" required />
                @error('program_id')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="program_program_name">Program Name</label>
                <input id="program_program_name" name="program_name" value="{{old('program_name', $program->program_name)}}" maxlength="50" />
                @error('program_name')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="program_description">Description</label>
                <input id="program_description" name="description" value="{{old('description', $program->description)}}" maxlength="50" />
                @error('description')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="program_requirements">Requirements</label>
                <input id="program_requirements" name="requirements" value="{{old('requirements', $program->requirements)}}" maxlength="50" />
                @error('requirements')<span class="red-text">{{$message}}</span>@enderror
            </div>
            <div class="col m6 l4">
                <label for="program_credits">Credits</label>
                <input id="program_credits" name="credits" value="{{old('credits', $program->credits)}}" maxlength="50" />
                @error('credits')<span class="red-text">{{$message}}</span>@enderror
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