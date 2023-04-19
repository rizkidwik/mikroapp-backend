@extends('layouts.default')
@section('title','Configuration')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Configuration</h1>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Config</h6>
        </div>
        <div class="card-body">
            {{-- <form action="{{ route('config.update', $config->id) }}" method="post" enctype="multipart/form-data"> --}}
            <form action="#" method="post" enctype="multipart/form-data" id="configForm">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $config->id }}">
                <div class="form-group">
                  <label for="host">Host</label>
                  <input type="text" class="form-control" id="host" name="host" value="{{ $config->host }}">
                </div>

                <div class="form-group">
                    <label for="host">Username</label>
                    <input type="text" class="form-control" id="user" name="user" value="{{ $config->user}}">
                  </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" value="{{ $config->pass }}">
                </div>

                <div class="form-group">
                    <label for="port">Port</label>
                    <input type="text" class="form-control" id="port" name="port" value="{{ $config->port}}">
                  </div>

                <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
              </form>
        </div>
    </div>
</div>

@endsection

@push('after-script')
<!-- Page level plugins -->


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
          Create Product Code
          --------------------------------------------
          --------------------------------------------*/
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');

              $.ajax({
                data: $('#configForm').serialize(),
                url: "{{ route('config.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log('sukses');


                    $.get( "http://localhost:8000/api/cek-koneksi")
                        .done(function(data){
                            alert( "Config saved successfully. Router Connected." );
                            $('#saveBtn').html('Save');
                            // console.log(data);
                        })
                        .fail(function(jqXHR){
                                alert("Router not connected!");
                                console.log(jqXHR.status);
                                $('#saveBtn').html('Save');
                        })

                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }


            });
          });


        });
      </script>
@endpush
