@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.Select2', true)
@section('title', 'PPOB New')


@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Top Up Balance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Top Up Balance</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('error'))
        <x-adminlte-alert theme="danger" title="Failed" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif
            <div class="card">
                <form action="{{ route('topup.pay') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-input id="iAmount" name="iAmount" label="Top Up Amount" placeholder="Input an amount..."
                                label-class="text-lightblue" type="number" igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-button label="10.000" theme="info" onclick="setValue(10000)"/>
                            <x-adminlte-button label="50.000" theme="info" onclick="setValue(50000)"/>
                            <x-adminlte-button label="100.000" theme="info" onclick="setValue(100000)"/>
                            <x-adminlte-button label="500.000" theme="info" onclick="setValue(500000)"/>
                        </div>
                        <div class="form-group">
                            <x-adminlte-select2 name="sMethod" label="Payment Method" label-class="text-lightblue"
                                igroup-size="md" data-placeholder="Select an option...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-credit-card text-lightblue"></i>
                                    </div>
                                </x-slot>
                                <option />
                                <option value="BANK TRANSFER">BANK TRANSFER</option>
                                <option value="VIRTUAL ACCOUNT">VIRTUAL ACCOUNT</option>
                            </x-adminlte-select2>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <button type="submit" class="btn btn-block btn-success">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Latest Transactions</h3>
        </div>

        <div class="card-body">
            @php
                $heads = [
                    'Date',
                    'User',
                    'Transaction',
                    'Balance',
                ];
                $config = [
                    'order' => [[0, 'desc']],
                ];
            @endphp

            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable>
                @foreach ($items as $item)
                    <tr>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{number_format($item->total_amount,2,",",".")}}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>

    </div>


@stop

@section('css')
@stop

@section('js')
<script>
    function setValue(amount) {
        document.getElementById('iAmount').value = amount;
    }
</script>
@stop
