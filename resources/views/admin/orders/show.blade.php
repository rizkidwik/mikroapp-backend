@extends('layouts.default')
@section('title', "$order->order_id")

@section('content')
    <div class="container pb-5 pt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Data Order</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <tr>
                                <td>ID</td>
                                <td><b>#{{ $order->order_id }}</b></td>
                            </tr>
                            <tr>
                                <td>Total Harga</td>
                                <td><b>Rp {{ number_format($order->gross_amount, 2, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td><b>
                                        @if ($order->status == 'pending')
                                            Menunggu Pembayaran
                                        @elseif ($order->status == 'settlement')
                                            Sudah Dibayar
                                        @else
                                            Kadaluarsa
                                        @endif
                                    </b></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><b>{{ $order->created_at->format('d M Y H:i') }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow mt-3">
                    <div class="card-header">
                        <h5>Data Voucher</h5>
                    </div>
                    <div class="card-body">
                        @if (!empty($voucher))
                            <div class="text-center">
                                <h3>VOUCHER</h3>
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <h2 class="bg-primary text-white p-3  text-center">{{ $voucher->code }}</h2>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
