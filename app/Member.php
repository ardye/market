<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "member";
    protected $fillable = ['kode_member', 'nama', 'alamat', 'telepon'];

    public function penjualan() {
    	return $this->hasMany('App\Penjualan', 'id_member');
    }
}
