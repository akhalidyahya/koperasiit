@extends('layouts.admin')
@section('content')

            <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Koperasi | Pengaturan
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
        <span class="active">Pengaturan</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-6">

    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Pengaturan</span>
            </div>
    </div>

    <div class="portlet-body">
      <form class="register-form" action="{{route('pengaturan.update')}}" method="post">
        {{csrf_field()}} {{method_field('POST')}}
        <div class="form-group">
          <label class="control-label hint">Margin rate</label>
          <input class="form-control placeholder-no-fix" type="text" name="margin" value="{{$pengaturan[0]->value}}"/>
        </div>
        <div class="form-group">
          <label class="control-label hint">Biaya Administrasi</label>
          <input class="form-control placeholder-no-fix" type="text" name="admin"  value="{{number_format($pengaturan[1]->value)}}"/>
        </div>
        <div class="form-actions">
          <button type="submit" id="register-submit-btn" class="btn btn-success uppercase">Submit</button>
        </div>
      </form>
    </div>


    </div>
</div>
@endsection
