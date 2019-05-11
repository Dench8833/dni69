@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('song.create') }}
    </div>
@stop

@section('content')
    @include('admin.flash-message')
    @include('admin.songs.forms.errors')
    <form method="post" enctype="multipart/form-data" action="{{route('song.store')}}">
        @csrf
        @include('admin.songs.forms.main_form')
    </form>
@stop