<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $fillable = ['id_supplier', 'total_item', 'total_harga', 'diskon', 'bayar'];

    public function produk() {
    	return $this->belongsToMany('App\Produk', 'pembelian_detail', 'id_pembelian', 'id_produk')->withPivot('id','harga_beli', 'jumlah', 'sub_total');
    }

    public function supplier() {
    	return $this->belongsTo('App\Supplier', 'id_supplier');
    }
}
