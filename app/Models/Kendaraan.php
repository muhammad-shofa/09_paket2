<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    //
    protected $table = "tb_kendaraan";
    protected $primaryKey = 'id_kendaraan';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
    ];
}
