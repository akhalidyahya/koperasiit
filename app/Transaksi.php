<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  protected $fillable = [
      'kode',
      'jumlah',
      'bulan',
      'tahun',
      'keterangan',
      'jenis',
      'foto',
      'aproval',
      'user_id'
  ];
}
