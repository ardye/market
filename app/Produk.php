<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = ['kode_produk','id_kategori', 'nama_produk', 'merk', 'harga__beli', 'diskon', 'harga_jual', 'stok'];

    public function kategori() {
    	return $this->belongsTo('App\Kategori', 'id_kategori');
    }

    public function pembelian() {
    	return $this->belongsToMany('App\Pembelian', 'pembelian_detail', 'id_produk', 'id_pembelian');
    }

    public function penjualan() {
    	return $this->belongsToMany('App\Penjualan', 'penjualan_detail', 'id_produk', 'id_penjualan');
    }
}

