@extends('admin.home')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- @section('pageheading','SuperUser') --}}
@section('breadcrum','requests')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 margin-tb">

        <div class="pull-left">
          <h2>Requests</h2>
        </div>
        <div class="float-right mb-2">
          <a class="btn btn-success" onClick="add()" href="javascript:void(0)">Refresh</a>
        </div>
      </div>
    </div>
</div>    

@endsection
