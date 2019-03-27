<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $fillable = [
      'bulan',
      'pokok',
      'angsuran',
      'saldo',
      'status',
      'peminjaman_id'
    ];
}
