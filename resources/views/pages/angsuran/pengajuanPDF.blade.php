<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
        
</head>
<body>
    
    <div class="portlet light portlet-fit portlet-datatable bordered">
      <div class="portlet-body">
        <table>
          <tr>
            <td>Keperluan</td> <td> : </td> <td>{{$peminjaman->keperluan}}</td>
          </tr>
          <tr>
            <td>Harga OTR</td> <td> : </td> <td>Rp.{{number_format($peminjaman->jumlah)}}</td>
          </tr>
          <tr>
            <td>Margin {{$peminjaman->margin * 100}}%</td> <td> : </td> <td>Rp.{{number_format($peminjaman->after_margin)}}</td>
          </tr>
          <tr>
            <td>Biaya Admin</td> <td> : </td> <td>Rp.{{number_format($peminjaman->biaya_admin)}}</td>
          </tr>
          <tr>
            <td></td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->jumlah + $peminjaman->after_margin + $peminjaman->biaya_admin)}}</b></td>
          </tr>
          <tr>
            <td>Jumlah DP</td>
            <td> : </td>
            <td>
              Rp.{{number_format($peminjaman->dp)}}
              @if($peminjaman->status_dp ==0)
                <span class="font-red">(Belum dibayarkan. Segera bayar DP)</span>
              @elseif($peminjaman->status_dp==2)
                <span class="">(Menunggu konfirmasi Pembayaran)</span>
              @elseif($peminjaman->status_dp==1)
                <span class="font-green">(DP sudah dibayar)</span>
              @else
                <span class="font-red">(Pembayaran DP ditolak, silahkan lakukan transaksi lagi)</span>
              @endif
            </td>
          </tr>
          <tr>
            <td><b>Total Pokok</b> </td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->pokok)}}</b></td>
          </tr>
          <tr>
            <td>Periode Angsuran</td> <td> : </td> <td>{{number_format($peminjaman->angsuran)}}</td>
          </tr>
          <tr>
            <td><b>Angsuran per Bulan</b> </td> <td> : </td> <td><b>Rp.{{number_format($peminjaman->angsuran_bulanan)}}</b></td>
          </tr>
        </table>
      </div>
      <br>

        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-blue"></i>
                <span class="caption-subject font-blue sbold uppercase">Perhitungan Angsuran </span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="myTable">
                <thead>
                    <tr>
                      <th>Bulan</th>
                      <th>Pokok</th>
                      <th>Angsuran</th>
                      <th>Saldo</th>
                      <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($angsuran as $data)
                  <tr>
                    <td>{{$data->bulan}}</td>
                    <td>{{$data->pokok}}</td>
                    <td>{{$data->angsuran}}</td>
                    <td>{{$data->saldo}}</td>
                    <td>
                      @if($data->status == 0) -
                      @elseif($data->status == 1) <i class="fa fa-check font-green-jungle" data-toggle="tooltip" title="Paid"></i> Sudah bayar
                      @elseif($data->status == 2) <i class="fa fa-refresh font-dark" data-toggle="tooltip" title="Waiting for confirmation"></i> Menunggu konfirmasi
                      @elseif($data->status == 3) <i class="fa fa-times font-red" data-toggle="tooltip" title="Not Paid"></i> Belum bayar / bukti ditolak
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>