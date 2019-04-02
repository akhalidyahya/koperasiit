@extends('layouts.main')
@section('content')
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Member Koperasi Dashboard | Iuran
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
        <span class="active">Iuran</span>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">Iuran Pokok</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
  @if($pokok->status == 0)
  <div class="col-md-12">
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red sbold uppercase">Anda harus Membayar Iuran Pokok</span>
            <span class="fa fa-times-circle-o font-red"></span>
        </div>
      </div>
      <div class="portlet-body">
        <button onclick="bayar()" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Bayar Sekarang</button>
      </div>
    </div>
  </div>
  @elseif($pokok->status == 1)
  <div class="col-md-12">
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-green-jungle"></i>
            <span class="caption-subject font-green-jungle sbold uppercase">Anda Sudah Membayar Iuran Pokok</span>
            <span class="fa fa-check-circle-o font-green-jungle"></span>
        </div>
      </div>
    </div>
  </div>
  @elseif($pokok->status == 2)
  <div class="col-md-12">
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers"></i>
            <span class="caption-subject sbold uppercase">Pembayaran Iuran Pokok sedang di verivikasi</span>
            <span class="fa fa-refresh"></span>
        </div>
      </div>
    </div>
  </div>
  @elseif($pokok->status == 3)
  <div class="col-md-12">
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red sbold uppercase">Pembayaran Ditolak, silahkan lakukan Pembayaran kembali</span>
            <span class="fa fa-times-circle-o font-red"></span>
        </div>
      </div>
      <div class="portlet-body">
        <button onclick="bayar()" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Bayar Sekarang</button>
      </div>
    </div>
  </div>
  @endif
</div>
<!-- modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
              <form role="form" class="" method="post" enctype="multipart/form-data" action="{{route('iuranpokok')}}">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" name="id" value="" id="id">
                <div class="form-body">
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input type="text" class="form-control" value="{{$pengaturan[2]->value}}" disabled>
                          <input id="nominal" type="hidden" class="form-control" name="nominal" value="{{$pengaturan[2]->value}}">
                          <label for="form_control_1">Nominal</label>
                          <i class="fa fa-money"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <textarea class="form-control" rows="5" name="keterangan"></textarea>
                        <label for="form_control_1">Keterangan</label>
                    </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <label for="form_control_1">Upload Foto Bukti Transfer Iuran</label>
                      <div class="input-icon">
                          <input id="bukti" type="file" class="form-control" name="bukti">
                          <i class="fa fa-photo"></i>
                      </div>
                  </div>
                    <div class="form-actions noborder text-center">
                        <button id="submit" type="submit" class="btn blue">Submit</button>
                        <!-- <button type="button" class="btn default">Cancel</button> -->
                    </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn green">Save changes</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- END PAGE BASE CONTENT -->
<script type="text/javascript">
function bayar(){
  save_method = 'add';
  $('input[name=_method]').val('POST');
  $('#myModal').modal('show');
  $('#myModal form')[0].reset();
  $('.modal-title').text('Upload Bukti Transfer');
}
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
