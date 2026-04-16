Panduan Setup Development Environment (Manual)

1. Prasyarat (Prerequisites)
Pastikan sudah menginstall software berikut di laptop/pc:
- Node.js  
- PostgreSQL & pgAdmin 4
- Git

2. Langkah-Langkah Instalasi
- Clone Repository (git clone https://github.com/Raminversee/kelompok_3_eCommerce_toko_PPL.git)
- masuk ke akun project (cd kelompok_3_eCommerce_toko_PPL)
- Instalasi Dependencies 
- Buka terminal di folder project, lalu jalankan: npm install

3. Konfigurasi Database (PostgreSQL)
- Buka pgAdmin 4.
- Buat Database baru dengan nama: toko_buku_db.
- DB_USER=postgres
- DB_PASSWORD=password_kamu
- DB_NAME=toko_buku_db

4. Menjalankan Aplikasi
- Jalankan perintah berikut untuk menyalakan software development: npm run dev