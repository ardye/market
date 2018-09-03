<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create Tabel Produk
         */
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('kode_produk')->unsigned();
            $table->integer('id_kategori')->unsigned();
            $table->string('nama_produk', 100);
            $table->string('merk', 50);
            $table->bigInteger('harga_beli')->unsigned();
            $table->integer('diskon')->unsigned();
            $table->bigInteger('harga_jual')->unsigned();
            $table->integer('stok')->unsigned();
            $table->timestamps();

            /** Make Foreing Key To Table Kategori */
            $table->foreign('id_kategori')
                  ->references('id')
                  ->on('kategori')
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
        Schema::dropIfExists('produk');
    }
}
