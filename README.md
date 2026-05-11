# Panduan Aplikasi:
## Plazza Bangunan Sukses

## Tools yang dibutuhkan
- Laragon
- Install PHP versi 8.3 atau lebih
- VSCode
- HeidiSQL
- Git
- Node.js & npm
- Composer

**1. Clone project dari GitHub**

- Jalankan Laragon
- Buka terminal
- Clone repository project
```bash
git clone https://github.com/Raminversee/kelompok_3_eCommerce_toko_PPL.git
```

Masuk ke folder project:
```bash
cd kelompok_3_eCommerce_toko_PPL
```

**2. Install dependency composer dan node.js**

Jalankan:

```bash
composer install
npm install
```

**3. Konfigurasi file environment**

```bash
cp .env.example .env
```

**4. Generate APP_KEY Laravel**

```bash
php artisan key:generate
```

**5. Buat database, lalu sesuaikan .env**

Buka database manager:

- Jalankan HeidiSQL
- Buat database baru, misalnya:
```text
ecommerce
```

Buka folder project menggunakan VSCode, lalu buka file `.env` dan ubah bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

**6. Jalankan migration database**
```bash
php artisan migrate
```

**7. Menjalankan Laravel server**

```bash
php artisan serve
```


**8. Menjalankan Laravel server**

Buka terminal baru lalu jalankan (terminal sebelumnya biarkan tetap berjalan):
```bash
npm run dev
```
Buka aplikasi melalui
```text
http://127.0.0.1:8000
```

**Aplikasi Siap Digunakan**
