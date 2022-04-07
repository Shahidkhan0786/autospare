@extends('superuser.home')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('pageheading','SuperUser')
@section('breadcrum','vendor')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 margin-tb">

        <div class="pull-left">
          <h2>Vendor</h2>
        </div>
        <div class="float-right mb-2">
          <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create vendor</a>
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
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<!-- boostrap company model -->
<div class="modal fade" id="admin-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="createadmin"></h4>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0)" id="adminform" name="adminform" class="form-horizontal" method="POST"
          enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter admin Name"
                maxlength="50" required="">
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-12">
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter admin Email"
                maxlength="50" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Address</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="address" name="address" placeholder="Enter Admin Address"
                required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">location</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="location" name="location" placeholder="Enter Admin location"
                required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-12">
              <input type="password" class="form-control" id="password" name="password"
                placeholder="Enter Admin password" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">cnic</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="cnic" name="cnic" placeholder="Enter Admin cnic" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">cnic expiery</label>
            <div class="col-sm-12">
              <input type="date" class="form-control" id="cnicexp" name="cnicexp" placeholder="Enter Admin cnic expiry"
                required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-12">
              <select class="custom-select" name="status" id="status">
                <option selected>Select one</option>
                <option value="0">pending</option>
                <option value="1">active</option>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pic</label>
            <div class="col-sm-12">
              <input type="file" class="form-control" id="vendorpic" name="vendorpic" placeholder="admin pic" required="">
            </div>
          </div>
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" id="btn-save">create
            </button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
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
          <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-12">
              <input type="password" class="form-control" id="password" name="password"
                placeholder="Enter Admin password" required="">
            </div>
          </div>
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
            <button type="submit" class="btn btn-primary" id="btn-update">update
            </button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
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
      ajax: "{{ url('/superadmin/vendor') }}",
      columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false },
      ],

      order: [[0, 'desc']]
    });
  });
  function add() {
    $('#adminform').trigger("reset");
    $('#createadmin').html("add vendor");
    $('#admin-modal').modal('show');
    $('#id').val('');
  }
  function editFunc(id) {

    $.ajax({
      type: "GET",
      url: "{{ url('superadmin/vendoredit/{id}')}}",
      data: { id: id },
      dataType: 'json',
      success: function (res) {
        $('#editadmin').html("Edit Vendor");
        $('#admin-edit-modal').modal('show');
        $('#id1').val(res.id);
        $('#name1').val(res.name);
        $('#address1').val(res.vendor.address);
        $('#email1').val(res.email);
        $('#cnic1').val(res.vendor.cnic);
        $('#cnicexp1').val(res.vendor.cnicexpiry);
        $('#aimage1').css('display', 'block');
        $('#location1').val(res.vendor.location);
        $('#aimage1').attr('src', '/storage/'+res.vendor.pic);
        $('#status1').val(res.vendor.status).change();

      }
    });
  }
  function deleteFunc(id) {
    if (confirm("Delete Record?") == true) {
      // console.log(id);
      var id = id;
      // ajax
      $.ajax({
        type: 'DELETE',
        url: "{{ url('superadmin/vendordelete') }}",
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
      url: "{{ url('superadmin/vendorstore')}}",
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


  // update 
  $('#editadminform').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
      type: 'POST',
      url: "{{ url('superadmin/vendorupdate')}}",
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


</script>
@endsection