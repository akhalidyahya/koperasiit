<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Transaksi;
use App\Iuran;
use App\Peminjaman;
use DB;
use Auth;

class TransaksiController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIuran()    
    {
      if(Auth::user()->role == '1'){
          return view('admin/iuran/transaksiIuran', [
            'sidebar'=>'transaksiIuran'
          ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }
        

    }

    public function indexIuranPokok()
    {

      if(Auth::user()->role == '1'){
        return view('admin/iuran/transaksiiuranpokok', [
          'sidebar'=>'transaksiIuranPokok'
        ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

    }

    public function indexdaftarpeminjaman()
    {
      if(Auth::user()->role == '1'){
        return view('admin/peminjaman/pengajuan', [
          'sidebar'=>'daftarpeminjaman'
        ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }
    }

    public function indexdp()
    {

      if(Auth::user()->role == '1'){
        return view('admin/transaksi/dp', [
          'sidebar'=>'transaksidp'
        ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

    }

    public function indexPeminjaman()
    {

      if(Auth::user()->role == '1'){
        return view('admin/peminjaman/transaksiPeminjaman', [
          'sidebar'=>'transaksiPeminjaman'
        ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

        
    }

    public function indexAngsuran()
    {

      if(Auth::user()->role == '1'){
        return view('admin/transaksi/angsuran', [
          'sidebar'=>'transaksiangsuran'
        ]);
      }else{
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

        

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
        // $transaksiIuran = DB::table('transaksis')
        // ->join('users', 'transaksis.user_id', '=', 'users.id')
        // ->select('users.name', 'transaksis.kode', 'transaksis.created_at', 'transaksis.jumlah','transaksis.bulan')
        // ->where('jenis', 'iuran')->where('aproval',0)->where('bulan', '!=', 0)->orderBy('transaksis.created_at','desc')->get();

        // dd($transaksiIuran);

      // $transaksiIuran = Transaksi::where('jenis', 'iuran')->where('aproval',0)->where('bulan', '!=', 0)->orderBy('id','desc')->get();
      $transaksiIuran = DB::table('transaksis')
      ->join('users','users.id', '=', 'transaksis.user_id')
      ->where('jenis','iuran')
      ->where('aproval',0)
      ->where('bulan','<>', 0)
      ->orderBy('transaksis.id','desc')->get();


      return DataTables::of($transaksiIuran)
        ->addColumn('aprove',function($transaksiIuran) {
          return '<a href="iuran/aprove/'.$transaksiIuran->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($transaksiIuran) {
          return '<a href="iuran/disaprove/'.$transaksiIuran->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }

    public function apitransaksiiuranpokok()
    {
      // $id = 3;
      $transaksiIuran = DB::table('transaksis')
      ->join('users','users.id', '=', 'transaksis.user_id')
      ->where('aproval',0)
      ->where('bulan', 0)
      ->orderBy('transaksis.id','desc')->get();

      return DataTables::of($transaksiIuran)
        ->addColumn('aprove',function($transaksiIuran) {
          return '<a href="iuran/aprove/'.$transaksiIuran->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($transaksiIuran) {
          return '<a href="iuran/disaprove/'.$transaksiIuran->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }

    public function apitransaksidp()
    {
      // $id = 3;
      // $data = DB::table('transaksis')
      // ->join('users','users.id', '=', 'transaksis.user_id')
      // ->where('aproval',0)
      // ->where('jenis', 'dp')
      // ->orderBy('transaksis.id','desc')->get();

      $data = DB::table('transaksis')
      ->join('users', 'transaksis.user_id', '=', 'users.id')
      ->select('users.name', 'transaksis.kode', 'transaksis.jumlah', 'transaksis.created_at' )
      ->where('aproval', 0)
      ->where('jenis', 'dp')
      ->orderBy('transaksis.id', 'desc')
      ->get();




      return DataTables::of($data)
        ->addColumn('aprove',function($data) {
          return '<a href="dp/aprove/'.$data->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($data) {
          return '<a href="dp/disaprove/'.$data->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }

    public function apitransaksiangsuran()
    {
      // $id = 3;
      $data = DB::table('transaksis')
      ->join('users','users.id', '=', 'transaksis.user_id')
      // ->join('users','users.id', '=', 'peminjaman.user_id')
      ->where('transaksis.aproval',0)
      ->where('transaksis.jenis', 'angsuran')
      ->orderBy('transaksis.id','desc')->get();

      return DataTables::of($data)
        ->addColumn('kode',function($data) {
          return '<a href="'.url('peminjaman/angsuran/detail').'/'.$data->kode.'"> '.$data->kode.' </a>';
        })
        ->addColumn('aprove',function($data) {
          $peminjaman = Peminjaman::where('kode',$data->kode)->first();
          return '<a href="'.url('admin/transaksi/angsuran/aprove').'/'.$peminjaman->id.'/'.$data->kode.'/'.$data->bulan.'" class="btn btn-primary btn-xs"> Aprove </a>';
        })->addColumn('disaprove',function($data) {
          $peminjaman = Peminjaman::where('kode',$data->kode)->first();
          return '<a href="'.url('admin/transaksi/angsuran/disaprove').'/'.$peminjaman->id.'/'.$data->kode.'/'.$data->bulan.'" class="btn btn-danger btn-xs"> Disaprove </a>';
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

        if(Auth::user()->role == '1'){

          DB::table('transaksis')->where('kode', $kode)->update([
            'aproval' =>1
          ]);
          DB::table('iurans')->where('kode', $kode)->update([
              'status' => 1
          ]);
          return redirect('admin/peminjaman/pengajuanPeminjaman');

        }
        else{

          return view('pages/dashboard', [
            'sidebar' => 'dashboard'
          ]);

        }

        

    }

    public function disaprove($kode){

      if (Auth::user()->role == '1') {

        DB::table('transaksis')->where('kode', $kode)->update([
          'aproval' =>2
      ]);
        DB::table('iurans')->where('kode', $kode)->update([
            'status' => 3
        ]);
        return redirect('admin/peminjaman/pengajuanPeminjaman');

      }
      else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);

      }


        
    }

    public function aprovedp($kode){

      if (Auth::user()->role == '1') {

        DB::table('transaksis')->where('jenis','dp')->where('kode', $kode)->update([
          'aproval'=> 1
        ]);
        DB::table('peminjamen')->where('kode', $kode)->update([
          'status_dp'=> 1
        ]);
        return redirect()->back();

      }
      else {

        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);

      }
    }

    public function disaprovedp($kode){

      if (Auth::user()->role == '1') {

        DB::table('peminjamen')->where('kode', $kode)->update([
          'status_dp'=> 3
        ]);
        DB::table('transaksis')->where('kode', $kode)->update([
          'aproval'=> 2
        ]);
        return redirect()->back();

      }else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }


      

    }

    public function aproveangsuran($id,$kode,$bulan){

      if (Auth::user()->role == '1') {

        DB::table('transaksis')->where('kode', $kode)->update([
          'aproval'=> 1
        ]);
        DB::table('angsurans')->where('bulan',$bulan)->where('peminjaman_id', $id)->update([
          'status'=> 1
        ]);
        return redirect()->back();

      }else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

      
    }

    public function disaproveangsuran($id,$kode,$bulan){

      if (Auth::user()->role == '1') {

        DB::table('transaksis')->where('jenis','angsuran')->where('kode', $kode)->update([
          'aproval'=> 2
        ]);
        DB::table('angsurans')->where('bulan',$bulan)->where('peminjaman_id', $id)->update([
          'status'=> 3
        ]);
        return redirect()->back();

      }else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }      
    }

}
