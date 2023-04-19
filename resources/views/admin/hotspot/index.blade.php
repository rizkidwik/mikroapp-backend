@extends('layouts.default')
@section('title','Jenis Sampah')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">HOTSPOT</h1>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Hotspot User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Profile</th>

                            <th>Uptime</th>
                            <th>Bytes In</th>
                            <th>Bytes Out</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($response as $res)


                        <tr>
                            <td>{{ $res['.id'] }}</td>
                            <td>{{ $res['name'] }}</td>
                            <td>{{ isset($res['profile']) ? $res['profile'] : 'null' }}</td>
                            <td>{{ $res['uptime'] }}</td>
                            <td>{{ $res['bytes-in'] }}</td>
                            <td>{{ $res['bytes-out'] }}</td>
                            <td>{{ isset($res['comment']) ? $res['comment'] : 'null' }}</td>

                            <td>
                                <a href="" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center p-5">
                                Data tidak tersedia
                            </td>
                        </tr>
                        @endforelse







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
