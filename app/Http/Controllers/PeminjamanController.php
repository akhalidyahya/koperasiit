<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\Option;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      return view('pages/pengajuan/index',[
        'sidebar'=>'pengajuan',
        'pengaturan' => Option::orderBy('id')->get()
      ]);
    }

    public function pengajuanAdmin(){
      return view('admin/peminjaman/pengajuan',[
        'sidebar' => 'pengajuan',
      ]);
    }

    public function angsuranAdmin(){
      return view('admin/peminjaman/angsuran',[
        'sidebar' => 'angsuran'
      ]);
    }

    //ini buat admin

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pages/pengajuan/create',[
        'sidebar'=>'pengajuan',
        'pengaturan' => Option::orderBy('id')->get()
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengaturan = Option::orderBy('id')->get();
        $id = 3;
        // $id = 1;
        $admin = $pengaturan[1]->value;
        $margin = (float)$pengaturan[0]->value;
        $random = substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'),0,10);
        $data = [
          'kode' => $random,
          'jumlah' => $request['jumlah'],
          'angsuran' => $request['angsuran'],
          'dp' => $request['dp'],
          'keperluan' => $request['keperluan'],
          'sk' => $request->sk->getClientOriginalName(),
          'ktp' => $request->ktp->getClientOriginalName(),
          'kk' => $request->kk->getClientOriginalName(),
          'slip' => $request->slip->getClientOriginalName(),
          'jaminan' => '',
          'margin' => $margin,
          'after_margin' => $request['after_margin'],
          'biaya_admin' => $admin,
          'pokok' => $request['pokok'],
          'angsuran_bulanan' => $request['angsuran_bulanan'],
          'user_id' => $id,
          'status' => 0
        ];

        Peminjaman::create($data);

        return redirect('peminjaman/pengajuan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($kode)
    {
      $peminjaman = Peminjaman::where('kode',$kode)->first();

      return view('pages/pengajuan/detail',[
        'sidebar'=>'pengajuan',
        'peminjaman' => $peminjaman
      ]);
    }

    public function cancel($id)
    {
      $peminjaman = Peminjaman::find($id);
      $peminjaman->status = 3;
      $peminjaman->update();
    }

    public function aprove($kode){
    //   $peminjaman = Peminjaman::find($kode);
    //   $peminjaman->status = 1;
    //   $peminjaman->update();

    DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->update([
        'status' => 1
        ]);

    $peminjaman = DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->get();

    // return $peminjaman;

      $temp_pokok = $peminjaman[0]->pokok;
      $pokok = number_format($temp_pokok);
      for ($i=1; $i <= $peminjaman[0]->angsuran ; $i++) {
        $data=[
          'bulan' => $i,
          'pokok' => $pokok,
          'angsuran' => number_format($peminjaman[0]->angsuran_bulanan),
          'saldo' => number_format($temp_pokok - $peminjaman[0]->angsuran_bulanan),
          'status' => 0,
          'peminjaman_id' => $peminjaman[0]->id
        ];
        $temp_pokok-=$peminjaman[0]->angsuran_bulanan;
        Angsuran::create($data);
      }

      return redirect('admin/peminjaman/pengajuanPeminjaman');
    }

    public function disaprove($kode){
      $peminjaman = Peminjaman::where('kode',$kode)->first();
      $peminjaman->status = 2;
      $peminjaman->update();
      return redirect('admin/peminjaman/pengajuanPeminjaman');
    }

    public function apipeminjaman($id)
    {
      // $id = 3
      // $id = 1;
      $peminjaman = Peminjaman::where('user_id',$id)->orderBy('id','desc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="pengajuan/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->addColumn('status',function($peminjaman) {
          if ($peminjaman->status == 0) {
            return 'Waiting';
          } elseif ($peminjaman->status == 1) {
            return '<span class="font-green">Accepted</span>';
          } else if($peminjaman->status == 2) {
            return '<span class="font-red">Declined</span>';
          }else if($peminjaman->status == 3) {
            return '<span class="font-red">Canceled</span>';
          } else {
            return 'something went wrong';
          }
        })->escapeColumns([])->make(true);
    }

    public function apipengajuanadmin(){
      // $peminjaman = Peminjaman::join('users', 'users.id = peminjamen.id')->where('peminjamen.status', 0)->orderby('peminjamen.created_at')->get();
      $peminjaman = DB::table('peminjamen')
      ->join('users', 'users.id', '=', 'peminjamen.user_id')
      ->where('peminjamen.status', '=', 0)
      ->orderBy('peminjamen.created_at')
      ->select('*')
      ->get();

      return DataTables::of($peminjaman)
      ->addColumn('detail',function($peminjaman) {
        return '<a href="detailPengajuan/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
      })->escapeColumns([])->make(true);
    }

    public function detailPengajuanAdmin($kode){
    //   $pengajuan = Peminjaman::find($id);
    $pengajuan = DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->get();

      return view ('admin/peminjaman/detailPengajuan', [
        'sidebar' => 'pengajuan',
        'pengajuan' => $pengajuan
      ]);
    // return $pengajuan[0]->status;
    }

    public function apiangsuranadmin()
    {
      // $id = 3;
    //   $peminjaman = Peminjaman::where('status',1)->orderBy('id','desc');
    $peminjaman = DB::table('peminjamen')
    ->join('users', 'peminjamen.user_id', 'users.id')
    ->where('peminjamen.status', '=', 1)
    ->orderBy('peminjamen.id','desc')
    ->get();

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="'.url('admin/peminjaman/detail/angsuran').'/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->escapeColumns([])->make(true);
    }

}
