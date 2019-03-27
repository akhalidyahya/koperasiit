<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Login | Koperasi Berkah Usaha Terpadu</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Login page of Koperasi " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset('assets/global/css/components-md.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{asset('assets/global/css/plugins-md.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{asset('assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="{{asset('assets/pages/img/logo-big.jpg')}}" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="{{route('login')}}">
                <img src="{{asset('assets/pages/img/logo-big.jpg')}}" width="200px" style="border-radius:100%;" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            @if(Session::has('success'))
            <div class="alert alert-success">
              <strong>Success!</strong> The page has been added.
            </div>
            click <a href="{{url('login')}}">here</a> to login
            @else
            <form class="login-form" action="{{route('login')}}" method="post">
              @csrf
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input id="email" class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" />
                </div>
                @if ($errors->has('password'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input id="password" class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
                  </div>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />Remember
                        <span></span>
                    </label>
                <div class="form-actions text-center">
                    <button type="submit" class="btn green uppercase">Login</button>
                    <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
                </div>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Daftar menjadi Anggota</a>
                    </p>
                </div>
            </form>
            @endif
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <!-- <form class="forget-form" action="index.html" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form> -->
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
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
                    <input class="form-control placeholder-no-fix" type="password" placeholder="Password Akun" name="password" />
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
                <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> Dengan ini saya menyatakan data yang dibutuhkan dalam lembar keanggotaan ini adalah benar adanya.
                        Dan saya bersedia menjadi anggota <b>Koperasi Berkah Usaha Terpadu</b> atas kesadaran pribadi tanpa ada paksaan dari pihak manapun.
                        Saya siap mengikuti AD/ART <b>Koperasi Berkah Usaha Terpadu</b>.
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM -->
        </div>
        <div class="copyright"> <?php echo Date("Y") ?> © Koperasi Berkah Usaha Terpadu. Dashboard. </div>
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script>
<script src="../assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{asset('assets/pages/scripts/login.min.js')}}" type="text/javascript"></script>
        <!-- <script src="{{asset('assets/pages/scripts/form-wizard.min.js')}}" type="text/javascript"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>
