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
        <h1>Admin Koperasi | Pembiayaan
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
      <a href="javascript:;">Pembiayaan</a>
      <i class="fa fa-circle"></i>
  </li>
  <li>
      <span class="active">Pengajuan</span>
  </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row widget-row">
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Margin Rate</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-blue-chambray icon-graph"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">percent</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="10">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    <div class="col-md-3">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Admin Charge</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-blue-chambray icon-book-open"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Rp</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="250,000">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
</div>
<div class="row">
  <div class="col-md-12">

    <p></p>
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Pengajuan Pembiayaan</span><span style="margin-left:15px;"></span>
            </div>
            <!-- <div class="actions">
              <a class="btn btn-primary btn-flat" href="{{url('peminjaman/pengajuan/create')}}"><i class="fa fa-upload"></i> Ajukan Peminjaman</a>
            </div> -->
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Waktu</th>
                      <th>kode</th>
                      <th>Nominal</th>
                      <th>Angsuran</th>
                      <th>Keperluan</th>
                      <!-- <th>Status</th> -->
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
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
// var id = 1;
$('#myTable').DataTable(
 {
  'processing'  : true,
  'serverSide'  : true,
  'ajax'        : "{{ url('api/pengajuanadmin') }}",
  'dataType'    : 'json',
  'paging'      : true,
  'lengthChange': true,
  'columns'     : [
    {data:'name', name: 'name'},
    {data:'created_at', name: 'created_at'},
    {data:'kode', name: 'kode'},
    {data:'jumlah', name: 'jumlah'},
    {data:'angsuran', name: 'angsuran'},
    {data:'keperluan', name: 'keperluan'},
    // {data:'status', name: 'status'},
    // {data:'aprove', name: 'aprove'},
    // {data:'disaprove', name: 'disaprove'},
    {data:'detail', name: 'detail', orderable: false, searchable: false},
  ],
  'info'        : true,
  'autoWidth'   : false
}
);
</script>


@endsection
