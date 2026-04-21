# Kelompok 3 - E-Commerce Perlengkapan Rumah Tangga & Sanitary

Proyek aplikasi berbasis web, e-commerce untuk penjualan perlengkapan rumah tangga dan alat-alat sanitary berbasis Laravel.

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL / PostgreSQL

## Cara Menjalankan di Lokal

**1. Clone dan masuk ke folder proyek**
```bash
git clone https://github.com/Raminversee/kelompok_3_eCommerce_toko_PPL.git
cd kelompok_3_eCommerce_toko_PPL
git checkout develop
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Konfigurasi environment**
```bash
cp .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Buat database di MySQL, lalu sesuaikan `.env`**
```env
DB_DATABASE=db_sanitary_shop
DB_USERNAME=root
DB_PASSWORD=your_password
```

**6. Jalankan migration**
```bash
php artisan migrate --seed
```

**7. Build asset & jalankan**
```bash
npm run dev
php artisan serve
```

Buka **http://localhost:5173**
