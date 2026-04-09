<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => 1,
        ]);

        $petugas = User::create([
            'nama_lengkap' => 'Petugas Parkir',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_aktif' => 1,
        ]);

        $owner = User::create([
            'nama_lengkap' => 'Owner System',
            'username' => 'owner',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => 1,
        ]);

        // 2. Seed Area Parkir
        $areaA = AreaParkir::create([
            'nama_area' => 'Area Parkir VIP',
            'kapasitas' => 50,
            'terisi' => 0,
        ]);

        $areaB = AreaParkir::create([
            'nama_area' => 'Area Parkir Reguler',
            'kapasitas' => 200,
            'terisi' => 0,
        ]);

        // 3. Seed Tarif
        $tarifMobil = Tarif::create([
            'jenis_kendaraan' => 'Mobil',
            'tarif_per_jam' => 5000,
        ]);

        $tarifMotor = Tarif::create([
            'jenis_kendaraan' => 'Motor',
            'tarif_per_jam' => 2000,
        ]);

        // 4. Seed Kendaraan
        $kendaraan = Kendaraan::create([
            'id_user' => $admin->id_user,
            'plat_nomor' => 'B 1234 XYZ',
            'jenis_kendaraan' => 'Mobil',
            'warna' => 'Hitam',
            'pemilik' => 'John Doe',
        ]);

        // 5. Seed Transaksi (Contoh kendaraan masuk)
        Transaksi::create([
            'id_user' => $petugas->id_user, // Petugas yang mencatat
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_tarif' => $tarifMobil->id_tarif,
            'id_area' => $areaA->id_area,
            'waktu_masuk' => Carbon::now(),
            'waktu_keluar' => null,
            'durasi_jam' => null,
            'biaya_total' => null,
            'status' => 'masuk',
        ]);
        
        // Update kapasitas area terisi (opsional, karena ini seeder simulasi)
        $areaA->update(['terisi' => 1]);
    }
}
