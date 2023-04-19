@extends('layouts.front.default')

@section('content')
    <div class="container pb-5 pt-5">
        <div class="row">
            <div class="col-12 col-md-8">
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
                                        @elseif ($order->status == 'deny')
                                            Payment Rejected
                                        @elseif ($order->status == 'cancel')
                                            Cancelled
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
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        @if ($order->status == 'pending')
                            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
                        @elseif($order->status == 'settlement')
                            Pembayaran berhasil
                        @elseif($order->status == 'deny' || $order->status == 'cancel')
                            Pembayaran gagal
                        @endif

                        @if ($order->pdf_url != null && $order->status == 'pending')
                            <a href="{{ $order->pdf_url }}" class="btn btn-warning">Cara Pembayaran</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- @if ($voucher)
                <div class="row mt-2">
            <div class="col-12 col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Data Voucher</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <tr>
                                <td>ID</td>
                                <td><b>#{{ $voucher->id }}</b></td>
                            </tr>
                            <tr>
                                <td>Kode Voucher</td>
                                <td><b>{{ $voucher->code }}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><b>{{ $voucher->status }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif --}}

    </div>
    </div>
    <form method="POST" action="" id="submit_form">
        @csrf
        <input type="hidden" name="json" id="json_callback">
    </form>
@endsection

@push('after-script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                    send_response_to_form(result);
                },
                // Optional
                onPending: function(result) {
                    send_response_to_form(result);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                    send_response_to_form(result);
                },
                onClose: function(result) {
                    location.reload();
                }
            });
        });
    </script>

    <script>
        function send_response_to_form(result) {
            document.getElementById('json_callback').value = JSON.stringify(result);

            // alert(document.getElementById('json_callback').value)
            $('#submit_form').submit();
        }
    </script>
@endpush
