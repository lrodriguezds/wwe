@extends('layouts.app')

@section('content')
<div class="container">

@include('layouts.menu')

<h1>Liked videos</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Location</td>
            <td>Extra info</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
    @foreach($videos as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->title }}</td>
            <td>{{ $value->location->name }}</td>
            <td>
            Duration: {{ $value->duration }}<br>
            File size: {{ $value->file_size }}<br>
            Video format: {{ $value->format }}<br>
            Bit rate: {{ $value->bit_rate }}<br>
            </td>
            <td><a href="/videos/{{ $value->id }}" class="btn btn-success btn-small">View</a></td>
        </tr>
    @endforeach
    </tbody>
</table>



</div>
@endsection
