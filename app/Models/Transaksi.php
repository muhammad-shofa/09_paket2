<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table = "tb_transaksi";
    protected $primaryKey = 'id_parkir';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_kendaraan',
        'id_tarif',
        'id_area',
        'waktu_masuk',
        'waktu_keluar',
        'durasi_jam',
        'biaya_total',
        'status',
    ];

    public function user() { return $this->belongsTo(User::class, 'id_user', 'id_user'); }
    public function kendaraan() { return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan'); }
    public function tarif() { return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif'); }
    public function area() { return $this->belongsTo(AreaParkir::class, 'id_area', 'id_area'); }
}
