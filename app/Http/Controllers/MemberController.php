<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Iuran;
use Yajra\DataTables\DataTables;
use DB;
use Auth;

class MemberController extends Controller
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
      if (Auth::user()->role == '1') {        
        return view('pages/member/index',[
          'sidebar'=>'indexMember'
        ]);

      }else {

        return view('pages/dashboard',[
          'sidebar'=>'dashboard'
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
      if (Auth::user()->role == '1') {
        return view('pages/member/create',[
          'sidebar'=>'createMember'
        ]);

        // return view ('admin/dashboard', [
        //   'sidebar' => 'dashboard',          
        // ]);
      }else {
        return view('pages/dashboard',[
          'sidebar'=>'dashboard'
        ]);
      }

      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) {
      
    }
    public function store(Request $request)
    {
      if (Auth::user()->role == '1') {
        $auth = 'admin';
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

        
        return redirect('admin/member/create');
      }else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

        
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
      if (Auth::user()->role == '1') {

        $user = User::find($id);
        return view('pages/member/edit',[
          'sidebar'=>'createMember',
          'user' => $user
        ]);

        
      }else {

        return view ('admin/dashboard', [
          'sidebar' => 'dashboard',          
        ]);

      }

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
      return redirect('admin/member');
    }


    public function updateProfile(Request $r)
    {
      // return 1;
      if (Auth::user()->role == '1') {
        return view ('admin/dashboard', [
          'sidebar' => 'dashboard',          
        ]);

      }else {
        
      $id = Auth::user()->id;

      if($r->hasfile('gambar')){

        // save image
        $images = $r->gambar;
        // pemberian nama dengan bantuan time
        $images_new_name = time().$images->getClientOriginalName();
        $images->move('public/uploads/', $images_new_name);


       DB::table('users')->where('id',$id)->update([
        'gambar' => 'public/uploads/'.$images_new_name
        ]);
      }
      else{

        

        DB::table('users')->where('id', $id)->update([
          'name' => $r->nama,
          'email' => $r->email,
          'password' => bcrypt($r->password),
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
      if (Auth::user()->role == '1') {

        $user = User::find($id);
        $user->deleted = 1;
        $user->save();        
        return redirect()->back();

      }else {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }

        

    }

    public function profile(){
      $user = DB::table('users')->where('id', Auth::user()->id)->first();
      
      return view('pages/profile/profile',[
        'sidebar'=>'',
        'user' => $user
      ]);
    }
    public function detail(){

      if (Auth::user()->role == '1') {
        return view ('admin/dashboard', [
          'sidebar' => 'dashboard',          
        ]);
      }else {

        $id = Auth::user()->id;
        $user = User::find($id);

        return view('pages/profile/detail',[
          'sidebar'=>'',
          'user' => $user
        ]);
      }

      
    }

    public function apiMember()
    {

      $user = User::where('deleted',0);

      return DataTables::of($user)
        ->addColumn('action',function($user) {
          return '<a href=" member/'.$user->id.'/edit" class="btn btn-default btn-xs"> Edit </a>'.
           '<a href=" member/'.$user->id.'/delete" class="btn btn-danger btn-xs" > Delete </a>';
        })->escapeColumns([])->make(true);
    }

    

}
