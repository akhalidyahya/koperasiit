<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode',50);
            $table->string('jumlah',50);
            $table->string('angsuran',50);
            $table->string('dp',50);
            $table->string('keperluan',50);
            $table->text('sk')->nullable();
            $table->text('ktp')->nullable();
            $table->text('kk')->nullable();
            $table->text('slip')->nullable();
            $table->text('jaminan')->nullable();
            $table->string('margin',10)->nullable();
            $table->string('after_margin',50)->nullable();
            $table->string('biaya_admin',50)->nullable();
            $table->string('pokok',50)->nullable();
            $table->string('angsuran_bulanan',50)->nullable();
            $table->unsignedInteger('user_id');
            $table->string('status',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjamen');
    }
}
