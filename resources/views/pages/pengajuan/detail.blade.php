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
      <a href="{{url('peminjaman/pengajuan')}}">Pengajuan</a>
      <i class="fa fa-circle"></i>
  </li>
    <li>
        <span class="active">Detail</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
  <div class="col-md-12">
    <button <?php if($peminjaman->status == 3 || $peminjaman->status == 1) echo 'disabled'; ?> onclick="batalkan({{$peminjaman->id}})" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Batalkan Pengajuan</button>
    <p></p>
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-body">
        <table>
          <tr>
            <td>Keperluan</td> <td> : </td> <td>{{$peminjaman->keperluan}}</td>
          </tr>
          <tr>
            <td>Harga OTR</td> <td> : </td> <td>Rp.{{number_format($peminjaman->jumlah)}}</td>
          </tr>
          <tr>
            <td>Margin {{$peminjaman->margin * 100}}%</td> <td> : </td> <td>Rp.{{number_format($peminjaman->after_margin)}}</td>
          </tr>
          <tr>
            <td>Biaya Admin</td> <td> : </td> <td>Rp.{{number_format($peminjaman->biaya_admin)}}</td>
          </tr>
          <tr>
            <td></td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->jumlah + $peminjaman->after_margin + $peminjaman->biaya_admin)}}</b></td>
          </tr>
          <tr>
            <td>Jumlah DP</td> <td> : </td> <td>Rp.{{number_format($peminjaman->dp)}}</td>
          </tr>
          <tr>
            <td><b>Total Pokok</b> </td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->pokok)}}</b></td>
          </tr>
          <tr>
            <td>Periode Angsuran</td> <td> : </td> <td>{{number_format($peminjaman->angsuran)}}</td>
          </tr>
          <tr>
            <td><b>Angsuran per Bulan</b> </td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->angsuran_bulanan)}}</b></td>
          </tr>
        </table>
      </div>
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Perkiraan Angsuran </span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Bulan</th>
                      <th>Pokok</th>
                      <th>Angsuran</th>
                      <th>Saldo</th>
                      <!-- <th>Status</th> -->
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $temp_pokok = $peminjaman->pokok;
                  for ($i=1; $i <= $peminjaman->angsuran; $i++) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo number_format($temp_pokok); ?></td>
                      <td><?php echo number_format($peminjaman->angsuran_bulanan); ?></td>
                      <td><?php $temp_pokok-=$peminjaman->angsuran_bulanan; echo number_format($temp_pokok);  ?></td>
                      <!-- <td></td> -->
                    </tr>
                  <?php }
                   ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
<form id="myForm" class=""  method="post">
{{csrf_field()}} {{method_field('POST')}}
<input type="hidden" name="id" id="id" value="{{$peminjaman->id}}">
<input type="hidden" name="status" id="status" value="{{$peminjaman->status}}">
</form>
<!-- END PAGE BASE CONTENT -->
<script type="text/javascript">
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function batalkan(id){
  var popup = confirm("Apakah yakin ingin membatalkan pengajuan peminjaman?");
  if (popup == true) {
    $('input[name=_method]').val('PATCH');
    $.ajax({
      url:"{{url('peminjaman/pengajuan/cancel')}}"+"/"+id,
      type:'POST',
      // data: $('#myModal form').serialize(),
      data: new FormData($('#myForm')[0]),
      contentType: false,
      processData: false,
      success: function($data){
        window.location.replace("{{url('peminjaman/pengajuan')}}");
      },
      error: function(){
        alert('something went wrong');
        // $('#error').removeClass('hide');
      } });
  }
}

// function tes(id){
//   var popup = confirm("Apakah yakin ingin membatalkan pengajuan peminjaman?");
//   if (popup == true) {
//     $('input[name=_method]').val('PATCH');
//     $.ajax({
//       url:"{{url('peminjaman/pengajuan/aprove')}}"+"/"+id,
//       type:'POST',
//       // data: $('#myModal form').serialize(),
//       data: new FormData($('#myForm')[0]),
//       contentType: false,
//       processData: false,
//       success: function($data){
//         window.location.replace("{{url('peminjaman/pengajuan')}}");
//       },
//       error: function(){
//         alert('something went wrong');
//         // $('#error').removeClass('hide');
//       } });
//   }
// }
</script>
@endsection
