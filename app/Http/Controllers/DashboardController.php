<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardController extends Controller
{
    private $role;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $isadmin = $this->dologin();

        if($isadmin == 'user'){
            $peminjaman = DB::table('peminjamen')
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('status')
                ->limit(3)
                ->get();

            return view('pages/dashboard',[            
                'sidebar'=>'dashboard',
                'peminjaman'=>$peminjaman
              ]);

        }elseif($isadmin == 'admin'){
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

            // return view('admin/dashboard',[            
            //     'sidebar'=>'dashboard',
            //     'jumlahMember' => $countMember,
            //     'countPeminjaman' => $countPeminjaman,
            //     'countTransaksi' => $countTransaksi,
            //     'recentTransaksi' => $recentTransaksi
            //   ]);
            // return $recentTransaksi;
            return $countMember;
        }else{
            redirect('login');
        }
    }

    public function dologin(){
        $isadmin = Auth::user()->role;
        if($isadmin == '0' ){
            return 'user';
        }elseif($isadmin == '1'){
            return 'admin';
        }else{
            redirect('login');
        }
    }

    public function getRole(){
        $role = $this->dologin();
        return $role;
    }


}
