<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Option;

class PengaturanController extends Controller
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
        // return view('admin/option',[
        //   'sidebar' => 'pengaturan',
        //   'pengaturan' => Option::orderBy('id','asc')->get()
        // ]);

        // $role = app('App\Http\Controllers\DashboardController')->getRole();
        // if($role == 'user'){

        //     return view('pages/dashboard',[
        //         'sidebar'=>'dashboard',
        //     ]
        //       );

        // }elseif($role == 'admin'){
        //     return view('admin/option',[
        //         'sidebar' => 'pengaturan',
        //         'pengaturan' => Option::orderBy('id','asc')->get()
        //       ]);
        // }else{
        //     redirect('login');
        // }




    if (Auth::user()->role == '1') {

        return view('admin/option',[
            'sidebar' => 'pengaturan',
            'pengaturan' => Option::orderBy('id','asc')->get()
        ]);

    }
    else {
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
    public function update(Request $request)
    {
        if (Auth::user()->role == '1') {

            $admin = str_replace(',','',$request->admin);
            DB::table('options')->where('name', 'margin')->update([
                'value' => $request->margin
            ]);

            DB::table('options')->where('name', 'administrasi')->update([
                'value' => $admin
            ]);

            $pokok = str_replace(',','',$request->pokok);
            DB::table('options')->where('name', 'pokok')->update([
                'value' => $pokok
            ]);

            $bulanan = str_replace(',','',$request->bulanan);
            DB::table('options')->where('name', 'bulanan')->update([
                'value' => $bulanan
            ]);

            return redirect()->back();

        }else {
            return redirect('dashboard');
        }


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
