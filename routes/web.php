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
Route::resource('member','MemberController');

Route::resource('iuran','IuranController',['names'=>[
  'index' => 'iuran'
]]);

Route::prefix('peminjaman')->group(function(){
  Route::get('api/pengajuan/{id}','PeminjamanController@apipeminjaman');
  Route::get('pengajuan/detail/{id}','PeminjamanController@detail')->name('peminjaman');
  Route::patch('pengajuan/cancel/{id}','PeminjamanController@cancel');
  Route::patch('pengajuan/aprove/{id}','PeminjamanController@aprove');
  Route::resource('pengajuan','PeminjamanController',['names'=>[
    'index' => 'peminjaman',
    'create' => 'peminjaman'
  ]]);

  Route::get('angsuran/detail/{id}','AngsuranController@detail')->name('peminjaman');
  Route::get('api/angsuran/{id}','AngsuranController@apiangsuran');
  Route::resource('angsuran','AngsuranController',['names'=>[
    'index' => 'peminjaman',
    'create' => 'peminjaman'
  ]]);
});

Route::prefix('admin')->group(function(){
  Route::resource('dashboard','AdminDashboardController',['names'=>[
    'index' => 'dashboard'
  ]]);
  Route::resource('member','MemberController',['names'=>[
    'index' => 'member',
    'create' => 'member'
  ]]);
});
