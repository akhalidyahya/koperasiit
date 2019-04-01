<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

use App\Transaksi;
use App\Iuran;
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
      $transaksiIuran = Transaksi::where('jenis', 'iuran')->where('aproval',0)->orderBy('id','desc');

      return DataTables::of($transaksiIuran)
        ->addColumn('aprove',function($transaksiIuran) {
          return '<a href="aprove/'.$transaksiIuran->kode.'" class="btn btn-primary btn-xs"> Aprove </a>';

        })->addColumn('disaprove',function($transaksiIuran) {
          return '<a href="disaprove/'.$transaksiIuran->kode.'" class="btn btn-danger btn-xs"> Disaprove </a>';
        })->escapeColumns([])->make(true);
    }


}
