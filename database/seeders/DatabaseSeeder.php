<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administrator;
use App\Models\DiskonProduk;
use App\Models\KategoriProduk;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Pengguna::create([
            'username' => 'administrator',
            'password' => bcrypt('12345'),
            'level_akses' => 'administrator'
        ]);

        Administrator::create([
            'nama_administrator' => 'Isna',
            'no_telepon' => '62467899776',
            'alamat' => 'tasikmlaya',
            'pengguna_id' => '1'
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'makanan'
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'minuman'
        ]);

        DiskonProduk::create([
            'nama_diskon' => 'Promo Ramdhan',
            'jenis_diskon' => 'persentase',
            'nilai' => '50',
            'deskripsi' => 'Promo khusus di bulan ramadahan',
            'berlaku_mulai' => '2024-02-15',
            'berlaku_selesai' => '2024-02-20',
        ]);

        DiskonProduk::create([
            'nama_diskon' => 'Pesta Akhir Tahun',
            'jenis_diskon' => 'nominal',
            'nilai' => '50000',
            'deskripsi' => 'Belanja di akhir tahun makin hemat',
            'berlaku_mulai' => '2024-12-20',
            'berlaku_selesai' => '2025-01-20',
        ]);

        Produk::create([
            'kode_produk' => 'PRD001',
            'nama_produk' => 'Kue Kering',
            'gambar_produk' => '-',
            'harga' => '80000',
            'stok' => '10', 
            'tanggal_kadaluarsa' => '2024-02-29',
            'kategori_produk_id' => '1',
            'diskon_produk_id' => '1', 
        ]);

        Produk::create([
            'kode_produk' => 'PRD002',
            'nama_produk' => 'Cup cake',
            'gambar_produk' => '-',
            'harga' => '80000',
            'stok' => '10', 
            'tanggal_kadaluarsa' => '2024-02-29',
            'kategori_produk_id' => '2',
            'diskon_produk_id' => '2', 
        ]);
    }
}
