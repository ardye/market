<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** 
         * Create Table Setting
         */
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_perusahaan', 100);
            $table->text('alamat');
            $table->string('telepon', 15);
            $table->string('logo', 50);
            $table->string('kartu_member', 50);
            $table->integer('diskon_member')->unsigned();
            $table->integer('tipe_nota')->unsigned();
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
        Schema::dropIfExists('setting');
    }
}
