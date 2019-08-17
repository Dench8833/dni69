@extends('adminlte::page')

@section('title', 'DNI69')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('admin') }}
    </div>
@stop

@section('content')
    @include('admin.flash-message')
    <div class="container-fluid">
        <p>You are logged in!</p>
    </div>
@endsection

