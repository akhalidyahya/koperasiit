<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->string('ttl',50);
          $table->string('jk',5);
          $table->string('identitas',50);
          $table->string('alamat',250);
          $table->string('hp',20);
          $table->string('pekerjaan',50);
          $table->string('pendapatan',15);
          $table->string('nama_lembaga',50);
          $table->string('alamat_lembaga',250);
          $table->string('pegawaian',25);
          $table->string('no_lembaga',25);
          $table->string('role',1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
