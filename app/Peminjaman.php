<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
  protected $fillable = [
      'kode',
      'jumlah',
      'angsuran',
      'dp',
      'keperluan',
      'sk',
      'ktp',
      'kk',
      'slip',
      'jaminan',
      'margin',
      'after_margin',
      'biaya_admin',
      'pokok',
      'angsuran_bulanan',
      'user_id',
      'status'
  ];
}
