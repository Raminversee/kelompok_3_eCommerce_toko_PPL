<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        Produk::truncate();

        $produks = [
            [
                'nama'          => 'Kran Wastafel Single Lever Chrome Premium',
                'sku'           => 'KRN-001',
                'kategori'      => 'Kran & Shower',
                'deskripsi'     => "Kran wastafel modern dengan finishing chrome berkualitas tinggi yang tahan karat. Desain single lever memudahkan pengaturan temperatur dan debit air hanya dengan satu tangan. Cocok untuk wastafel kamar mandi minimalis maupun modern.\n\n✓ Material Zinc Alloy kelas A dengan Finishing Chrome Mirror\n✓ Pemasangan mudah dengan sistem mur pengunci kuningan\n✓ Desain ergonomis, nyaman digenggam",
                'spesifikasi'   => [
                    'Merek'           => 'PBS Exclusive Series',
                    'Material Utama'  => 'High-Quality Zinc Alloy',
                    'Finishing'       => 'Electroplated Polished Chrome',
                    'Ukuran Drat'     => '1/2 Inch (Standard Indonesia)',
                    'Tinggi Keseluruhan' => '15.5 cm',
                    'Berat Bersih'    => '850 gram',
                    'Suhu Kerja'      => 'Max 90° Celsius',
                ],
                'harga'         => 459000,
                'harga_coret'   => 560000,
                'diskon_persen' => 18,
                'stok'          => 45,
                'is_new'        => true,
            ],
            [
                'nama'          => 'Shower Set Stainless Steel 1.5m Full System',
                'sku'           => 'SHW-002',
                'kategori'      => 'Kran & Shower',
                'deskripsi'     => "Set shower lengkap dengan selang stainless 1.5m, kepala shower, dan holder. Tahan karat dan tekanan air tinggi.\n\n✓ Kepala shower anti-tersumbat\n✓ Selang fleksibel anti-karat\n✓ Holder dengan sistem baut kuat",
                'spesifikasi'   => [
                    'Material Selang' => 'Stainless Steel 304',
                    'Panjang Selang'  => '150 cm',
                    'Diameter Kepala' => '10 cm',
                    'Jumlah Spray'    => '3 Mode',
                    'Berat Total'     => '450 gram',
                ],
                'harga'         => 1250000,
                'harga_coret'   => 1500000,
                'diskon_persen' => 17,
                'stok'          => 17,
                'is_promo'      => true,
            ],
            [
                'nama'          => 'Bak Cuci Piring Black Matte Single Bowl',
                'sku'           => 'BAK-003',
                'kategori'      => 'Wastafel & Bak Cuci',
                'deskripsi'     => "Bak cuci piring finishing hitam matte elegan. Material stainless steel premium, anti karat dan tahan lama.",
                'spesifikasi'   => [
                    'Material'    => 'Stainless Steel 304',
                    'Finishing'   => 'Black Matte',
                    'Ukuran'      => '60 x 45 cm',
                    'Kedalaman'   => '20 cm',
                    'Ketebalan'   => '1.2 mm',
                ],
                'harga'         => 899000,
                'stok'          => 12,
                'is_new'        => true,
            ],
            [
                'nama'          => 'Smart Door Lock Digital Fingerprint V2',
                'sku'           => 'HDL-004',
                'kategori'      => 'Handle Pintu',
                'deskripsi'     => "Kunci pintu digital dengan sensor sidik jari, PIN, dan kartu RFID. Baterai tahan 1 tahun.",
                'spesifikasi'   => [
                    'Metode Akses'  => 'Fingerprint, PIN, RFID Card',
                    'Kapasitas FP'  => '100 sidik jari',
                    'Baterai'       => '4x AA (tahan ±1 tahun)',
                    'Material'      => 'Zinc Alloy',
                    'Garansi'       => '1 Tahun',
                ],
                'harga'         => 2450000,
                'harga_coret'   => 2800000,
                'diskon_persen' => 12,
                'stok'          => 8,
            ],
            [
                'nama'          => 'Dudukan Kloset Slow Close Anti-Slam',
                'sku'           => 'KLT-005',
                'kategori'      => 'Dudukan Kloset',
                'deskripsi'     => "Dudukan kloset dengan sistem slow close, tidak berbunyi saat ditutup. Universal fit untuk semua merk kloset.",
                'spesifikasi'   => [
                    'Material'    => 'PP Food Grade',
                    'Sistem'      => 'Slow Close Anti-Slam',
                    'Fit'         => 'Universal (O & D Shape)',
                    'Berat'       => '1.2 kg',
                    'Garansi'     => '1 Tahun',
                ],
                'harga'         => 185000,
                'stok'          => 35,
            ],
            [
                'nama'          => 'Gembok Baja Hardened Steel 60mm',
                'sku'           => 'GMB-006',
                'kategori'      => 'Gembok',
                'deskripsi'     => "Gembok baja hardened anti-potong. Tingkat keamanan tinggi untuk gudang dan pagar.",
                'spesifikasi'   => [
                    'Material Body'  => 'Hardened Steel',
                    'Diameter Body'  => '60 mm',
                    'Material Shackle' => 'Hardened Boron Steel',
                    'Jumlah Anak Kunci' => '3 buah',
                    'Standar'        => 'SNI',
                ],
                'harga'         => 145000,
                'harga_coret'   => 175000,
                'diskon_persen' => 17,
                'stok'          => 50,
                'is_promo'      => true,
            ],
            [
                'nama'          => 'Wastafel Gantung Keramik Oval 50cm',
                'sku'           => 'WST-007',
                'kategori'      => 'Wastafel & Bak Cuci',
                'deskripsi'     => "Wastafel gantung model oval berbahan keramik putih glossy. Termasuk bracket pemasangan.",
                'spesifikasi'   => [
                    'Material'    => 'Keramik Vitreous China',
                    'Ukuran'      => '50 x 38 cm',
                    'Warna'       => 'Putih Glossy',
                    'Termasuk'    => 'Bracket + Baut',
                    'Garansi'     => '1 Tahun',
                ],
                'harga'         => 320000,
                'stok'          => 20,
                'is_new'        => true,
            ],
            [
                'nama'          => 'Handle Pintu Minimalis Gold Series',
                'sku'           => 'HDL-008',
                'kategori'      => 'Handle Pintu',
                'deskripsi'     => "Handle pintu finishing gold minimalis. Cocok untuk rumah modern dan scandinavian.",
                'spesifikasi'   => [
                    'Material'    => 'Zinc Alloy',
                    'Finishing'   => 'PVD Gold',
                    'Panjang'     => '20 cm',
                    'Cocok untuk' => 'Pintu 35-45mm',
                    'Garansi'     => '6 Bulan',
                ],
                'harga'         => 95000,
                'stok'          => 60,
            ],
        ];

        foreach ($produks as $p) {
            Produk::create(array_merge($p, [
                'slug'      => Str::slug($p['nama']),
                'is_active' => true,
                'is_new'    => $p['is_new']    ?? false,
                'is_promo'  => $p['is_promo']  ?? false,
                'harga_coret'    => $p['harga_coret']    ?? null,
                'diskon_persen'  => $p['diskon_persen']  ?? null,
            ]));
        }
    }
}