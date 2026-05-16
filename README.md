# Hotel Catalog Microservice
**Oleh: Muhammad Izaz Naufal (102022400306)**

Catalog Service adalah microservice yang menangani informasi kamar (Rooms) dan layanan tambahan (Addons) dalam sistem pemesanan hotel. Proyek ini dibangun untuk memenuhi standar **Standard Integration Contract (IAE-T2)** menggunakan Laravel 11, GraphQL (Lighthouse), Swagger, dan Docker.

---

## 🚀 Fitur Utama
- **REST API**: Manajemen katalog kamar dan layanan tambahan dengan format respons standar.
- **GraphQL**: Query data kamar yang fleksibel dan efisien.
- **Security**: Autentikasi API Key menggunakan header `X-IAE-KEY`.
- **Swagger Documentation**: Dokumentasi API interaktif yang mempermudah integrasi.
- **Dockerized**: Terorkestrasi penuh menggunakan Docker Compose untuk App, MySQL, dan PHPMyAdmin.

---

## 🛠️ Stack Teknologi
- **Backend**: Laravel 11 (PHP 8.4)
- **Database**: MySQL 8.0
- **GraphQL**: Lighthouse PHP
- **API Documentation**: L5-Swagger (OpenAPI 3.0)
- **Container**: Docker & Docker Compose

---

## 📦 Instalasi & Pengoperasian

### Menggunakan Docker (Direkomendasikan)
1. **Clone Repository**:
   ```bash
   git clone <repository-url>
   cd 102022400306_Muhammad-Izaz-Naufal-Catalog-Service
   ```

2. **Bangun & Jalankan Container**:
   ```bash
   docker-compose up -d --build
   ```

3. **Setup Database (Migration & Seeding)**:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

4. **Generate Swagger Documentation**:
   ```bash
   docker-compose exec app php artisan l5-swagger:generate
   ```

### Akses Layanan
- **REST API Base URL**: `http://localhost:8000/api/v1`
- **Swagger UI**: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)
- **GraphQL Endpoint**: `http://localhost:8000/graphql`
- **GraphQL Playground**: [http://localhost:8000/graphql-playground](http://localhost:8000/graphql-playground)
- **PHPMyAdmin**: [http://localhost:8081](http://localhost:8081) (Login: `root` / `root`)

---

## 🔐 Keamanan (API Key)
Seluruh request ke endpoint REST API wajib menyertakan header berikut:
- **Header Key**: `X-IAE-KEY`
- **Header Value**: `102022400306` (NIM Anda)

---

## 📑 Dokumentasi API

### REST API
Semua respons mengikuti format **Standard Integration Contract**:
```json
{
  "status": "success",
  "message": "Data retrieved successfully",
  "data": { ... },
  "meta": {
    "service_name": "Catalog-Service",
    "api_version": "v1"
  }
}
```

**Endpoints Utama:**
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET`  | `/rooms` | Daftar kamar (Filter: `location`, `date`) |
| `GET`  | `/rooms/{id}` | Detail lengkap kamar & Addons |
| `POST` | `/rooms` | Bookmark/Simpan kamar ke katalog |
| `GET`  | `/addons` | Daftar layanan tambahan (Addons menu) |

### GraphQL Query
Contoh query untuk mendapatkan daftar kamar:
```graphql
query {
  rooms {
    id
    name
    location
    price
    description
  }
}
```

---

## 📂 Struktur Project
```text
.
├── catalog-service/         # Source code Laravel
│   ├── app/
│   │   ├── Http/Controllers/Api/   # REST Controllers
│   │   ├── Models/                 # Eloquent Models (Room, Addon, Bookmark)
│   │   └── Traits/                 # ApiResponse Wrapper (Standard Integration)
│   ├── graphql/             # Skema GraphQL
│   ├── database/seeders/    # Data Dummy (Room & Addon)
│   └── routes/api.php       # Routing API v1
├── Dockerfile               # Konfigurasi Container Laravel
├── docker-compose.yml       # Orkestrasi Services (App, DB, PMA)
└── AI_PROMPTING_LOG.md      # Rekap interaksi dengan AI
```

---

## 🔧 Troubleshooting
- **Port Conflict**: Jika port 8000 atau 8081 sudah digunakan, ubah pemetaan port di `docker-compose.yml`.
- **Database Connection**: Database MySQL berjalan di port internal container `3306`, namun dapat diakses dari host melalui port `3307`.
- **Permission Denied**: Jika menjalankan di Linux/Mac, pastikan folder `storage` dan `bootstrap/cache` memiliki izin tulis (`chmod -R 775`).
- **Swagger Error**: Jika dokumentasi tidak muncul, jalankan `php artisan l5-swagger:generate` kembali di dalam container.

---
© 2026 Muhammad Izaz Naufal. Tugas 2 - Build Your Services.
