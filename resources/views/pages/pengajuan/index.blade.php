@extends('layouts.main')
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
        <h1>Member Koperasi Dashboard | Peminjaman
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
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$pengaturan[0]->value * 100}}">0</span>
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
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red sbold uppercase">Pengajuan Peminjaman</span><span style="margin-left:15px;"></span>
            </div>
            <div class="actions">
              <a class="btn btn-primary btn-flat" href="{{url('peminjaman/pengajuan/create')}}"><i class="fa fa-upload"></i> Ajukan Peminjaman</a>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Nominal</th>
                      <th>Angsuran</th>
                      <th>Keperluan</th>
                      <th>Status</th>
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
<!-- modal -->
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
              <form class="" method="post" enctype="multipart/form-data">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" name="id" value="" id="id">
                <div class="form-body">
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input id="jumlah" type="text" class="form-control" name="jumlah">
                          <label for="form_control_1">Jumlah Pinjaman</label>
                          <i class="fa fa-money"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <select class="form-control" id="angsuran" name="angsuran">
                            <option value=""></option>
                            <option value="12">12 kali</option>
                            <option value="12">24 kali</option>
                          </select>
                          <label for="form_control_1">Angsuran</label>
                          <i class="fa fa-clock-o"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input id="dp" type="text" class="form-control" name="dp">
                          <label for="form_control_1">DP</label>
                          <i class="fa fa-money"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input id="keperluan" type="text" class="form-control" name="keperluan">
                          <label for="form_control_1">Keperluan</label>
                          <i class="fa fa-briefcase"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Foto/File SK</label>
                      <div class="input-icon">
                          <input id="sk" type="file" class="form-control" name="sk">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Foto/File KTP</label>
                      <div class="input-icon">
                          <input id="ktp" type="file" class="form-control" name="ktp">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Foto/File KK</label>
                      <div class="input-icon">
                          <input id="kk" type="file" class="form-control" name="kk">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Foto/File Slip gaji</label>
                      <div class="input-icon">
                          <input id="slip" type="file" class="form-control" name="slip">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Foto/File jaminan/surat berharga</label>
                      <div class="input-icon">
                          <input id="jaminan" type="file" class="form-control" name="jaminan">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                    <div class="form-actions noborder text-center">
                        <button id="submit" type="submit" class="btn blue">Submit</button>
                        <button type="button" class="btn default">Cancel</button>
                    </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> -->
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
  'ajax'        : "{{ url('peminjaman/api/pengajuan') }}"+"/"+id,
  'dataType'    : 'json',
  'paging'      : true,
  'lengthChange': true,
  'columns'     : [

    {data:'tanggal', name: 'tanggal'},
    {data:'jumlah', name: 'jumlah'},
    {data:'angsuran', name: 'angsuran'},
    {data:'keperluan', name: 'keperluan'},
    {data:'status', name: 'status'},
    {data:'detail', name: 'detail', orderable: false, searchable: false},
  ],
  'info'        : true,
  'autoWidth'   : false
});
</script>
@endsection
