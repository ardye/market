<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $fillable = ['id_member', 'total_item', 'total_harga', 'diskon', 'bayar', 'diterima', 'id_user'];

    public function produk() {
    	return $this->belongsToMany('App\Produk', 'penjualan_detail', 'id_penjualan', 'id_produk')->withPivot('id', 'harga_jual', 'jumlah', 'diskon', 'sub_total');
    }

    public function member() {
    	return $this->belongsTo('App\Member', 'id_member');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'id_user');
    }
}
