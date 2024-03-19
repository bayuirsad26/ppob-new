@extends('adminlte::page')
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'PPOB New')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Account Information</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('profile.update')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="" name="name" value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="" name="email" value="{{ Auth::user()->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Verified At</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id=""
                                value="{{ Auth::user()->email_verified_at }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Save</button>
                </div>

            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Password</h3>
            </div>
            <form class="form-horizontal">
                <div class="card-body">
                    @php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))
                    @if (config('adminlte.use_route_url', false))
                        @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
                    @else
                        @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
                    @endif


                    @if ($password_reset_url)
                        <p class="my-0">
                            <a href="{{ $password_reset_url }}" class="btn btn-warning">
                                Reset Your Password </a>
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
