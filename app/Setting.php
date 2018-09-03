<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    protected $fillable = ['nama_perusahaan', 'alamat', 'telepon', 'logo', 'kartu_member', 'diskon_member', 'tipe_nota'];
}
