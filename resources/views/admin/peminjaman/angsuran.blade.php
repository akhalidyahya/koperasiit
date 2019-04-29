@extends('layouts.admin')
@section('content')
<!-- BEGIN PAGE HEAD-->
<!-- BEGIN PAGE CSS -->
<link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE CSS -->
<!-- BEGIN ADDITIONAL JS -->
<script src="{{asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/table-datatables-buttons.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/table-datatables-managed.min.js')}}" type="text/javascript"></script>
<!-- END ADDITIONAL JS -->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Admin Koperasi | Angsuran
            <small>statistics, charts and reports</small>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
      <a href="javascript:;">Home</a>
      <i class="fa fa-circle"></i>
  </li>
  <li>
      <a href="javascript:;">Peminjaman</a>
      <i class="fa fa-circle"></i>
  </li>
  <li>
      <span class="active">Angsuran</span>
  </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
  <div class="col-md-12">

    <p></p>
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Daftar Peminjaman</span><span style="margin-left:15px;"></span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kode</th>
                      <th>Nominal pinjaman</th>
                      <th>Waktu</th>
                      <th>Angsuran</th>
                      <th>Keperluan</th>
                      <th>Detail</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
<!-- END PAGE BASE CONTENT -->
<script type="text/javascript">
function pinjam(){
  save_method = 'add';
  $('input[name=_method]').val('POST');
  $('#myModal').modal('show');
  $('#myModal form')[0].reset();
  $('.modal-title').text('Ajukan Peminjaman');
}
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
var id = 1;
var t = $('#myTable').DataTable({
  'processing'  : true,
  'serverSide'  : true,
  'ajax'        : "{{ url('api/angsuranadmin') }}",
  'dataType'    : 'json',
  'paging'      : true,
  'lengthChange': true,
  'columns'     : [
    {data:'name', name: 'name'},
    {data:'kode', name: 'kode'},
    // {data:'tanggal', name: 'tanggal'},
    {data:'jumlah', name: 'jumlah'},
    {data:'created_at', name: 'created_at'},
    {data:'angsuran', name: 'angsuran'},
    {data:'keperluan', name: 'keperluan'},
    {data:'detail', name: 'detail', orderable: false, searchable: false},
  ],
  'info'        : true,
  'autoWidth'   : false
});
</script>
@endsection
