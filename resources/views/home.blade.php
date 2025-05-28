@extends('adminlte::page')
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'PPOB New')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Welcome {{ Auth::user()->name }}!</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rp {{ number_format($transactions,2,",",".") }}</h3>
                        <p>Total Transaction</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-poll"></i>
                    </div>
                    <a href="/history" class="small-box-footer">See All <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp {{ number_format(Auth::user()->wallet->balance, 2, ",", "." )  }}</h3>
                        <p>Balance</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <a href="/coming" class="small-box-footer">Top Up <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payments Point</h3>
            </div>

            <div class="card-body">
                <p>Top Up and Data Package</p>
                <a href="{{route('pulsa')}}" class="btn btn-app bg-info">
                    <i class="fas fa-mobile-alt"></i>
                    Pulsa
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-info">
                    <i class="fas fa-sim-card"></i>
                    Data Package
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-info">
                    <i class="far fa-credit-card"></i>
                    E-Money
                </a>
                <p>Payment and Bills</p>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-plug"></i>
                    PLN
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-burn"></i>
                    PDAM
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-satellite-dish"></i>
                    Internet
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-medkit"></i>
                    BPJS
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-fire-alt"></i>
                    PGN Gas
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-book"></i>
                    Multifinance
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-heartbeat"></i>
                    Insurance
                </a>
                <a href="{{route('coming')}}" class="btn btn-app bg-success">
                    <i class="fas fa-graduation-cap"></i>
                    Education
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
