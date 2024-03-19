@extends('adminlte::page')
@section('title', 'PPOB New')

@section('content_header')
<h1></h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="error-page">
        <h2 class="headline text-info"><i class="fas fa-exclamation-triangle text-info"></i> </h2>
        <div class="error-content">
            <h3>Oops! Page is coming soon.</h3>
            <p>
                We're currently working on this page and it will be available soon.
                Meanwhile, you may <a href="{{ url('/home') }}">return to the dashboard</a> or try another payment point features.
            </p>
        </div>

    </div>
</div>
    
@stop
