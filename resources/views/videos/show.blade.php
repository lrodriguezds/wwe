@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.menu')

<h1>Showing {{ $video->title }}</h1>
    <div class="jumbotron">

        <div class="row">
            <div class="col-md-12">
                <h2><a href="#"><i class="fa fa-thumbs-o-up"></i></a> <a href="#"><i class="fa fa-thumbs-o-down"></i></a></h2>
            </div>
            <div class="col-md-12">
                <p>Keywords: 
                @foreach($video->keywords as $key => $value)
                    {{ $value->name }}   
                @endforeach
                </p>
            </div>
        </div>

        <video id="wwe_video" data-setup="{}" class="video-js vjs-default-skin vjs-big-play-centered"
           controls preload="auto" height="600" width="980">
            <source src="{{ url($video->file) }}" type="video/mp4" />
        </video>

        <script src="http://vjs.zencdn.net/6.2.0/video.js"></script>        
    </div>

</div>

@endsection
