@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'PPOB New')


@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Top Up Pulsa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pulsa</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-secondary">
                <form action="{{ route('pulsa.pay') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-input name="iPhone" label="Phone Number" placeholder="Input a phone number..."
                                label-class="text-lightblue" type="number" igroup-size="md" required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-mobile-alt text-lightblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        @php
                            $brands = $products->pluck('brand')->unique();
                        @endphp

                        <!-- Provider -->
                        <x-adminlte-select2 id="sProvider" name="sProvider" label="Provider" label-class="text-lightblue"
                            igroup-size="md" data-placeholder="Select an option..." required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-sim-card text-lightblue"></i>
                                </div>
                            </x-slot>
                            <option />
                            @foreach ($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <!-- Nominal -->
                        <x-adminlte-select2 id="sSku" name="sSku" label="Total" label-class="text-lightblue"
                            igroup-size="md" data-placeholder="Select nominal..." required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-money-bill text-lightblue"></i>
                                </div>
                            </x-slot>
                            <option />
                        </x-adminlte-select2>

                        <input type="hidden" name="price" id="priceInput">




                        {{-- <div class="form-group">
                            <x-adminlte-select2 name="sProvider" label="Provider" label-class="text-lightblue"
                                igroup-size="md" data-placeholder="Select an option...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-sim-card text-lightblue"></i>
                                    </div>
                                </x-slot>
                                <option />
                                <option value="tsel">Telkomsel</option>
                                <option value="indosat">Indosat Ooredoo</option>
                                <option value="xl">XL Axiata</option>
                                <option value="tri">Tri (3)</option>
                                <option value="smartfren">Smartfren</option>
                                <option value="axis">AXIS</option>
                                <option value="ceria">Ceria</option>
                                <option value="im3">IM3</option>
                            </x-adminlte-select2>
                        </div> --}}
                        {{-- <div class="form-group">
                            <x-adminlte-select2 name="sSku" label="Total" label-class="text-lightblue"
                                igroup-size="md" data-placeholder="Select an option...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill text-lightblue"></i>
                                    </div>
                                </x-slot>
                                <option />
                                <option value="5000">5.000</option>
                                <option value="10000">10.000</option>
                                <option value="15000">15.000</option>
                                <option value="20000">20.000</option>
                                <option value="25000">25.000</option>
                                <option value="50000">50.000</option>
                                <option value="100000">100.000</option>
                            </x-adminlte-select2>
                        </div> --}}
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <button type="submit" class="btn btn-block btn-success">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-12 col-lg-6">
            @if (session('success'))
                <x-adminlte-callout theme="success"  icon="fas fa-lg fa-thumbs-up" title="Done">
                    <i class="text-dark">{{ session('success') }}</i>
                    <br>
                    <i class="text-dark">Please contact Admin!</i>
                    <br> <br>
                    Email:
                    <a href="mailto:admin@admin.com">admin@admin.com</a>
                </x-adminlte-callout>
            @endif

            @if (session('error'))
                <x-adminlte-callout theme="danger"  icon="fas fa-times" title="Failed">
                    <i class="text-dark">{{ session('error') }}</i>
                    <br>
                    <i class="text-dark">Please contact Admin!</i>
                    <br> <br>
                    Email:
                    <a href="mailto:admin@admin.com">admin@admin.com</a>
                </x-adminlte-callout>
            @endif
        </div>
    </div>


@stop

@section('css')
@stop

@section('js')
<script>
    $(document).ready(function () {
        const allProducts = @json($products);
        const priceInput = document.getElementById('priceInput');

        $('#sProvider').on('change', function () {
            const selectedBrand = $(this).val();

            const filtered = allProducts.filter(p => p.brand === selectedBrand);

            const $amountSelect = $('#sSku');
            $amountSelect.empty().append('<option></option>');

            filtered.forEach(p => {
                $amountSelect.append(
                    $('<option>', {
                        value: p.sku,
                        text: `${p.name} - Rp${new Intl.NumberFormat().format(p.price)}`
                    })
                );
            });

            $amountSelect.trigger('change.select2'); // penting untuk Select2 refresh
        });
        $('#sSku').on('change', function () {
            const filtered = allProducts.filter(p => p.sku === $(this).val());
            const price = filtered[0].price;

            $('#priceInput').val(price || '');
        });
    });
</script>

@stop
