<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
  protected $fillable = [
      'kode',
      'jenis',
      'bulan',
      'tahun',
      'status',
      'user_id'
  ];
}
