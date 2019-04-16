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
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
  <div class="col-md-12">
    <button onclick="bayar()" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Bayar Iuran</button>
    <p></p>
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red sbold uppercase">Iuran Bulanan</span>
            </div>
            <div class="actions">
              <select class="form-control" id="pilih_thn">
                <option value="2018">2018</option>
              </select>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover text-center" id="myTable">
                <thead>
                    <tr>
                      <th>Jan</th>
                      <th>Feb</th>
                      <th>Mar</th>
                      <th>Apr</th>
                      <th>Mei</th>
                      <th>Jun</th>
                      <th>Jul</th>
                      <th>Ags</th>
                      <th>Sept</th>
                      <th>Okt</th>
                      <th>Nov</th>
                      <th>Des</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    @foreach($iuran as $data)
                    <td>
                      @if($data->status == 0) -
                      @elseif($data->status == 1) <i class="fa fa-check font-green-jungle" data-toggle="tooltip" title="Paid"></i>
                      @elseif($data->status == 2) <i class="fa fa-refresh font-dark" data-toggle="tooltip" title="Waiting for confirmation"></i>
                      @elseif($data->status == 3) <i class="fa fa-times font-red" data-toggle="tooltip" title="Not Paid"></i>
                      @endif
                    </td>
                    @endforeach
                  </tr>
                </tbody>
                <tfoot>
                    <!-- <tr>
                        <th colspan="10" style="text-align:right">Total:&nbsp;&nbsp;</th>
                        <th></th>
                    </tr> -->
                </tfoot>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>

<!-- modal1 -->
<div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
              <form role="form" class="" method="post" enctype="multipart/form-data" action="{{route('iuran.store')}}">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" name="id" value="" id="id">
                <div class="form-body">
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <select class="form-control" id="bulan" name="bulan">
                            <option value=""></option>
                            @foreach($bulan as $data)
                            <option value="{{$data->bulan}}"><?php echo DateTime::createFromFormat('!m',$data->bulan)->format('F') ?></option>
                            @endforeach
                          </select>
                          <label for="form_control_1">Bulan</label>
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>
                  <div class="form-group form-md-line-input has-success form-md-floating-label">
                      <div class="input-icon">
                          <input id="nominal" type="text" class="form-control" name="nominal">
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

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
