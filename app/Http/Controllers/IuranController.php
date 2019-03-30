<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Iuran;
use App\Transaksi;

class IuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $id = 3;
      $iuran_bulanan = DB::table('iurans')->where('user_id',$id)->where('jenis','bulanan')->orderBy('id')->get();
      $bulan = DB::table('iurans')->where('user_id',$id)->where('jenis','bulanan')->where('status','<>',1)->where('status','<>',2)->orderBy('id')->get();
      return view('pages/iuran',[
        'sidebar'=>'iuran',
        'iuran' => $iuran_bulanan,
        'bulan' => $bulan
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
        $id = 3;
        $bulan = $request['bulan'];
        $data = [
          'status' => 2,
          'keterangan' => $request->keterangan,
          'jumlah' => $request->nominal,
          'foto' => $request->bukti->getClientOriginalName()
        ];
        DB::table('iurans')->where('user_id', $id)->where('bulan',$bulan)->update($data);

        $data_transaksi = [
          'kode' => 'iuran_bulan_'.$id.'_'.$bulan,
          'jumlah' => $request->nominal,
          'bulan' => $bulan,
          'tahun' => Date('Y'),
          'keterangan' => $request->keterangan,
          'jenis' => 'iuran',
          'foto' => $request->bukti->getClientOriginalName(),
          'aproval' => 0,
          'user_id' => $id
        ];
        Transaksi::create($data_transaksi);
        return redirect('iuran');
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

    public function aprove($kode){
      // $transaksi = Transaksi::find($kode);
      //
      // dd($transaksi);

      DB::table('transaksis')->where('kode', $kode)->update([
          'aproval' => 1
      ]);
      //
      //
      // $iuran = Iuran::find($id);

      DB::table('iurans')->where('kode', $kode)->update([
          'status' => 1
      ]);
      return redirect()->back();
    }

    public function disaprove($kode){
      DB::table('transaksis')->where('kode', $kode)->update([
          'aproval' => 2
      ]);
      //
      //
      // $iuran = Iuran::find($id);

      DB::table('iurans')->where('kode', $kode)->update([
          'status' => 2
      ]);
      return redirect()->back();
    }
}
