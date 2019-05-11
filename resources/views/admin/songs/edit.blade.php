@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('song.edit', $id) }}
    </div>
@stop

@section('content')
    @include('admin.flash-message')
    @include('admin.songs.forms.errors')
    <form method="post" action="{{route('song.update')}}" enctype="multipart/form-data">
        @csrf
        @include('admin.songs.forms.main_form')
    </form>
@stop