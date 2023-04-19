@extends('layouts.default')
@section('title','Voucher')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Voucher</h1>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center"  >
            <h6 class="m-0 font-weight-bold text-primary">Voucher Data</h6>
            <div>
                {{-- <a href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <button type="button" class="btn btn-primary" href="javascript:void(0)" id="createNewProduct">
                        Tambah Produk
                      </button>
                </a> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Code</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Harga</label>
                        <div class="col-sm-12">
                            <textarea id="price" name="price" required="" placeholder="Masukkan Harga" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Durasi</label>
                        <div class="col-sm-12">
                            <textarea id="duration" name="duration" required="" placeholder="Masukkan Durasi" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
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


    <script type="text/javascript">
        $(function () {

          /*------------------------------------------
           --------------------------------------------
           Pass Header Token
           --------------------------------------------
           --------------------------------------------*/
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });

          /*------------------------------------------
          --------------------------------------------
          Render DataTable
          --------------------------------------------
          --------------------------------------------*/
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('voucher.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'product.name', name: 'product.name'},
                  {data: 'code', name: 'code'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });

          /*------------------------------------------
          --------------------------------------------
          Click to Button
          --------------------------------------------
          --------------------------------------------*/
          $('#createNewProduct').click(function () {
              $('#saveBtn').val("create-product");
              $('#product_id').val('');
              $('#productForm').trigger("reset");
              $('#modelHeading').html("Create New Product");
              $('#ajaxModel').modal('show');
          });

          /*------------------------------------------
          --------------------------------------------
          Click to Edit Button
          --------------------------------------------
          --------------------------------------------*/
          $('body').on('click', '.editProduct', function () {
            var product_id = $(this).data('id');
            $.get("{{ route('product.index') }}" +'/' + product_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#product_id').val(data.id);
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#duration').val(data.duration);
            })
          });

          /*------------------------------------------
          --------------------------------------------
          Create Product Code
          --------------------------------------------
          --------------------------------------------*/
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');

              $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('product.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#productForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
          });

          /*------------------------------------------
          --------------------------------------------
          Delete Product Code
          --------------------------------------------
          --------------------------------------------*/
          $('body').on('click', '.deleteProduct', function () {

              var product_id = $(this).data("id");
              confirm("Are You sure want to delete !");

              $.ajax({
                  type: "DELETE",
                  url: "{{ route('product.store') }}"+'/'+product_id,
                  success: function (data) {
                      table.draw();
                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          });

        });
      </script>
@endpush
