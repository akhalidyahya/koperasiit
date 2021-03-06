<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Auth::routes(['register' => false]);
Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});

Route::resource('daftar','DaftarController');
Route::get('profile','MemberController@profile');
Route::get('profile/detail','MemberController@detail');
Route::get('profile/account', 'MemberController@account');
Route::post('profile/account/update', 'MemberController@updateProfile')->name('update.profile');
// Route::resource('member','MemberController');
Route::post('iuran/pokok/save','IuranController@storepokok')->name('iuranpokok');
Route::get('iuran/pokok','IuranController@pokokIndex')->name('iuran');
Route::resource('iuran','IuranController',['names'=>[
  'index' => 'iuran'
]]);



Route::post('iuran/bayar-iuran-pokok', 'IuranController@storeIuranPokok')->name('bayar.iuran.pokok');

Route::prefix('pembiayaan')->group(function(){
  Route::get('api/pengajuan/{id}','PeminjamanController@apipembiayaan');
  Route::get('pengajuan/detail/{kode}','PeminjamanController@detail')->name('pembiayaan');
  Route::patch('pengajuan/cancel/{id}','PeminjamanController@cancel');
  Route::patch('pengajuan/aprove/{id}','PeminjamanController@aprove');
  Route::resource('pengajuan','PeminjamanController',['names'=>[
    'index' => 'pembiayaan',
    'create' => 'pembiayaan'
  ]]);

  Route::get('angsuran/detail/{kode}','AngsuranController@detail')->name('pembiayaan');
  Route::get('api/angsuran/{id}','AngsuranController@apiangsuran');
  Route::post('angsuran/bayardp','AngsuranController@bayardp');
  Route::post('angsuran/bayarangsuran','AngsuranController@bayarangsuran');
  Route::resource('angsuran','AngsuranController',['names'=>[
    'index' => 'pembiayaan',
    'create' => 'pembiayaan'
  ]]);
  Route::get('angsuran/savepdf/{kode}', 'AngsuranController@exportPDF')->name('pdf.download');

});

Route::prefix('admin')->group(function(){
  Route::resource('dashboard','AdminDashboardController',['names'=>[
    'index' => 'dashboard'
  ]]);

  Route::get('member', 'MemberController@index')->name('member');
  Route::get('member/create', 'MemberController@create')->name('member');
  Route::get('member/{id}/edit', 'MemberController@edit');
  Route::get('member/{id}/delete', 'MemberController@destroy');
  Route::get('member/{id}/aprove', 'MemberController@aprove');
  Route::get('member/{id}/disaprove', 'MemberController@disaprove');
  Route::post('member/{id}/update', 'MemberController@update')->name('member.update');
  Route::post('member/store','MemberController@store')->name('member.store');
  Route::get('api/member','MemberController@apimember');

  Route::get('transaksi/iuran/aprove/{id}', 'IuranController@aprove')->name('iuranAprove');
  Route::get('transaksi/iuran/disaprove/{kode}', 'IuranController@disaprove')->name('iuranDisaprove');
  Route::get('transaksi/iuranbulanan', 'TransaksiController@indexIuran')->name('transaksi');
  Route::get('transaksi/iuranpokok', 'TransaksiController@indexIuranPokok')->name('transaksi');
  Route::get('pembiayaan/transaksiPembiayaan', 'TransaksiController@indexPembiayaan'); //coba di evalluate
  Route::get('iuran/bulanan', 'IuranController@iuranBulananAdmin')->name('iuran');
  Route::get('iuran/pokok', 'IuranController@iuranPokokAdmin')->name('iuran');
//   Route::get('transaksi/daftarpeminjaman', 'TransaksiController@indexdaftarpeminjaman'); //gak ada linknya

  Route::get('transaksi/aprove/{kode}', 'TransaksiController@aprove');
  Route::get('transaksi/disaprove/{kode}', 'TransaksiController@disaprove');
  Route::get('transaksi/dp', 'TransaksiController@indexdp')->name('transaksi');
  Route::get('transaksi/angsuran', 'TransaksiController@indexangsuran')->name('transaksi');

  // Route::get('transaksi/iuranbulanan/approve/{kode}', 'TransaksiController@approve');


  Route::get('transaksi/dp/aprove/{id}', 'TransaksiController@aprovedp')->name('dpAprove');
  Route::get('transaksi/dp/disaprove/{kode}', 'TransaksiController@disaprovedp')->name('dpDisaprove');
  Route::get('transaksi/angsuran/aprove/{id}/{kode}/{bulan}', 'TransaksiController@aproveangsuran')->name('angsuranAprove');
  Route::get('transaksi/angsuran/disaprove/{id}/{kode}/{bulan}', 'TransaksiController@disaproveangsuran')->name('angsuranDisaprove');

  Route::get('pembiayaan/pengajuan', 'PeminjamanController@pengajuanAdmin')->name('pembiayaan');
  Route::get('pembiayaan/angsuran', 'PeminjamanController@angsuranAdmin')->name('pembiayaan');
  Route::get('pembiayaan/aprove/{kode}', 'PeminjamanController@aprove')->name('pembiayaanAprove');
  Route::get('pembiayaan/disaprove/{kode}', 'PeminjamanController@disaprove')->name('pembiayaanDisaprove');
  Route::get('pembiayaan/detailPengajuan/{kode}', 'PeminjamanController@detailPengajuanAdmin');

  Route::get('pembiayaan/angsuranPembiayaan', 'PeminjamanController@angsuranAdmin');

  Route::get('pengaturan','PengaturanController@index');
  Route::post('pengaturan/update','PengaturanController@update')->name('pengaturan.update');
});

Route::get('api/transaksiiuran', 'TransaksiController@apitransaksiiuran')->name('transaksiiuran');
Route::get('api/transaksiiuranpokok', 'TransaksiController@apitransaksiiuranpokok')->name('transaksiiuranpokok');
Route::get('api/pengajuanadmin', 'PeminjamanController@apipengajuanadmin')->name('apipembiayaanadmin');
Route::get('api/angsuranadmin', 'PeminjamanController@apiangsuranadmin')->name('apiadminadmin');
Route::get('api/transaksidp', 'TransaksiController@apitransaksidp')->name('transaksidp');
Route::get('api/transaksiangsuran', 'TransaksiController@apitransaksiangsuran')->name('transaksiangsuran');

// Route::get('api/transaksidp', 'TransaksiController@transaksidp')->name('apitransaksidp');
