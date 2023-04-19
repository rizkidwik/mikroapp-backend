@extends('layouts.front.default')

@section('content')
<div class="container pb-5 pt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead class="thead-light">
                            <th scope="col">#</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->order_id }}</td>
                                    <td>{{ number_format($order->gross_amount, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($order->status == "pending")
                                            Menunggu Pembayaran
                                        @elseif ($order->status == "settlement")
                                            Sudah Dibayar
                                        @else
                                            Kadaluarsa
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-success">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
