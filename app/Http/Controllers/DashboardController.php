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
                ->get();

            return view('pages/dashboard',[            
                'sidebar'=>'dashboard',
                'peminjaman'=>$peminjaman
              ]);

        }elseif($isadmin == 'admin'){
            return view('admin/dashboard',[            
                'sidebar'=>'dashboard'
              ]);
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
