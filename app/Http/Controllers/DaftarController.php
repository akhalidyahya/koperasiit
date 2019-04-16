<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Iuran;
use Yajra\DataTables\DataTables;
use DB;
use Auth;

class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = [
            'name' => $request['nama'],
            'email' => $request['email'],
            'password' => bcrypt($request->password),
            'ttl' => $request['ttl'],
            'jk' => $request['jk'],
            'identitas' => $request['identitas'],
            'alamat' => $request['alamat'],
            'hp' => $request['hp'],
            'pekerjaan' => $request['pekerjaan'],
            'pendapatan' => $request['pendapatan'],
            'nama_lembaga' => $request['nama_lembaga'],
            'alamat_lembaga' => $request['alamat_lembaga'],
            'pegawaian' => $request['pegawaian'],
            'no_lembaga' => $request['no_lembaga']
          ];
          User::create($data);
    
          $added_user = User::orderBy('id','desc')->first();
    
          $data_iuran_pokok = [
            'kode' => 'iuran_pokok_'.$added_user->id,
            'jenis' => 'pokok',
            'bulan' => 0,
            'tahun' => Date("Y"),
            'status' => 0,
            'user_id' => $added_user->id
          ];
    
          Iuran::create($data_iuran_pokok);
          for ($i=1; $i <= 12 ; $i++) {
            $data_iuran_bulanan = [
              'kode' => 'iuran_bulan_'.$added_user->id.'_'.$i,
              'jenis' => 'bulanan',
              'bulan' => $i,
              'tahun' => Date("Y"),
              'status' => 0,
              'user_id' => $added_user->id
            ];
            Iuran::create($data_iuran_bulanan);
          }
    
          $request->session()->flush();
          $request->session()->flash('success', 'Your register was success!');
    
          return redirect('login');
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
