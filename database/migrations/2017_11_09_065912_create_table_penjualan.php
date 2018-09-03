<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create Table Penjualan
         */
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_member')->unsigned();
            $table->integer('total_item')->unsigned();
            $table->bigInteger('total_harga')->unsigned();
            $table->integer('diskon')->unsigned();
            $table->bigInteger('bayar')->unsigned();
            $table->bigInteger('diterima')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->timestamps();

            /** Create Foreign Key */
            $table->foreign('id_member')
                  ->references('id')
                  ->on('member')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('penjualan');
    }
}
