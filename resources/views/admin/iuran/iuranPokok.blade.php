@extends('layouts.admin')
@section('content')
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
  <div class="col-md-6">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red sbold uppercase">Iuran pokok belum lunas</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover text-center" id="myTable">
                <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($belumBayar as $data) { $no = 1;?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $data->name ?></td>
                        <td><a href="{{url('admin/member').'/'.$data->user_id}}/edit">Detail</a></td>
                      </tr>
                    <?php } ?>
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
<!-- END PAGE BASE CONTENT -->
<!-- BEGIN PAGE BASE CONTENT -->
        <div class="col-md-6">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light portlet-fit portlet-datatable bordered">
              <div class="portlet-title">
                  <div class="caption">
                      <i class=" icon-layers font-red"></i>
                      <span class="caption-subject font-red sbold uppercase">Iuran pokok sudah lunas</span>
                  </div>
              </div>
              <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover text-center" id="myTable2">
                      <thead>
                          <tr>
                            <th>Nama</th>
                            {{-- <th>Lunas?</th> --}}
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($sudahBayar as $sb)
                          <tr>
                              <td>{{$sb->name}}</td>
                              {{-- <td>
                                @if($bb->status == 0) -
                                @elseif($bb->status == 1) <i class="fa fa-check font-green-jungle" data-toggle="tooltip" title="Paid"></i>
                                @elseif($bb->status == 2) <i class="fa fa-refresh font-dark" data-toggle="tooltip" title="Waiting for confirmation"></i>
                                @elseif($bb->status == 3) <i class="fa fa-times font-red" data-toggle="tooltip" title="Not Paid"></i>
                                @endif
                              </td> --}}
                          </tr>
                          @endforeach
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
      </div>
      <!-- END PAGE BASE CONTENT -->
<!-- <script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
$('#myTable').dataTable();
$('#myTable2').dataTable();

</script> -->
@endsection
