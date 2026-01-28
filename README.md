# Fastprint Produk Management (CodeIgniter 4)

Aplikasi ini dibuat sebagai **technical test Fastprint – Tes Programmer**, menggunakan **CodeIgniter 4**. Sistem berfungsi untuk:

* Mengambil data produk dari **API Fastprint**
* Menyimpan data ke database MySQL
* Menampilkan produk dengan status **"bisa dijual"**
* Mengelola data produk (CRUD)

---

## Teknologi yang Digunakan

* PHP 8.x
* CodeIgniter 4
* MySQL / MariaDB
* cURL
* Bootstrap (UI)

---

## Struktur Database

### 1 Tabel `produk`

| Field       | Type    | Keterangan         |
| ----------- | ------- | ------------------ |
| id_produk   | INT     | Primary Key        |
| nama_produk | VARCHAR | Nama produk        |
| harga       | INT     | Harga produk       |
| kategori_id | INT     | Relasi ke kategori |
| status_id   | INT     | Relasi ke status   |

### 2 Tabel `kategori`

| Field         | Type    | Keterangan    |
| ------------- | ------- | ------------- |
| id_kategori   | INT     | Primary Key   |
| nama_kategori | VARCHAR | Nama kategori |

### 3 Tabel `status`

| Field       | Type    | Keterangan  |
| ----------- | ------- | ----------- |
| id_status   | INT     | Primary Key |
| nama_status | VARCHAR | Nama status |

Relasi:

* `produk.kategori_id → kategori.id_kategori`
* `produk.status_id → status.id_status`

---

## Alur Pengambilan Data API Fastprint

Controller: **FastprintAPI**

1. Request awal ke API Fastprint
2. Ambil `x-credentials-username` dari header response
3. Ambil `Date` dari server response
4. Generate password:

```
md5("bisacoding-DD-MM-YY")
```

5. Request ulang ke API dengan username & password valid
6. Data JSON diterima
7. Data disimpan ke database:

   * Kategori disimpan (jika belum ada)
   * Status disimpan (jika belum ada)
   * Produk disimpan dan direlasikan

Jika sukses, API mengembalikan:

```json
{
  "message": "Data berhasil disimpan",
  "total": 100
}
```

---

## Controller Utama

### FastprintAPI Controller

Fungsi utama:

* Mengambil data dari API Fastprint
* Menyimpan data ke database
* Menangani autentikasi API berbasis tanggal server

Endpoint:

```
GET /fastprintapi
```

---

### ProdukController

Fungsi:

* Menampilkan produk (status: **bisa dijual**)
* CRUD produk
* Validasi form input

#### Method yang tersedia:

| Method | Fungsi                  |
| ------ | ----------------------- |
| index  | List produk bisa dijual |
| create | Form tambah produk      |
| store  | Simpan produk           |
| edit   | Form edit produk        |
| update | Update produk           |
| delete | Hapus produk            |

Filter utama:

```
WHERE status.nama_status = 'bisa dijual'
```

---

## Fitur Aplikasi

1. Sinkronisasi API Fastprint

2. CRUD Produk

3. Relasi kategori & status

4. Validasi input form

5. Filter produk "bisa dijual"

6. UI Bootstrap

---

## Cara Menjalankan Aplikasi

1️. Clone repository

```bash
git clone <repository-url>
```

2️. Install dependency

```bash
composer install
```

3️. Konfigurasi database di `.env`

```env
database.default.hostname = localhost
database.default.database = fastprint
database.default.username = root
database.default.password =
```

4️. Jalankan migration

```bash
php spark migrate
```

5️. Jalankan server

```bash
php spark serve
```

6️. Akses browser

```
http://localhost:8080
```

7️. Sinkronisasi data API

```
http://localhost:8080/fastprintapi
```

---

## Author

**Nama:** Ahmad Shofiudin Firdani Wafa

**Posisi:** Fullstack Web Developer

**Framework:** CodeIgniter 4

---

## Arsitektur Aplikasi (MVC Flow)

Alur kerja aplikasi mengikuti konsep **MVC (Model – View – Controller)** pada CodeIgniter 4:

1. **Controller**

   * `FastprintAPI`

     * Mengakses API Fastprint
     * Mengelola autentikasi berbasis tanggal server
     * Menyimpan data ke database
   * `ProdukController`

     * Mengelola CRUD produk
     * Melakukan filter produk dengan status *bisa dijual*

2. **Model**

   * `ProdukModel`
   * `KategoriModel`
   * `StatusModel`

   Bertanggung jawab terhadap query database dan relasi antar tabel.

3. **View**

   * Menampilkan data produk
   * Form tambah & edit produk
   * Menggunakan Bootstrap untuk tampilan

Alur singkat:

```
Request → Controller → Model → Database
                   ↓
                 View
```

---

## Database Seeder / SQL Sample

Berikut contoh SQL awal (opsional) untuk memastikan tabel tersedia:

```sql
INSERT INTO status (nama_status) VALUES
('bisa dijual'),
('tidak dijual');

INSERT INTO kategori (nama_kategori) VALUES
('Elektronik'),
('ATK'),
('Aksesoris');
```

Seeder ini bersifat opsional karena data utama akan otomatis terisi dari API Fastprint.

---

## Penutup

Aplikasi ini dibuat khusus untuk memenuhi kebutuhan **Tes Teknis Programmer Fastprint**, dengan fokus pada:

* Implementasi API sesuai dokumentasi
* Struktur database ter-normalisasi
* Clean code dan MVC pattern
* Kesiapan untuk dikembangkan lebih lanjut

Terima kasih atas kesempatannya
