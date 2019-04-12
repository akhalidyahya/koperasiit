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
        <a href="{{url('peminjaman/angsuran')}}">Angsuran</a>
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
    <button onclick="bayarAngsuran()" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Bayar Angsuran</button>
    @if($peminjaman->status_dp == 1)
    <button disabled class="btn btn-primary btn-flat"><i class="fa fa-check"></i>DP Lunas</button>
    @elseif($peminjaman->status_dp == 2)
    <button disabled class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i>Menunggu konfirmasi</button>
    @else
    <button onclick="bayarDp()" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Bayar DP</button>
    @endif
    <a href="{{route('pdf.download', $peminjaman->kode)}}" class="btn btn-primary">Save as PDF</a>
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
            <td>Jumlah DP</td>
            <td> : </td>
            <td>
              Rp.{{number_format($peminjaman->dp)}}
              @if($peminjaman->status_dp ==0)
                <span class="font-red">(Belum dibayarkan. Segera bayar DP)</span>
              @elseif($peminjaman->status_dp==2)
                <span class="">(Menunggu konfirmasi Pembayaran)</span>
              @elseif($peminjaman->status_dp==1)
                <span class="font-green">(DP sudah dibayar)</span>
              @else
                <span class="font-red">(Pembayaran DP ditolak, silahkan lakukan transaksi lagi)</span>
              @endif
            </td>
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
                <span class="caption-subject font-blue sbold uppercase">Perhitungan Angsuran </span>
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
                      <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($angsuran as $data)
                  <tr>
                    <td>{{$data->bulan}}</td>
                    <td>{{$data->pokok}}</td>
                    <td>{{$data->angsuran}}</td>
                    <td>{{$data->saldo}}</td>
                    <td>
                      @if($data->status == 0) -
                      @elseif($data->status == 1) <i class="fa fa-check font-green-jungle" data-toggle="tooltip" title="Paid"></i> Sudah bayar
                      @elseif($data->status == 2) <i class="fa fa-refresh font-dark" data-toggle="tooltip" title="Waiting for confirmation"></i> Menunggu konfirmasi
                      @elseif($data->status == 3) <i class="fa fa-times font-red" data-toggle="tooltip" title="Not Paid"></i> Belum bayar / bukti ditolak
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
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
              <form role="form" class="" method="post" enctype="multipart/form-data" action="{{url('peminjaman/angsuran/bayardp')}}">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" name="id" value="{{$peminjaman->id}}" id="id">
                <div class="form-body">
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input type="text" class="form-control" value="{{number_format($peminjaman->dp)}}" disabled>
                          <input id="nominal" type="hidden" class="form-control" name="nominal" value="{{$peminjaman->dp}}">
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
                    <label for="form_control_1">Upload Foto Bukti Transfer Angsuran</label>
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
<!-- modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
              <form role="form" class="" method="post" enctype="multipart/form-data" action="{{url('peminjaman/angsuran/bayarangsuran')}}">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" name="id" id="id" value="{{$peminjaman->id}}">
                <div class="form-body">
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <select class="form-control" id="bulan" name="bulan">
                            <option value=""></option>
                            @foreach($bulan as $data)
                            <option value="{{$data->bulan}}">{{$data->bulan}}</option>
                            @endforeach
                          </select>
                          <label for="form_control_1">Bulan ke-</label>
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input id="" type="text" class="form-control" name="" value="{{number_format($peminjaman->angsuran_bulanan)}}" disabled>
                          <input id="nominal" type="hidden" class="form-control" value="{{number_format($peminjaman->angsuran_bulanan)}}" name="nominal">
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
function bayarDp(){
  save_method = 'add';
  $('input[name=_method]').val('POST');
  $('#myModal').modal('show');
  $('#myModal form')[0].reset();
  $('.modal-title').text('Upload Bukti Transfer');
}

function bayarAngsuran(){
  save_method = 'add';
  $('input[name=_method]').val('POST');
  $('#myModal2').modal('show');
  $('#myModal2 form')[0].reset();
  $('.modal-title').text('Upload Bukti Transfer');
}
</script>
@endsection
