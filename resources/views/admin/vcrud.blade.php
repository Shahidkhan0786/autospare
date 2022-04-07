@extends('admin.home')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- @section('pageheading','SuperUser') --}}
@section('breadcrum','vendor')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 margin-tb">

        <div class="pull-left">
          <h2>Vendors</h2>
        </div>
        <div class="float-right mb-2">
          <a class="btn btn-success" onClick="add()" href="javascript:void(0)">Create</a>
        </div>
      </div>
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
      @endif
      <div class="card-body">
        <table class="table table-bordered" id="ajax-crud-datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>

      <!-- edit admin model -->
<div class="modal fade" id="admin-edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-edit-title" id="editadmin"></h4>
        </div>
        <div class="modal-body">
          <form action="javascript:void(0)" id="editadminform" name="editadminform" class="form-horizontal" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="id" id="id1">
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="name1" name="name" placeholder="Enter admin Name"
                  maxlength="50" required="">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-12">
                <input type="email" class="form-control" id="email1" name="email" placeholder="Enter admin Email"
                  maxlength="50" required="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Address</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="address1" name="address" placeholder="Enter Admin Address"
                  required="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">location</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="location1" name="location" placeholder="Enter Admin location"
                  required="">
              </div>
            </div>
            {{-- <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-12">
                <input type="password" class="form-control" id="password" name="password"
                  placeholder="Enter Admin password" required="">
              </div>
            </div> --}}
            <div class="form-group">
              <label class="col-sm-2 control-label">cnic</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="cnic1" name="cnic" placeholder="Enter Admin cnic" required="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">cnic expiery</label>
              <div class="col-sm-12">
                <input type="date" class="form-control" id="cnicexp1" name="cnicexp" placeholder="Enter Admin cnic expiry"
                  required="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-12">
                <select class="custom-select" name="status" id="status1">
                  <option selected>Select one</option>
                  <option value="0">pending</option>
                  <option value="1">active</option>
  
                </select>
              </div>
            </div>
            <img src="" id="aimage1" alt="image" class="img-thumbnail" width="100" height="100" style="display:none">
            <div class="form-group">
              <label class="col-sm-2 control-label">Pic</label>
              <div class="col-sm-12">
                <input type="file" class="form-control" id="vendorpic" name="vendorpic" placeholder="admin pic">
              </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary" id="btn-update">create
              </button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>



      {{-- //end row --}}
    </div>
</div>    

@endsection


@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#ajax-crud-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('/admin/vendor') }}",
      columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        // { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false },
      ],

      order: [[0, 'desc']]
    });

    
  });

  function editFunc(id) {
        $.ajax({
      type: "GET",
      url: "{{ url('admin/vendoredit/{id}')}}",
      data: { id: id },
      dataType: 'json',
      success: function (res) {
        //   console.log(res);
          $('#editadmin').html("Edit Vendor");
          $('#admin-edit-modal').modal('show');
          $('#id1').val(res.id);
          $('#name1').val(res.user.name);
          $('#address1').val(res.address);
          $('#email1').val(res.user.email);
          $('#cnic1').val(res.cnic);
          $('#cnicexp1').val(res.cnicexpiry);
          $('#aimage1').css('display', 'block');
          $('#location1').val(res.location);
          $('#aimage1').attr('src', '/storage/'+res.pic);
          $('#status1').val(res.status).change();

      }
    });
    }

  // update 
  $('#editadminform').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
      type: 'POST',
      url: "{{ url('admin/vendorupdate')}}",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        $("#admin-edit-modal").modal('hide');
        console.log(data);
        var oTable = $('#ajax-crud-datatable').dataTable();
        oTable.fnDraw(false);
        $("#btn-save").html('Submit');
        $("#btn-save").attr("disabled", false);
      },
      error: function (data) {
        console.log(data);
      }
    });
  });



  function deleteFunc(id) {
    if (confirm("Delete Record?") == true) {
      // console.log(id);
      var id = id;
      // ajax
      $.ajax({
        type: 'DELETE',
        url: "{{ url('admin/vendordelete')}}",
        data: { id: id },
        dataType: 'json',
        success: function (res) {
          console.log(res);
          var oTable = $('#ajax-crud-datatable').dataTable();
          oTable.fnDraw(false);
        }
      });
    }
  }


  $('#adminform').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: "{{ url('admin/vendorstore')}}",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
        $("#admin-modal").modal('hide');
        console.log(data);
        var oTable = $('#ajax-crud-datatable').dataTable();
        oTable.fnDraw(false);
        $("#btn-save").html('Submit');
        $("#btn-save").attr("disabled", false);
      },
      error: function (data) {
        console.log(data);
      }
    });
  });


  

</script>
@endsection
