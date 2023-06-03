@extends('layouts.default')
@section('title', 'Order')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Order</h1>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Order</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Status Pembayaran</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>{{ number_format($order->gross_amount, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            Menunggu Pembayaran
                                        @elseif ($order->status == 'settlement')
                                            Sudah Dibayar
                                        @else
                                            Kadaluarsa
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success">
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



@endsection
@push('after-style')
    <!-- Custom styles for this page -->
    <link href="{{ asset('back_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('after-script')
    <!-- Page level plugins -->
    <script src="{{ asset('back_assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('back_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('back_assets/js/demo/datatables-demo.js') }}"></script>
@endpush
