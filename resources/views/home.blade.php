@extends('layouts.app')

@section('title', 'Dashboard ')

@section('content')
    <div class="container-fluid">
        <h1 class="display-4 where">Dashboard</h1>
        <div class="floats py-2">
            @include('home.floats')
        </div>
    </div>
@endsection
