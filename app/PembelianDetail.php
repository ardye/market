<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = 'pembelian_detail';
    protected $fillable = ['id_pembelian', 'id_produk', 'harga_beli', 'jumlah', 'sub_total'];
}
