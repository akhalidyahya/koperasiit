<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Peminjaman;
use App\Angsuran;
use App\Transaksi;
use Auth;
use PDF;
use Mail;

class AngsuranController extends Controller
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
      // DB::table('peminjamen')->where('user_id', Auth::user()->id)->where('');
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

    public function detail($kode)
    {
      $peminjaman = Peminjaman::where('kode',$kode)->first();
      $id = $peminjaman->id;
      $angsuran = DB::table('angsurans')->where('peminjaman_id',$id)->orderBy('id','asc')->get();
      $bulan_form = DB::table('angsurans')->where('peminjaman_id',$id)->where('status','<>',1)->where('status','<>',2)->orderBy('id','asc')->get();

      if(Auth::user()->role == '0'){
        return view('pages/angsuran/detail',[
            'sidebar'=>'angsuran',
            'peminjaman' => $peminjaman,
            'angsuran' => $angsuran,
            'bulan' => $bulan_form
          ]);
      }elseif (Auth::user()->role == '1') {
        return view('admin/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }else {
          return redirect('login');
      }

    }

    public function detailangsuran($kode){
    //   $pengajuan = Peminjaman::find($id);
    $pengajuan = DB::table('peminjamen')
    ->where('kode', '=', $kode)
    ->get();

      if (Auth::user()->role == '1') {
        return view ('admin/peminjaman/detailangsuran', [
          'sidebar' => 'angsuran',
          'pengajuan' => $pengajuan
        ]);
      }elseif (Auth::user()->role == '0') {
        return view('pages/dashboard', [
          'sidebar' => 'dashboard'
        ]);
      }else {
        return redirect('login');
      }
    // return $pengajuan[0]->status;
    }

    public function apiangsuran($id)
    {
      $id = Auth::user()->id;
      $peminjaman = Peminjaman::where('user_id',$id)->where('status',1)->orderBy('id','desc');

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="angsuran/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->escapeColumns([])->make(true);
    }

    public function apiangsuranall()
    {
      $id = Auth::user()->id;
      $peminjaman = Peminjaman::where('status',1)->orderBy('id','desc');
      $data = DB::table('peminjamen')
      ->join('users','users.id', '=', 'peminjamen.user_id')
      ->where('peminjamen.status',1)
      ->orderBy('transaksis.id','desc')->get();

      return DataTables::of($peminjaman)
        ->addColumn('detail',function($peminjaman) {
          return '<a href="angsuran/detail/'.$peminjaman->kode.'" class="btn btn-default btn-xs"> Detail </a>';
        })->addColumn('tanggal',function($peminjaman) {
          return $peminjaman->created_at->toDateString();
        })->escapeColumns([])->make(true);
    }

    public function bayardp(Request $request){

      // save image
      $images = $request->bukti;
      // pemberian nama dengan bantuan time
      $images_new_name = time().$images->getClientOriginalName();
      $images->move('public/uploads/', $images_new_name);

      $peminjaman = Peminjaman::where('id',$request->id)->first();
      $data = [
        'kode' => $peminjaman->kode,
        'jumlah' => $request['nominal'],
        'bulan' => Date('n'),
        'tahun' => Date('Y'),
        'keterangan' => $request['keterangan'],
        'foto' => 'public/uploads/' . $images_new_name,
        'jenis' => 'dp',
        'aproval' => 0,
        'user_id' => $peminjaman->user_id,
      ];
      Transaksi::create($data);

      $peminjaman->status_dp = 2;
      $peminjaman->update();

      $byrdp = DB::table('peminjamen')
      ->join('users', 'peminjamen.user_id', '=', 'users.id')
      ->where('peminjamen.id', $request->id)
      ->select('*')
      ->first();        
          

      $data = [
        'email' => $byrdp->email,
        'nama' => $byrdp->name,        
      ];

      Mail::send('admin.email.mailPembayaranDP', $data, function($message) use($data){
        $message->to('herlianto.adhi@gmail.com');
        $message->from('herlianto.adhi@gmail.com');
        $message->subject('Pembayaran DP');
      });

      return redirect("peminjaman/angsuran/detail/$peminjaman->kode");
    }

    public function bayarangsuran(Request $request){
      $peminjaman = Peminjaman::where('id',$request->id)->first();
      
      
      $images = $request->bukti;      
      $images_new_name = time().$images->getClientOriginalName();
      $images->move('public/uploads/', $images_new_name);

      $data = [
        'kode' => $peminjaman->kode,
        'jumlah' => $request['nominal'],
        'bulan' => $request['bulan'],
        'tahun' => Date('Y'),
        'keterangan' => $request['keterangan'],
        'foto' => 'public/uploads/' .$images_new_name,
        'jenis' => 'angsuran',
        'aproval' => 0,
        'user_id' => $peminjaman->user_id,
      ];

      Transaksi::create($data);

      $angsuran = Angsuran::where('peminjaman_id',$request->id)->where('bulan',$request['bulan'])->first();
      $angsuran->status = 2;
      $angsuran->update();

      // Mail

      $byrangsuran = DB::table('peminjamen')
      ->join('users', 'peminjamen.user_id', '=', 'users.id')
      ->join('angsurans', 'peminjamen.id', '=', 'angsurans.peminjaman_id')
      ->where('peminjamen.id', $request->id)
      ->select('*')
      ->first();        
          
      $data = [
        'email' => $byrangsuran->email,
        'nama' => $byrangsuran->name,
        'bulan' => $byrangsuran->bulan
      ];

      Mail::send('admin.email.mailPembayaranAngsuran', $data, function($message) use($data){
        $message->to('herlianto.adhi@gmail.com');
        $message->from('herlianto.adhi@gmail.com');
        $message->subject('Pembayaran Angsuran');        
      });
      
      return redirect("peminjaman/angsuran/detail/$peminjaman->kode");
    }

    public function aprovedp($id){
      $peminjaman = Peminjaman::where('id',$request->id)->first();
      $peminjaman->status_dp = 1;
      $peminjaman->update();
    }

    public function exportPDF($kode){

      $peminjaman = DB::table('peminjamen')
      ->where('kode', '=', $kode)
      ->where('user_id',Auth::user()->id)
      ->first();
      
      
      $angsuran = DB::table('angsurans')->where('peminjaman_id',$peminjaman->id)->orderBy('id','asc')->get();      
      set_time_limit(300);
      $pdf = PDF::loadview('pages/angsuran/pengajuanPDF', [
        'peminjaman' => $peminjaman,
        'angsuran' => $angsuran
      ]);
      return $pdf->stream('pages/angsuran/pengajuanPDF.pdf',array('Attachment'=>0));      
      // return $pdf->download('pages/angsuran/pengajuanPDF.pdf');
            
    }
}
