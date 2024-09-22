## Instalasi API Laravel

### 1. Clone Repository
```bash
git clone https://github.com/Rexxpy/apiTest.git
```

### 2. Masuk ke direktori proyek
Navigasikan ke direktori proyek yang baru saja di-clone:
```bash
cd repository-name
```

### 3. Install composer
Pastikan Composer sudah terinstal di sistem !
Jalankan perintah berikut untuk menginstal semua dependensi Laravel:
```bash
composer install
```

### 4. Konfigurasi env
Salin file .env.example menjadi .env:
```bash
cp .env.example .env
```

setelah itu masuk kedalam file .env dan edit code DB seperti dibawah ini:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_produk
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate APP KEY
Generate app key dengan perintah dibawah:
```bash
php artisan key:generate
```

### 6. Migrasi Database
```bash
php artisan migrate
```

### 7. Start program
Memulai program dengan perintah dibawah:
```bash
php artisan serve
```





