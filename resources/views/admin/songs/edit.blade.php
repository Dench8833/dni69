@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('song.edit', $id) }}
    </div>
@stop

@section('content')
    @include('admin.flash-message')
    @include('admin.songs.forms.errors')
    <div class="text-right">
        <button type="button" class="btn btn-success">
            <a href="{{ url('admin/song/show/'.$id) }}">
                <span style="color: white;">Просмотр</span>
            </a>
        </button>
    </div>
    <form method="post" action="{{ route('song.update') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.songs.forms.main_form')
    </form>
@stop
