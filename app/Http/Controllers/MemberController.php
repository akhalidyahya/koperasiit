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
        return redirect('dashboard');
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
        return redirect('admin/dashboard');
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
      $data = [
        'name' => $r->nama,
        'email' => $r->email,
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
      ];
      DB::table('users')->where('id', $id)->update($data);
      if($r->password !== '') {
        DB::table('users')->where('id', $id)->update('password',bcrypt($r->password));
      }
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
        return redirect('admin/dashboard');
      }
    }

    public function aprove($id)
    {
      if (Auth::user()->role == '1') {

        $user = User::find($id);
        $user->aproval = 1;
        $user->save();
        return redirect()->back();

      }else {
        return redirect('admin/dashboard');
      }
    }

    public function disaprove($id)
    {
      if (Auth::user()->role == '1') {

        $user = User::find($id);
        $user->aproval = 2;
        $user->save();
        return redirect()->back();

      }else {
        return redirect('admin/dashboard');
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
      //$user = User::where('deleted',0);
      $user = DB::table('users')->where('deleted',0)->where('role','<>',1)->orderBy('created_at','desc');

      return DataTables::of($user)
        ->addColumn('action',function($user) {
          return '
          <div class="btn-group">
            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
              <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="member/'.$user->id.'/aprove">
                  <i class="icon-check"></i> Terima
                </a>
              </li>
              <li>
                <a href="member/'.$user->id.'/disaprove">
                  <i class="icon-close"></i> Tolak
                </a>
              </li>
              <li>
                <a href="member/'.$user->id.'/edit">
                  <i class="icon-wrench"></i> Edit
                </a>
              </li>
              <li>
                <a href="member/'.$user->id.'/delete">
                  <i class="icon-trash"></i> Delete
                </a>
              </li>
            </ul>
          </div>
          ';
        })->addColumn('status',function($user){
          switch ($user->aproval) {
            case 1:
              return '<i class="font-green">Diterima</i>';
              break;

            case 2:
              return '<i class="font-red">Ditolak</i>';
              break;

            default:
              return 'Menunggu';
              break;
          }
        })->escapeColumns([])->make(true);
    }

}
