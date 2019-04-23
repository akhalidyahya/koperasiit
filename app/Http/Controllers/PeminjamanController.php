<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\Option;
use Auth;
use Mail;

class PeminjamanController extends Controller
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

        // return view ('admin/dashboard', [
        //   'sidebar' => 'dashboard',
        // ]);
        redirect()->route('admin/dashboard');

      }elseif(Auth::user()->role == '0') {

        return view('pages/pengajuan/index',[
          'sidebar'=>'pengajuan',
          'pengaturan' => Option::orderBy('id')->get()
        ]);

      }else {
          redirect('login');
      }


    }

    public function pengajuanAdmin(){

      if (Auth::user()->role == '1') {
        return view('admin/peminjaman/pengajuan',[
          'sidebar' => 'pengajuan',
        ]);

      }elseif (Auth::user()->role == '0') {

        // return view('pages/dashboard', [
        //   'sidebar' => 'dashboard'
        // ]);

        redirect()->route('dashboard');

      }else {
        redirect('login');
      }

    }

    public function angsuranAdmin(){

      if (Auth::user()->role == '1') {

        return view('admin/peminjaman/angsuran',[
          'sidebar' => 'angsuran'
        ]);

      }elseif (Auth::user()->role == '0') {

        // return view('pages/dashboard', [
        //   'sidebar' => 'dashboard'
        // ]);

        redirect()->route('dashboard');

      }else {
        redirect('login');
      }


    }

    //ini buat admin

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      if (Auth::user()->role == '1') {

        // return view('admin/dashboard',[
        //   'sidebar' => 'dashboard'
        // ]);

        redirect()->route('admin/dashboard');

      }elseif(Auth::user()->role == '0') {
        return view('pages/pengajuan/create',[
          'sidebar'=>'pengajuan',
          'pengaturan' => Option::orderBy('id')->get()
        ]);
      }
      else {
        redirect('login');
      }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if (Auth::user()->role == '1') {
        // return view('admin/dashboard', [
        //   'sidebar' => 'dashboard'
        // ]);
        redirect()->route('admin/dashboard');
      }elseif (Auth::user()->role == '0') {

        $pengaturan = Option::orderBy('id')->get();
        $id = Auth::user()->id;

        //Upload file

        // SK
        $imagesk = $request->sk;
        $images_new_namesk = time().$imagesk->getClientOriginalName();
        $imagesk->move('public/uploads/', $images_new_namesk);

        //KTP
        $imagektp = $request->ktp;
        $images_new_namektp = time().$imagektp->getClientOriginalName();
        $imagektp->move('public/uploads/', $images_new_namektp);

        //KK
        $imagekk = $request->kk;
        $images_new_namekk = time().$imagekk->getClientOriginalName();
        $imagekk->move('public/uploads/', $images_new_namekk);

        //slip
        $imageslip = $request->slip;
        $images_new_nameslip = time().$imageslip->getClientOriginalName();
        $imageslip->move('public/uploads/', $images_new_nameslip);

        // jaminan
        $imagejaminan = $request->jaminan;
        $images_new_namejaminan = time().$imagejaminan->getClientOriginalName();
        $imagejaminan->move('public/uploads/', $images_new_namejaminan);

        $admin = $pengaturan[1]->value;
        $margin = (float)$pengaturan[0]->value;
        $random = substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'),0,10);
        $data = [
          'kode' => $random,
          'jumlah' => $request['jumlah'],
          'angsuran' => $request['angsuran'],
          'dp' => $request['dp'],
          'keperluan' => $request['keperluan'],
          'sk' => 'public/uploads/'.$images_new_namesk,
          'ktp' => 'public/uploads/'.$images_new_namektp,
          'kk' => 'public/uploads/'.$images_new_namekk,
          'slip' => 'public/uploads/'.$images_new_nameslip,
          'jaminan' => '',
          'margin' => $margin,
          'after_margin' => $request['after_margin'],
          'biaya_admin' => $admin,
          'pokok' => $request['pokok'],
          'angsuran_bulanan' => $request['angsuran_bulanan'],
          'user_id' => $id,
          'status' => 0
        ];

        Peminjaman::create($data);

        return redirect('peminjaman/pengajuan');


      }
      else {
        redirect('login');
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

    public function detail($kode)
    {
      if (Auth::user()->role == '1') {

        // return view ('admin/dashboard', [
        //   'sidebar' => 'dashboard',
        // ]);
        redirect()->route('admin/dashboard');

      }elseif (Auth::user()->role == '0') {

        $peminjaman = Peminjaman::where('kode',$kode)->first();

        return view('pages/pengajuan/detail',[
          'sidebar'=>'pengajuan',
          'peminjaman' => $peminjaman
        ]);

      }


    }

    public function cancel($id)
    {
      $peminjaman = Peminjaman::find($id);
      $peminjaman->status = 3;
      $peminjaman->update();
    }

    public function aprove($kode){



    if (Auth::user()->role == '1') {


      DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->update([
        'status' => 1
        ]);

    $peminjaman = DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->get();

    // return $peminjaman;

      $temp_pokok = $peminjaman[0]->pokok;
      $pokok = number_format($temp_pokok);

      for ($i=1; $i <= $peminjaman[0]->angsuran ; $i++) {
        $data=[
          'bulan' => $i,
          'pokok' => $pokok,
          'angsuran' => number_format($peminjaman[0]->angsuran_bulanan),
          'saldo' => number_format($temp_pokok - $peminjaman[0]->angsuran_bulanan),
          'status' => 0,
          'peminjaman_id' => $peminjaman[0]->id
        ];
        $temp_pokok-=$peminjaman[0]->angsuran_bulanan;
        Angsuran::create($data);
      }


      $dataPeminjaman = DB::table('peminjamen')
        ->join('users', 'peminjamen.user_id', '=', 'users.id')
        ->where('kode', $kode)
        ->select('*')
        ->first();

        $data = [
          'email' => $dataPeminjaman->email,
          'kode' => $dataPeminjaman->kode,
          'keperluan' => $dataPeminjaman->keperluan,
          'nama' => $dataPeminjaman->name
        ];

        Mail::send('admin.email.mailPeminjaman', $data, function($message) use($data){
          $message->to('herlianto.adhi@gmail.com');
          $message->from('herlianto.adhi@gmail.com');
          $message->subject('Peminjaman '.$data['keperluan']);
        });

        return redirect('admin/peminjaman/pengajuanPeminjaman');
    }elseif (Auth::user()->role == '0') {

    //   return view('pages/dashboard', [
    //     'sidebar' => 'dashboard'
    //   ]);
    redirect()->route('dashboard');

    }


    }

    public function disaprove($kode){

      if (Auth::user()->role == '1') {
        $peminjaman = Peminjaman::where('kode',$kode)->first();
        $peminjaman->status = 2;
        $peminjaman->update();
        return redirect('admin/peminjaman/pengajuanPeminjaman');
      }elseif (Auth::user()->role == '0') {
        // return view('pages/dashboard', [
        //   'sidebar' => 'dashboard'
        // ]);
        redirect()->route('dashboard');
      }else {
          redirect('login');
      }


    }

    public function apipeminjaman($id)
    {
        $id =Auth::user()->id;
        $peminjaman = Peminjaman::where('user_id', $id)->orderBy('id', 'dsc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="pengajuan/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs">Detail</a>' ;
        })
        ->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->addColumn('status',function($peminjaman) {
            if($peminjaman->status == 0){
              return 'Waiting';
            }elseif($peminjaman->status == 1){
              return '<span class="font-green">Accepted</span>' ;
            }elseif($peminjaman->status == 2){
              return '<span class="font-red">Declined</span>  ' ;
            }else{
              return '<span class="font-red">Canceled</span>  ' ;
            }
        })->escapeColumns([])->make(true);


    }

    public function apipengajuanadmin(){
      // $peminjaman = Peminjaman::join('users', 'users.id = peminjamen.id')->where('peminjamen.status', 0)->orderby('peminjamen.created_at')->get();
      $peminjaman = DB::table('peminjamen')
      ->join('users', 'users.id', '=', 'peminjamen.user_id')
      ->where('peminjamen.status', '=', 0)
      ->orderBy('peminjamen.created_at')
      ->select('*')
      ->get();

      return DataTables::of($peminjaman)
      ->addColumn('detail',function($peminjaman) {
        return '<a href="detailPengajuan/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
      })->escapeColumns([])->make(true);
    }

    public function detailPengajuanAdmin($kode){

      if (Auth::user()->role == '1') {

        $pengajuan = DB::table('peminjamen')
        ->where('kode', '=', $kode)
        ->get();

        return view ('admin/peminjaman/detailPengajuan', [
          'sidebar' => 'pengajuan',
          'pengajuan' => $pengajuan
        ]);

      }elseif (Auth::user()->role == '0') {
        // return view('pages/dashboard', [
        //   'sidebar' => 'dashboard'
        // ]);
        redirect()->route('dashboard');
      }else {
        redirect('login');
    }



    }

    public function apiangsuranadmin()
    {
      // $id = 3;
    //   $peminjaman = Peminjaman::where('status',1)->orderBy('id','desc');
    $peminjaman = DB::table('peminjamen')
    ->join('users', 'peminjamen.user_id', 'users.id')
    ->where('peminjamen.status', '=', 1)
    ->orderBy('peminjamen.id','desc')
    ->get();

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="'.url('admin/peminjaman/detail/angsuran').'/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->escapeColumns([])->make(true);
    }

}
