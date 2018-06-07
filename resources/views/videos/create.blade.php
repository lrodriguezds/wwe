@extends('layouts.app')

@section('content')
<div class="container">

@include('layouts.menu')

<h1>Upload a video</h1>

{{ Html::ul($errors->all()) }}

{{ Form::open(array('url' => 'videos', 'files' => true)) }}
<div class="row">
    
    <div class="col-md-6">
        <p>Video file section:</p>
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('video-file', 'Select an .mp4 video') }}
            {{ Form::file('video-file', ['class' => 'file']) }}
        </div>
    </div>

    <div class="col-md-6">
        <p>Metadata section:</p>
        <div class="form-group">
            {{ Form::label('keywords', 'Keywords') }} (comma separated)
            {{ Form::text('keywords', Input::old('keywords'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('location_id', 'Location') }}
            {{ Form::select('location_id', $locations, Input::old('location_id'), array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="col-md-12">
        {{ Form::submit('Upload!', array('class' => 'btn btn-primary')) }}
    </div>

</div>
{{ Form::close() }}

</div>
@endsection
