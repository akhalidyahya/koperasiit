<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class AdminDashboardController extends Controller
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
    public function index()
    {
      $role = Auth::user()->role;
        if($role == 0){

            redirect('dashboard');

        }elseif($role == 1){
            $countMember = DB::table('users')
                ->where('role', '=', 0  )
                ->count();

            $countPeminjaman = DB::table('peminjamen')
                ->count();

            $countTransaksi = DB::table('transaksis')
                // ->where(DB::raw("to_char(created_at, 'yyyy-mm-dd') = to_char(CURRENT_DATE, 'yyyy-mm-dd'"))
                // ->where(DB::raw("to_char(created_at, 'yyyy-mm-dd') = ".date("Y-m-d")))
                // ->select(DB::raw("count(*) as aggregate"))
                ->count();
                // ->get();

            $recentTransaksi = DB::table('transaksis')
                ->join('users', 'users.id', '=', 'transaksis.user_id')
                ->orderBy('transaksis.created_at', 'DSC')
                ->limit(5)
                ->select('users.name', 'transaksis.created_at', 'transaksis.jenis', 'transaksis.jumlah')
                ->get();

            return view('admin/dashboard',[
                'sidebar'=>'dashboard',
                'jumlahMember' => $countMember,
                'countPeminjaman' => $countPeminjaman,
                'countTransaksi' => $countTransaksi,
                'recentTransaksi' => $recentTransaksi
              ]);
            // return $recentTransaksi;
            // return $countMember;
        }else{
            redirect('login');
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
}
