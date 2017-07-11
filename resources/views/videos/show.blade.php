@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.menu')

{{ Form::open(array('url' => 'videos/metadata', 'method' => 'POST')) }}
{{ Form::hidden('id', $video->id) }}

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1>Showing {{ $video->title }}</h1>
    <div class="jumbotron">

        <div class="row">

            <div class="col-md-6 v-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <p>Metadata section:</p>
                        <div class="form-group">
                            {{ Form::label('keywords', 'Keywords') }} (comma separated)<br>
                            {{ Form::text('keywords', $keywords, Input::old('keywords'), array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('location_id', 'Location') }}
                            {{ Form::select('location_id', $locations, $selectedLocation, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 v-bottom text-right">
                <h4>
                    @if ($liked_video)
                    <a href="/videos/{{ $video->id }}/unlike"><i class="fa fa-thumbs-o-up"></i> unlike</a>
                    @else
                    <a href="/videos/{{ $video->id }}/like"><i class="fa fa-thumbs-o-up"></i> like</a>
                    @endif
                </h4>
            </div>
            
        </div>

        <video id="wwe_video" data-setup="{}" class="video-js vjs-default-skin vjs-big-play-centered"
           controls preload="auto" height="600" width="980">
            <source src="{{ url($video->file) }}" type="video/mp4" />
        </video>

        <script src="http://vjs.zencdn.net/6.2.0/video.js"></script>        
    </div>
{{ Form::close() }}

</div>

@endsection
