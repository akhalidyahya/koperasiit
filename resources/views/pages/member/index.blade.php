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
        <h1>Member Koperasi Dashboard | Anggota
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
      <a href="javascript:;">Anggota</a>
      <!-- <i class="fa fa-circle"></i> -->
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
                <i class=" icon-users font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Daftar Anggota</span><span style="margin-left:15px;"></span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>TTL</th>
                      <th>Identitas</th>
                      <th>Pekerjaan</th>
                      <th>Lembaga</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>

    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
var id = 3;
var t = $('#myTable').DataTable({
  'processing'  : true,
  'serverSide'  : true,
  'ajax'        : "{{ url('admin/api/member') }}",
  'dataType'    : 'json',
  'paging'      : true,
  'lengthChange': true,
  'columns'     : [
    {data:'name', name: 'name'},
    {data:'email', name: 'email'},
    {data:'ttl', name: 'ttl'},
    {data:'identitas', name: 'identitas'},
    {data:'pekerjaan', name: 'pekerjaan'},
    {data:'nama_lembaga', name: 'nama_lembaga'},
    {data:'status', name: 'status'},
    {data:'action', name: 'action'},
  ],
  'info'        : true,
  'autoWidth'   : false
});
</script>


@endsection
