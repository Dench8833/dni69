@extends('layouts.app')


@section('title', 'DNI-69')

@section('content_header')

@stop

@section('content')
    <video autoplay loop id="video-background" muted>
        <source src="{{ asset('storage/mp4/mig.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <h1>Здесь будет морда сайта</h1>

        {{--<audio controls>
            <source src="{{asset('storage/songs/Тверь/RedHotChiliPeppers-ByTheWay.mp3')}}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>--}}
    </div>


@stop
