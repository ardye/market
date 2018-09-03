<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePembelianDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create Table Pembelian Detail
         */
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pembelian')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->bigInteger('harga_beli')->unsigned();
            $table->integer('jumlah')->unsigned();
            $table->bigInteger('sub_total')->unsigned();
            $table->timestamps();

            /** Create Foreign Key */
            $table->foreign('id_pembelian')
                  ->references('id')
                  ->on('pembelian')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_produk')
                  ->references('id')
                  ->on('produk')
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
        Schema::dropIfExists('pembelian_detail');
    }
}
