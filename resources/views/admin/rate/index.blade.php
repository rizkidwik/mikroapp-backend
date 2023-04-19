@extends('layouts.default')
@section('title','Rate Limit')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Rate Limit</h1>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center"  >
            <h6 class="m-0 font-weight-bold text-primary">Rate Limit Data</h6>
            <div>
                <a href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <button type="button" class="btn btn-primary" href="javascript:void(0)" id="createNewRate">
                        Tambah Rate Limit
                      </button>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rate Limit</th>
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
                <form id="rateForm" name="rateForm" class="form-horizontal">
                   <input type="hidden" name="rate_id" id="rate_id">
                    <div class="form-group">
                        <label for="rate_limit" class="col-sm control-label">Rate Limit</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="rate_limit" name="rate_limit" placeholder="Masukkan Rate Limit(tx/rx)" value="" required="">
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
              ajax: "{{ route('rates.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'rate_limit', name: 'rate_limit'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });

          /*------------------------------------------
          --------------------------------------------
          Click to Button
          --------------------------------------------
          --------------------------------------------*/
          $('#createNewRate').click(function () {
              $('#saveBtn').val("create-rate");
              $('#rate_id').val('');
              $('#rateForm').trigger("reset");
              $('#modelHeading').html("Create New Rate");
              $('#ajaxModel').modal('show');
          });

          /*------------------------------------------
          --------------------------------------------
          Click to Edit Button
          --------------------------------------------
          --------------------------------------------*/
          $('body').on('click', '.edit', function () {
            var rate_id = $(this).data('id');
            $.get("{{ route('rates.index') }}" +'/' + rate_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Rate");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#rate_id').val(data.id);
                $('#rate_limit').val(data.rate_limit);
            })
          });

          /*------------------------------------------
          --------------------------------------------
          Create Rate Code
          --------------------------------------------
          --------------------------------------------*/
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');

              $.ajax({
                data: $('#rateForm').serialize(),
                url: "{{ route('rates.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#rateForm').trigger("reset");
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
          Delete Rate Code
          --------------------------------------------
          --------------------------------------------*/
          $('body').on('click', '.deleteRate', function () {

              var rate_id = $(this).data("id");
              confirm("Are You sure want to delete !");

              $.ajax({
                  type: "DELETE",
                  url: "{{ route('rates.store') }}"+'/'+rate_id,
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
