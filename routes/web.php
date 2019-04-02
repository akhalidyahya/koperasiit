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

Route::prefix('peminjaman')->group(function(){
  Route::get('api/pengajuan/{id}','PeminjamanController@apipeminjaman');
  Route::get('pengajuan/detail/{kode}','PeminjamanController@detail')->name('peminjaman');
  Route::patch('pengajuan/cancel/{id}','PeminjamanController@cancel');
  Route::patch('pengajuan/aprove/{id}','PeminjamanController@aprove');
  Route::resource('pengajuan','PeminjamanController',['names'=>[
    'index' => 'peminjaman',
    'create' => 'peminjaman'
  ]]);

  Route::get('angsuran/detail/{kode}','AngsuranController@detail')->name('peminjaman');
  Route::get('api/angsuran/{id}','AngsuranController@apiangsuran');
  Route::post('angsuran/bayardp','AngsuranController@bayardp');
  Route::post('angsuran/bayarangsuran','AngsuranController@bayarangsuran');
  Route::resource('angsuran','AngsuranController',['names'=>[
    'index' => 'peminjaman',
    'create' => 'peminjaman'
  ]]);
});

Route::prefix('admin')->group(function(){
  Route::resource('dashboard','AdminDashboardController',['names'=>[
    'index' => 'dashboard'
  ]]);

  Route::get('member', 'MemberController@index')->name('member');
  Route::get('member/create', 'MemberController@create')->name('member');
  Route::get('member/{id}/edit', 'MemberController@edit');
  Route::get('member/{id}/delete', 'MemberController@destroy');
  Route::post('member/{id}/update', 'MemberController@update')->name('member.update');
  Route::get('api/member','MemberController@apimember');

  Route::get('iuran/aprove/{kode}', 'IuranController@aprove')->name('iuranAprove');
  Route::get('iuran/disaprove/{kode}', 'IuranController@disaprove')->name('iuranDisaprove');
  Route::get('transaksi/iuranbulanan', 'TransaksiController@indexIuran')->name('transaksi');
  Route::get('transaksi/iuranpokok', 'TransaksiController@indexIuranPokok')->name('transaksi');
  Route::get('peminjaman/transaksiPeminjaman', 'TransaksiController@indexPeminjaman'); //coba di evalluate
  Route::get('iuran/iuranBulanan', 'IuranController@iuranBulananAdmin');
  Route::get('iuran/iuranPokok', 'IuranController@iuranPokokAdmin');
  Route::get('transaksi/daftarpeminjaman', 'TransaksiController@indexdaftarpeminjaman'); //coba dievaluate

  Route::get('transaksi/aprove/{kode}', 'TransaksiController@aprove');
  Route::get('transaksi/disaprove/{kode}', 'TransaksiController@disaprove');

  Route::get('peminjaman/pengajuanPeminjaman', 'PeminjamanController@pengajuanAdmin');
  Route::get('peminjaman/angsuranPeminjaman', 'PeminjamanController@angsuranAdmin');
  Route::get('peminjaman/aprove/{id}', 'PeminjamanController@aprove')->name('peminjamanAprove');
  Route::get('peminjaman/disaprove/{id}', 'PeminjamanController@disaprove')->name('peminjamanDisaprove');
  Route::get('peminjaman/detailPengajuan/{id}', 'PeminjamanController@detailPengajuanAdmin');

  Route::get('pengaturan','PengaturanController@index');
  Route::post('pengaturan/update','PengaturanController@update')->name('pengaturan.update');
});

Route::get('api/transaksiiuran', 'TransaksiController@apitransaksiiuran')->name('transaksiiuran');
Route::get('api/transaksiiuranpokok', 'TransaksiController@apitransaksiiuranpokok')->name('transaksiiuranpokok');
Route::get('api/pengajuanadmin', 'PeminjamanController@apipengajuanadmin')->name('apipeminjamanadmin');

// Route::get('api/transaksidp', 'TransaksiController@transaksidp')->name('apitransaksidp');
