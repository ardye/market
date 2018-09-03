<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenjualanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create Table Penjualan Detail
         */
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_penjualan')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->bigInteger('harga_jual')->unsigned();
            $table->integer('jumlah')->unsigned();
            $table->integer('diskon')->unsigned();
            $table->bigInteger('sub_total')->unsigned();
            $table->timestamps();

            /** Create Foreign Key */
            $table->foreign('id_produk')
                  ->references('id')
                  ->on('produk')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_penjualan')
                  ->references('id')
                  ->on('penjualan')
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
        Schema::dropIfExists('penjualan_detail');
    }
}
