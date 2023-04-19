@extends('layouts.default')
@section('title','Product')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Product</h1>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center"  >
            <h6 class="m-0 font-weight-bold text-primary">Product Data</h6>
            <div>
                <a href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">
                        Add Product
                      </button>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->duration }}</td>
                            <td>{{ $product->image }}</td>

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
                            <td colspan="6" class="text-center p-5">
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


<!-- Modal Add Product -->
<div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductLabel">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                  <label for="name">Nama Produk</label>
                  <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                  <label for="price">Harga</label>
                  <input type="number" class="form-control" id="price">
                </div>
                <div class="form-group">
                    <label for="duration">Durasi</label>
                    <input type="text" class="form-control" id="duration" aria-describedby="durationHelp">
                    <small id="durationHelp" class="form-text text-muted">Contoh : 30m ,1h,2h,3h</small>
                  </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>


@endsection
@push('after-style')
<!-- Custom styles for this page -->
<link href="{{ asset('back_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush

@push('after-script')
<!-- Page level plugins -->
<script src="{{ asset('back_assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('back_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('back_assets/js/demo/datatables-demo.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endpush
