@extends('layouts.main')
@section('content')
<!-- BEGIN PAGE CSS -->
<link href="{{asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE CSS -->
<!-- BEGIN PAGE JS -->
<script src="{{asset('assets/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/timeline.min.js')}}" type="text/javascript"></script>
<!-- END PAGE JS -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Edit User Profile | Account
            <small>user account page</small>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="">User</span>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">Setting</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet bordered">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="{{asset($user->gambar)}}" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{$user->name}} </div>
                    <!-- <div class="profile-usertitle-job"> Developer </div> -->
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <!-- <div class="profile-userbuttons">
                    <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                    <button type="button" class="btn btn-circle red btn-sm">Message</button>
                </div> -->
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->

                <div class="profile-usermenu">
                    <ul class="nav">
                      <!-- <li class="">
                          <a href="{{url('profile')}}">
                              <i class="icon-home"></i> Overview </a>
                      </li> -->
                        <li class="active">
                            <a href="">
                                <i class="icon-settings"></i> Account Settings </a>
                        </li>
                    </ul>
                </div>

                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->

            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                </li>
                                <!-- <li>
                                    <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">

                                    <form role="form" action="{{route('update.profile')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label">First Name</label>
                                            <input type="text" placeholder="John" name="nama" class="form-control" value="{{$user->name}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" placeholder="Doe" name="email" class="form-control" value="{{$user->email}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input type="password" placeholder="your Password" name="password"  class="form-control" /> </div>
                                        <div class="form-group">
                                            <label class="control-label">TTL</label>
                                            <input type="text" placeholder="Design, Web etc." name="ttl" class="form-control" value="{{$user->ttl}}"/> </div>
                                            <div class="form-group">
                                                <label class="control-label">Jenis Kelamin</label><br>
                                                <label class="radio-inline"><input type="radio" value="lk" name="jk" {{ ($user->jk=="lk")? "checked" : "" }} />Laki-laki</label>
                                                <label class="radio-inline"><input type="radio" value="pr" name="jk" {{ ($user->jk=="pr")? "checked" : "" }}/>Perempuan</label>
                                            </div>
                                        <div class="form-group">
                                            <label class="control-label">Identitas</label>
                                            <input type="text" placeholder="Web Developer" name="identitas" class="form-control" value="{{$user->identitas}}" /> </div>

                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="alamat" class="form-control" value="{{$user->alamat}}"/> </div>
                                            
                                        <div class="form-group">
                                            <label class="control-label">HP</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="hp" class="form-control" value="{{$user->hp}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Pekerjaan</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="pekerjaan" class="form-control" value="{{$user->pekerjaan}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Pendapatan</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="pendapatan" class="form-control" value="{{$user->pendapatan}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Nama Lembaga</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="nama_lembaga" class="form-control" value="{{$user->nama_lembaga}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat Lembaga</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="alamat_lembaga" class="form-control" value="{{$user->alamat_lembaga}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Kepegawaian</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="pegawaian" class="form-control" value="{{$user->pegawaian}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">No Lembaga</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" name="no_lembaga" class="form-control" value="{{$user->no_lembaga}}"/> </div>

                                        <div class="margiv-top-10">
                                            <button type="submit" class="btn green">Save Changes</button>
                                            <button type="button" class="btn green">Cancel</button>
                                        </div>


                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <!-- <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                        eiusmod. </p> -->
                                    <form action="{{route('update.profile')}}" role="form" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">

                                                <!-- <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div> -->

                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" name="gambar"> </span>
                                                    <!-- <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a> -->
                                                </div>
                                            </div>
                                            <!-- <div class="clearfix margin-top-10">
                                                <span class="label label-danger">NOTE! </span>
                                                <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                            </div> -->
                                        </div>
                                        <div class="margin-top-10">
                                            <!-- <a href="javascript:;" class="btn green"> Submit </a>
                                            <a href="javascript:;" class="btn default"> Cancel </a> -->
                                            <button type="submit" class="btn green">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->
                                <!-- CHANGE PASSWORD TAB -->
                                <!-- <div class="tab-pane" id="tab_1_3">
                                    <form action="{{route('update.profile')}}" method="post">
                                    {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label">Current Password</label>
                                            <input type="text" class="form-control" value="{{$user->password}}"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">New Password</label>
                                            <input type="password" class="form-control" name="new_password" id="pass1"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Re-type New Password</label>
                                            <input type="password" class="form-control" name="retype_password" id="pass2"/> </div>
                                        <div class="margin-top-10">
                                            <a href="submit" class="btn green"> Change Password </a>
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    </form>
                                </div> -->
                                <!-- END CHANGE PASSWORD TAB -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- END PAGE BASE CONTENT -->

<script>

$( document ).ready(function() {

	$('input').blur(function() {
if ($('#pass1').attr('value') == $('#pass2').attr('value')) {
return true;
} else { return false; }
});

});
</script>



@endsection
