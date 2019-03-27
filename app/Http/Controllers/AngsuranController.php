<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;

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

    public function detail($id)
    {
      $peminjaman = Peminjaman::find($id);
      $angsuran = DB::table('angsurans')->where('peminjaman_id',$id)->orderBy('id','asc')->get();
      // print_r($angsuran);
      return view('pages/angsuran/detail',[
        'sidebar'=>'angsuran',
        'peminjaman' => $peminjaman,
        'angsuran' => $angsuran
      ]);
    }

    public function apiangsuran($id)
    {
      // $id = 3;
      $peminjaman = Peminjaman::where('user_id',$id)->where('status',1)->orderBy('id','desc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="angsuran/detail/'.$peminjaman->id.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->escapeColumns([])->make(true);
    }
}
