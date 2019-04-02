@extends('layouts.main')
@section('content')
<!-- BEGIN PAGE HEAD-->
<!-- BEGIN PAGE CSS -->
<link href="{{asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE CSS -->
<!-- BEGIN ADDITIONAL JS -->
<script src="{{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
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
        <a href="{{url('peminjaman/pengajuan')}}">Pengajuan</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">Ajukan Peminjaman</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red sbold uppercase">Ajukan Peminjaman</span>
            </div>
        </div>
        <div class="portlet-body">
          <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{route('pengajuan.store')}}">
            {{csrf_field()}} {{method_field('POST')}}
            <input type="hidden" name="id" value="" id="id">
            <div class="form-body">
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Jumlah Pinjaman</label>
                  <div class="col-md-10">
                      <input autocomplete="off" type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Masukan jumlah pinjaman">
                      <div class="form-control-focus"> </div>
                      <span class="help-block">Jangan memakai titik</span>
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for="angsuran">Angsuran</label>
                  <div class="col-md-10">
                      <select class="form-control" id="angsuran" name="angsuran">
                        <option value=""></option>
                        <option value="12">12 kali</option>
                        <option value="24">24 kali</option>
                      </select>
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Jumlah DP</label>
                  <div class="col-md-10">
                      <input autocomplete="off" type="text" class="form-control" id="dp" name="dp" placeholder="Masukan jumlah DP pinjaman">
                      <div class="form-control-focus"> </div>
                      <span class="help-block">Jangan memakai titik</span>
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Keperluan</label>
                  <div class="col-md-10">
                      <input autocomplete="off" type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukan keperluan pinjaman">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Foto/File SK</label>
                  <div class="col-md-10">
                      <input id="sk" type="file" class="form-control" name="sk">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Foto/File KTP</label>
                  <div class="col-md-10">
                      <input id="ktp" type="file" class="form-control" name="ktp">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Foto/File KK</label>
                  <div class="col-md-10">
                      <input id="kk" type="file" class="form-control" name="kk">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Foto/File Slip gaji</label>
                  <div class="col-md-10">
                      <input id="slip" type="file" class="form-control" name="slip">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <div class="form-group form-md-line-input">
                  <label class="col-md-2 control-label" for="form_control_1">Foto/File jaminan/surat berharga</label>
                  <div class="col-md-10">
                      <input id="jaminan" type="file" class="form-control" name="jaminan">
                      <div class="form-control-focus"> </div>
                      <!-- <span class="help-block">Jangan memakai titik</span> -->
                  </div>
              </div>
              <br><br>
              <h4 class="font-blue">Perhitungan</h4>
              <div class="form-group">
                <div class="col-md-2">
                  Jumlah Peminjaman
                </div>
                <div class="col-md-10">
                  <span id="jumlah_peminjaman"></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  Margin {{$pengaturan[0]->value*100}} %
                </div>
                <div class="col-md-10">
                  <span id="margin"></span>
                  <input type="hidden" name="after_margin" value="" id="after_margin">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  Biaya Admin
                </div>
                <div class="col-md-10">
                  <span id="admin">{{number_format($pengaturan[1]->value)}}</span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                  <span id="total"></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  Jumlah DP
                </div>
                <div class="col-md-10">
                  <span id="jumlah_dp"></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  <b>Total Pokok</b>
                </div>
                <div class="col-md-10">
                  <span id="total_pokok"></span>
                  <input type="hidden" name="pokok" value="" id="pokok">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  Periode Angsuran
                </div>
                <div class="col-md-10">
                  <span id="jumlah_angsuran"></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2">
                  <b>Angsuran per bulan</b>
                </div>
                <div class="col-md-10">
                  <span id="angsuran_per_bulan"></span>
                  <input type="hidden" name="angsuran_bulanan" value="" id="angsuran_bulanan">
                </div>
              </div>
                <div class="form-actions noborder text-center">
                    <button id="submit" type="submit" class="btn blue">Submit</button>
                    <!-- <button type="button" class="btn default">Cancel</button> -->
                </div>
            </div>
          </form>
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

  $('#jumlah,#dp,#angsuran').change(function(){
    var jml_pmnjmn = $('#jumlah').val();
    var jml_dp = $('#dp').val();
    var p_angsuran = $('#angsuran').val();
    var after_margin = jml_pmnjmn * {{$pengaturan[0]->value}};
    var total = Number(jml_pmnjmn) + Number(after_margin) + Number({{$pengaturan[1]->value}});
    var total_pokok = Number(total) - Number(jml_dp);
    var angsuran_per_bulan = Math.round(Number(total_pokok) / Number(p_angsuran));

    $('#jumlah_peminjaman').text(numberWithCommas(jml_pmnjmn));
    $('#jumlah_dp').text(numberWithCommas(jml_dp));
    $('#jumlah_angsuran').text(p_angsuran);
    $('#margin').text(numberWithCommas(after_margin));
    $('#total').text(numberWithCommas(total));
    $('#total_pokok').text(numberWithCommas(total_pokok));
    $('#angsuran_per_bulan').text(numberWithCommas(angsuran_per_bulan));

    $('#after_margin').val(after_margin);
    $('#pokok').val(total_pokok);
    $('#angsuran_bulanan').val(angsuran_per_bulan);
  });
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>
@endsection
