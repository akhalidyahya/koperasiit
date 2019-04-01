<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;
use Illuminate\Support\Facades\DB;
use App\Transaksi;

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
        'sidebar'=>'pengajuan'
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
        'sidebar'=>'pengajuan'
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
        $id = 1;
        $admin = 250000;
        $margin = .1;
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

    public function detail($id)
    {
      $peminjaman = Peminjaman::find($id);

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

    public function aprove($id){
      $peminjaman = Peminjaman::find($id);
      $peminjaman->status = 1;
      $peminjaman->update();

      $temp_pokok = $peminjaman->pokok;
      for ($i=1; $i <= $peminjaman->angsuran ; $i++) {
        $pokok = number_format($temp_pokok);
        $data=[
          'bulan' => $i,
          'pokok' => $pokok,
          'angsuran' => number_format($peminjaman->angsuran_bulanan),
          'saldo' => number_format($temp_pokok - $peminjaman->angsuran_bulanan),
          'status' => 0,
          'peminjaman_id' => $id
        ];
        $temp_pokok-=$peminjaman->angsuran_bulanan;
        Angsuran::create($data);
      }
    }

    public function apipeminjaman($id)
    {
      // $id = 3;
      $peminjaman = Peminjaman::where('user_id',$id)->orderBy('id','desc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="pengajuan/detail/'.$peminjaman->id.'" class="btn btn-default btn-xs"> Detail </a>';
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
            return '<span class="font-grey">Canceled</span>';
          } else {
            return 'something went wrong';
          }
        })->escapeColumns([])->make(true);
    }

}
