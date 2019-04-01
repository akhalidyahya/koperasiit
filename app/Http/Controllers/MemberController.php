<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Iuran;
use Yajra\DataTables\DataTables;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('pages/member/index',[
        'sidebar'=>'indexMember'
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pages/member/create',[
        'sidebar'=>'createMember'
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
        $auth = 'admin';        
        $data = [
          'name' => $request['nama'],
          'email' => $request['email'],
          'password' => $request['password'],
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

        // Nanti tinggal di if else kalo admin redirect ke table view, kalo register user reirect login
        return redirect('/login');
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
      
        $user = User::find($id);        
        return view('pages/member/edit',[
          'sidebar'=>'createMember',
          'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
      DB::table('users')->where('id', $id)->update([
        'name' => $r->nama,
        'email' => $r->email,
        'password' => $r->password,
        'ttl' => $r->ttl,
        'jk' => $r->jk,
        'identitas' => $r->identitas,
        'alamat' => $r->alamat,
        'hp' => $r->hp,
        'pekerjaan' => $r->pekerjaan,
        'pendapatan' => $r->pendapatan,
        'nama_lembaga' => $r->nama_lembaga,
        'pegawaian' => $r->pegawaian,
        'no_lembaga' => $r->no_lembaga,        
      ]);
      return redirect()->route('member.index');
    }


    public function updateProfile(Request $r)
    {
      // return 1;
      $id = 1;      

      if($r->hasfile('gambar')){

       DB::table('users')->where('id',$id)->update([
          'gambar' => $r->gambar->getClientOriginalName()
        ]);
      }
      else{

        DB::table('users')->where('id', $id)->update([
          'name' => $r->nama,
          'email' => $r->email,
          'password' => $r->password,
          'ttl' => $r->ttl,
          'jk' => $r->jk,
          'identitas' => $r->identitas,
          'alamat' => $r->alamat,
          'hp' => $r->hp,
          'pekerjaan' => $r->pekerjaan,
          'pendapatan' => $r->pendapatan,
          'nama_lembaga' => $r->nama_lembaga,
          'pegawaian' => $r->pegawaian,
          'no_lembaga' => $r->no_lembaga,        
        ]);
      }

      return redirect('profile/detail');

      return 1;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $user = User::find($id);
        $user->deleted = 1;
        $user->save();
        
        // $user->forceDelete();
        // DB::table('users')->where('id', $id)->delete();
        // DB::table('iurans')->where('user_id', $id)->delete();
          // return 1;
        // $user = User::find($id);
        // $user->delete();
        
        

        // $request->session()->flush();
        // $request->session()->flash('success', 'Your data was deleted!');
        return redirect()->back();
        
    }

    public function profile(){
      return view('pages/profile/profile',[
        'sidebar'=>''
      ]);
    }
    public function detail(){

      $id = 1;
      $user = User::find($id);

      return view('pages/profile/detail',[
        'sidebar'=>'',
        'user' => $user
      ]);
    }

    public function apiMember()
    {
      
      $user = User::where('deleted',0);

      return DataTables::of($user)
        ->addColumn('action',function($user) {
          return '<a href=" member/ '.$user->id.'/edit" class="btn btn-default btn-xs"> Edit </a>'.
           '<a href=" member/ '.$user->id.'/delete" class="btn btn-danger btn-xs" > Delete </a>';
        })->escapeColumns([])->make(true);
    }

    // public function account(){
    //   $id = 1;

    //   $user = User::find($id);

    //   return view('pages.profile.detail',[
    //     'user'=> $user
    //   ]);

    //   }

}