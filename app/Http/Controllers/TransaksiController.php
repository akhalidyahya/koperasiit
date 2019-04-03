<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Transaksi;
use App\Iuran;
use App\Peminjaman;
use DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIuran()
    {
        return view('admin/iuran/transaksiIuran', [
          'sidebar'=>'transaksiIuran'
        ]);

    }

    public function indexIuranPokok()
    {
        return view('admin/iuran/transaksiiuranpokok', [
          'sidebar'=>'transaksiIuranPokok'
        ]);

    }

    public function indexdaftarpeminjaman()
    {
        return view('admin/peminjaman/pengajuan', [
          'sidebar'=>'daftarpeminjaman'
        ]);

    }

    public function indexPeminjaman()
    {
        return view('admin/peminjaman/transaksiPeminjaman', [
          'sidebar'=>'transaksiPeminjaman'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function apitransaksiiuran()
    {
      // $id = 3;

    //   $transaksiIuran = Transaksi::where('jenis', 'iuran')->where('aproval',0)->where('bulan', '!=', 0)->orderBy('id','desc')->get();
        $transaksiIuran = DB::table('transaksis')
        ->join('users', 'transaksis.user_id', '=', 'users.id')
        ->select('users.name', 'transaksis.kode', 'transaksis.created_at', 'transaksis.jumlah','transaksis.bulan')
        ->where('jenis', 'iuran')->where('aproval',0)->where('bulan', '!=', 0)->orderBy('transaksis.created_at','desc')->get();

        // dd($transaksiIuran);

      return DataTables::of($transaksiIuran)
        ->addColumn('aprove',function($transaksiIuran) {
          return '<a href="aprove/'.$transaksiIuran->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($transaksiIuran) {
          return '<a href="disaprove/'.$transaksiIuran->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }

    public function apitransaksiiuranpokok()
    {
      // $id = 3;
      $transaksiIuran = Transaksi::where('jenis', 'iuran')->where('aproval',0)->where('bulan', 0)->orderBy('id','desc')->get();

      return DataTables::of($transaksiIuran)
        ->addColumn('aprove',function($transaksiIuran) {
          return '<a href="aprove/'.$transaksiIuran->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($transaksiIuran) {
          return '<a href="disaprove/'.$transaksiIuran->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }



    // public function apipengajuanadmin(){

    //     $peminjaman = Peminjaman::where('status', 0)->orderby('created_at')->get();

    //     return DataTables::of($peminjaman)
    //     ->addColumn('aprove',function($peminjaman) {
    //         return '<a href="aprove/'.$peminjaman->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
    //       })->addColumn('disaprove',function($peminjaman) {
    //         return '<a href="disaprove/'.$peminjaman->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
    //       })->escapeColumns([])->make(true);
    // }

    public function aprove($kode){
        
        // DB::table('peminjamen')->where('kode', $kode)->update([
        //     'status'=> 1
        // ]);

        // $t = DB::table('peminjamen')->where('kode', $kode)->get();
        // return redirect('admin/peminjaman/pengajuanPeminjaman');
        // return $t[0]->status;

        DB::table('transaksis')->where('kode', $kode)->update([
            'aproval' =>1
        ]);
        DB::table('iurans')->where('kode', $kode)->update([
            'status' => 1
        ]);
        return redirect('admin/peminjaman/pengajuanPeminjaman');

    }

    public function disaprove($kode){

        DB::table('transaksis')->where('kode', $kode)->update([
            'aproval' =>2
        ]);
        DB::table('iurans')->where('kode', $kode)->update([
            'status' => 3
        ]);
        return redirect('admin/peminjaman/pengajuanPeminjaman');
    }

}
