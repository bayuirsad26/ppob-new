@extends('adminlte::page')
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'PPOB New')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payment Points</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">This Week Transactions</h3>
            </div>

            <div class="card-body">
                @php
                    $heads = [
                        'Date',
                        'Payment ID',
                        'Transaction',
                        'Bill Amount',
                        'Fee Amount',
                        'Total Amount',
                        'Status',
                    ];
                    $config = [
                        'order' => [[0, 'desc']],
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->payment_id}}</td>
                            <td>{{$item->type}}</td>
                            <td>{{number_format($item->bill_amount,2,",",".")}}</td>
                            <td>{{number_format($item->fee_amount,2,",",".")}}</td>
                            <td>{{number_format($item->total_amount,2,",",".")}}</td>
                            <td>{{$item->status}}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>

        </div>


    </div>
@stop

@section('css')
@stop

@section('js')
@stop
