@extends('layouts.admin')
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

    <div class="portlet light portlet-fit portlet-datatable bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Ajukan Pembiayaan</span>
            </div>
    </div>

    <div class="portlet-body">
    <form class="register-form" action="{{route('member.store')}}" method="post">
              {{csrf_field()}} {{method_field('POST')}}
                <h3 class="font-green">Form Isian Calon Anggota Koperasi Berkah Usaha Terbadu</h3>
                <hr>
                <h4 class=""> A. Data Individu </h4>
                <div class="form-group">
                    <label class="control-label hint">Nama Lengkap</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Nama Lengkap" name="nama" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">TTL</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="contoh: Lumajang, 20 April 1996" name="ttl" />
                </div>
                <div class="form-group" style="margin-bottom:0px;">
                    <label class="control-label hint" style="margin-bottom:0px;">Jenis Kelamin</label>
                    <div class="mt-radio-inline">
                        <label class="mt-radio"> Laki-Laki
                            <input type="radio" value="lk" name="jk" />
                            <span></span>
                        </label>
                        <label class="mt-radio"> Perempuan
                            <input type="radio" value="pr" name="jk" />
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label hint">No. Identitas</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="KTP/SIM" name="identitas" />
                </div>
                <style media="screen">
                    #alamat { height: 100px;}
                </style>
                <div class="form-group">
                    <label class="control-label hint">Alamat Tempat Tinggal</label>
                    <textarea id="alamat" class="form-control placeholder-no-fix" name="alamat" rows="200" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label hint">No Hp</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="No Telepon / HP" name="hp" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Pekerjaan</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Pekerjaan" name="pekerjaan" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Pendapatan Perbulan</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Pendapatan perbulan" name="pendapatan" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Email</label>
                    <input class="form-control placeholder-no-fix" type="email" placeholder="Alamat Email" name="email" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Password Akun</label>
                    <input class="form-control placeholder-no-fix"  placeholder="Password Akun" name="password" />
                </div>
                <hr>
                <h4 class=""> B. Data Lembaga </h4>
                <div class="form-group">
                    <label class="control-label hint">Nama</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Nama lembaga tempat bekerja" name="nama_lembaga" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Alamat</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Alamat lembaga" name="alamat_lembaga" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">Status</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Status Kepegawaian" name="pegawaian" />
                </div>
                <div class="form-group">
                    <label class="control-label hint">No Telepon</label>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="No Telepon Lembaga" name="no_lembaga" />
                </div>
                <!-- <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> Dengan ini saya menyatakan data yang dibutuhkan dalam lembar keanggotaan ini adalah benar adanya.
                        Dan saya bersedia menjadi anggota <b>Koperasi Berkah Usaha Terpadu</b> atas kesadaran pribadi tanpa ada paksaan dari pihak manapun.
                        Saya siap mengikuti AD/ART <b>Koperasi Berkah Usaha Terpadu</b>.
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div> -->
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
    </div>


    </div>
</div>
@endsection
