<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;
use App\Transaksi;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('pages/angsuran/index',[
        'sidebar'=>'angsuran'
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

    public function detail($kode)
    {
      $peminjaman = Peminjaman::where('kode',$kode)->first();
      $id = $peminjaman->id;
      $angsuran = DB::table('angsurans')->where('peminjaman_id',$id)->orderBy('id','asc')->get();
      $bulan_form = DB::table('angsurans')->where('peminjaman_id',$id)->where('status','<>',1)->where('status','<>',2)->orderBy('id','asc')->get();

      return view('pages/angsuran/detail',[
        'sidebar'=>'angsuran',
        'peminjaman' => $peminjaman,
        'angsuran' => $angsuran,
        'bulan' => $bulan_form
      ]);
    }

    public function detailangsuran($kode){
    //   $pengajuan = Peminjaman::find($id);
    $pengajuan = DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->get();

      return view ('admin/peminjaman/detailangsuran', [
        'sidebar' => 'angsuran',
        'pengajuan' => $pengajuan
      ]);
    // return $pengajuan[0]->status;
    }

    public function apiangsuran($id)
    {
      // $id = 3;
      $peminjaman = Peminjaman::where('user_id',$id)->where('status',1)->orderBy('id','desc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="angsuran/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->escapeColumns([])->make(true);
    }

    public function apiangsuranall()
    {
      // $id = 3;
      $peminjaman = Peminjaman::where('status',1)->orderBy('id','desc');
      $data = DB::table('peminjamen')
      ->join('users','users.id', '=', 'peminjamen.user_id')
      ->where('peminjamen.status',1)
      ->orderBy('transaksis.id','desc')->get();

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="angsuran/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->escapeColumns([])->make(true);
    }

    public function bayardp(Request $request){
      $peminjaman = Peminjaman::where('id',$request->id)->first();
      $data = [
        'kode' => $peminjaman->kode,
        'jumlah' => $request['nominal'],
        'bulan' => Date('n'),
        'tahun' => Date('Y'),
        'keterangan' => $request['keterangan'],
        'foto' => $request['bukti']->getClientOriginalName(),
        'jenis' => 'dp',
        'aproval' => 0,
        'user_id' => $peminjaman->user_id,
      ];
      Transaksi::create($data);

      $peminjaman->status_dp = 2;
      $peminjaman->update();

      return redirect("peminjaman/angsuran/detail/$peminjaman->kode");
    }

    public function bayarangsuran(Request $request){
      $peminjaman = Peminjaman::where('id',$request->id)->first();
      $data = [
        'kode' => $peminjaman->kode,
        'jumlah' => $request['nominal'],
        'bulan' => $request['bulan'],
        'tahun' => Date('Y'),
        'keterangan' => $request['keterangan'],
        'foto' => $request['bukti']->getClientOriginalName(),
        'jenis' => 'angsuran',
        'aproval' => 0,
        'user_id' => $peminjaman->user_id,
      ];
      Transaksi::create($data);

      $angsuran = Angsuran::where('peminjaman_id',$request->id)->where('bulan',$request['bulan'])->first();
      $angsuran->status = 2;
      $angsuran->update();

      return redirect("peminjaman/angsuran/detail/$peminjaman->kode");
    }

    public function aprovedp($id){
      $peminjaman = Peminjaman::where('id',$request->id)->first();
      $peminjaman->status_dp = 1;
      $peminjaman->update();
    }
}
