<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $fillable = ['id_penjualan', 'id_produk', 'harga_jual', 'jumlah', 'diskon', 'sub_total'];
}
