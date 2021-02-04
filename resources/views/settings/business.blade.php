@extends('layouts.app')

@section('title', 'Business Settings')

@section('content')
    <div class="px-3 pt-3 pb-3 mt-4 business_settings">
        @include('settings.partials.nav')
        <div class="panel bg-gradient-dark rounded padding active mt-3" id="general">
            @include('settings.partials.general')
        </div>
        <div class="panel bg-gradient-dark rounded padding mt-3" id="banks">
            @include('settings.partials.banks')
        </div> 
        <div class="panel bg-gradient-dark rounded padding mt-3" id="positions">
            @include('settings.partials.positions')
        </div>
    </div>
@endsection
