<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Iuran;
use App\Transaksi;
use App\Option;
use Auth;
use Mail;

class IuranController extends Controller
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
      $id = Auth::user()->id;
      $iuran_bulanan = DB::table('iurans')->where('user_id',$id)->where('jenis','bulanan')->orderBy('id')->get();
      $bulan = DB::table('iurans')->where('user_id',$id)->where('jenis','bulanan')->where('status','<>',1)->where('status','<>',2)->orderBy('id')->get();
      $pokok = DB::table('iurans')->where('user_id',$id)->where('jenis', 'pokok')->first();

    //   return view('pages/iuran',[
    //     'sidebar'=>'iuran',
    //     'iuran' => $iuran_bulanan,
    //     'bulan' => $bulan,
    //     'pokok' => $pokok
    //   ]);

      if (Auth::user()->role == '1') {
        return view ('admin/dashboard', [
          'sidebar' => 'dashboard',
        ]);
      }elseif (Auth::user()->role == '0') {
        return view('pages/iuran',[
            'sidebar'=>'iuran',
            'iuran' => $iuran_bulanan,
            'bulan' => $bulan,
            'pokok' => $pokok
        ]);
      }else {
        return redirect('login');
      }

    }

    public function pokokIndex(){
        // dd(1);
      $id = Auth::user()->id;
      $iuran_pokok = DB::table('iurans')->where('user_id',$id)->where('jenis','pokok')->orderBy('id')->get();
      $bulan = DB::table('iurans')->where('user_id',$id)->where('jenis','bulanan')->where('status','<>',1)->where('status','<>',2)->orderBy('id')->get();
      $pokok = DB::table('iurans')->where('user_id',$id)->where('jenis', 'pokok')->first();
      $option = Option::orderBy('id')->get();

    //   return view('pages/iuranpokok',[
    //     'sidebar'=>'pokok',
    //     'iuranpokok' => $iuran_pokok,
    //     'bulan' => $bulan,
    //     'pokok' => $pokok,
    //     'pengaturan' => $option
    //   ]);

      if (Auth::user()->role == '1') {
        return view ('admin/dashboard', [
          'sidebar' => 'dashboard',
        ]);
      }elseif (Auth::user()->role == '0') {
        return view('pages/iuranpokok',[
            'sidebar'=>'pokok',
            'iuranpokok' => $iuran_pokok,
            'bulan' => $bulan,
            'pokok' => $pokok,
            'pengaturan' => $option
        ]);
      }else {
        return redirect('login');
      }
    }

    //Iuran bulanan
    public function iuranBulananAdmin(){
        //daftar nama tiap user
        $daftarNama = DB::table('users')
                    ->orderBy('users.id')
                    ->get();

        //daftar seluruh tagihan
        $tagihanPerBulan = DB::table('iurans')
                    ->where('iurans.jenis', 'bulanan')
                    ->orderBy('iurans.user_id', 'asc')
                    ->orderBy('iurans.id', 'asc')
                    ->orderBy('iurans.bulan', 'asc')
                    ->get();

        // return view('admin/iuran/iuranBulanan',[
        //     'sidebar'=>'iuranBulanan',
        //     'nama'=> $daftarNama,
        //     'bulanan'=>$tagihanPerBulan
        // ]);

        if (Auth::user()->role == '1') {
            return view ('admin/iuran/iuranBulanan',[
                'sidebar'=>'iuranBulanan',
                'nama'=> $daftarNama,
                'bulanan'=>$tagihanPerBulan
            ]);
          }elseif (Auth::user()->role == '0') {
            return view('pages/dashboard',[
                'sidebar'=>'dashboard'
            ]);
          }else {
            return redirect('login');
          }
    }

    //Iuran pokok
    public function iuranPokokAdmin(){
        //table yang belum bayar
        $belumBayar = DB::table('iurans')
                    ->join('users', 'iurans.user_id', '=', 'users.id')
                    ->where('iurans.jenis', 'pokok')
                    ->where('iurans.status','<>',1)
                    ->orderBy('iurans.user_id', 'asc')
                    ->get();

        //table yang sudah bayar
        $sudahBayar = DB::table('iurans')
                    ->join('users', 'iurans.user_id', '=', 'users.id')
                    ->where('iurans.jenis', 'pokok')
                    ->where('iurans.status', 1)
                    ->orderBy('iurans.user_id', 'asc')
                    ->get();

        // return view('admin/iuran/iuranPokok', [
        //     'sidebar'=>'iuranPokok',
        //     'belumBayar'=> $belumBayar,
        //     'sudahBayar'=> $sudahBayar
        // ]);

        if (Auth::user()->role == '1') {
            return view ('admin/iuran/iuranPokok', [
                'sidebar'=>'iuranPokok',
                'belumBayar'=> $belumBayar,
                'sudahBayar'=> $sudahBayar
            ]);
          }elseif (Auth::user()->role == '0') {
            return view('pages/dashboard',[
                'sidebar'=>'dashboard'
            ]);
          }else {
            return redirect('login');
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
        $id = Auth::user()->id;
        $bulan = $request['bulan'];

        // Uploads Foto
        $images = $request->bukti;
        // pemberian nama dengan bantuan time
        $images_new_name = time().$images->getClientOriginalName();
        $images->move('public/uploads/', $images_new_name);

        $data = [
          'status' => 2,
          'keterangan' => $request->keterangan,
          'jumlah' => $request->nominal,
          'foto' => 'public/uploads/'.$images_new_name
        ];
        DB::table('iurans')->where('user_id', $id)->where('bulan',$bulan)->update($data);

        $data_transaksi = [
          'kode' => 'iuran_bulan_'.$id.'_'.$bulan,
          'jumlah' => $request->nominal,
          'bulan' => $bulan,
          'tahun' => Date('Y'),
          'keterangan' => $request->keterangan,
          'jenis' => 'iuran',
          'foto' => 'public/uploads/'.$images_new_name,
          'aproval' => 0,
          'user_id' => $id
        ];
        Transaksi::create($data_transaksi);

        $dataiuranbulanan = DB::table('iurans')
        ->join('users', 'iurans.user_id', '=', 'users.id')
        ->where(['user_id' => $id, 'bulan' => $bulan])
        ->select('*')
        ->first();                

        $data = [
          'email' => $dataiuranbulanan->email,
          'nama' => $dataiuranbulanan->name,
          'bulan' => $dataiuranbulanan->bulan,
          'jenis' => $dataiuranbulanan->jenis
        ];

        Mail::send('admin.email.mailPembayaranIuran', $data, function($message) use($data){
          $message->to('herlianto.adhi@gmail.com');
          $message->from('herlianto.adhi@gmail.com');
          $message->subject('Pembayaran Iuran bulan ke-'.$data['bulan']);
        });

        return redirect('iuran');
    }

    public function storepokok(Request $request){
      $id = Auth::user()->id;
      $bulan = 0;
      $data = [
        'status' => 2,
        'keterangan' => $request->keterangan,
        'jumlah' => $request->nominal,
        'foto' => $request->bukti->getClientOriginalName()
      ];
      DB::table('iurans')->where('user_id', $id)->where('bulan',0)->update($data);
      $data_transaksi = [
        'kode' => 'iuran_pokok_'.$id,
        'jumlah' => $request->nominal,
        'bulan' => 0,
        'tahun' => Date('Y'),
        'keterangan' => $request->keterangan,
        'jenis' => 'iuran',
        'foto' => $request->bukti->getClientOriginalName(),
        'aproval' => 0,
        'user_id' => $id
      ];
      Transaksi::create($data_transaksi);
      
        $dataiuranpokok = DB::table('iurans')
        ->join('users', 'iurans.user_id', '=', 'users.id')
        ->where(['user_id' => $id, 'bulan' => $bulan])
        ->select('*')
        ->first();
        
        $data = [
          'email' => $dataiuranpokok->email,
          'nama' => $dataiuranpokok->name,
          'bulan' => $dataiuranpokok->bulan,
          'jenis' => $dataiuranpokok->jenis
        ];

        Mail::send('admin.email.mailPembayaranIuran', $data, function($message) use($data){
          $message->to('herlianto.adhi@gmail.com');
          $message->from('herlianto.adhi@gmail.com');
          $message->subject('Pembayaran Iuran bulan ke Pokok');
        });

      return redirect('iuran/pokok');
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

    public function aprove($kode){
      // return Transaksi::where('kode',$kode)->get();

      DB::table('transaksis')->where('kode', $kode)->update([
          'aproval' => 1
      ]);

      DB::table('iurans')->where('kode', $kode)->update([
          'status' => 1
      ]);

      $dataTransaksi = DB::table('transaksis')
        ->join('users', 'transaksis.user_id', '=', 'users.id')
        ->where('kode', $kode)
        ->select('*')
        ->first();        

        $data = [
          'email' => $dataTransaksi->email,
          'keterangan' => $dataTransaksi->keterangan,
          'status' => $dataTransaksi->aproval,
          'jenis' => $dataTransaksi->jenis,
          'nama' => $dataTransaksi->name,
          'bulan' => $dataTransaksi->bulan
        ];

        Mail::send('admin.email.mailTransaksi', $data, function($message) use($data){
          $message->to($data['email']);
          $message->from('herlianto.adhi@gmail.com');
          $message->subject('Pembayaran '.$data['jenis']);
        });

      return redirect()->back();
    }

    public function disaprove($kode){
      DB::table('transaksis')->where('kode', $kode)->update([
          'aproval' => 2
      ]);

      DB::table('iurans')->where('kode', $kode)->update([
          'status' => 3
      ]);
      return redirect()->back();
    }
}
