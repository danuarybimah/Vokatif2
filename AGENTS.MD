# VOKATIF API PLATFORM — PROJECT GUIDE
k
## Konteks

Vokatif adalah platform event management berbasis Laravel yang menyediakan:

* REST API
* JWT Authentication
* API KEY Authentication
* QR Ticket System
* Organizer Dashboard
* QR Check-in Scanner
* Ticket Purchase Flow
* Postman API Testing

Project masih tahap development aktif.
Backend Laravel menjadi source of truth utama untuk seluruh behavior API dan frontend.

---

# Behavior Expectations

* Jangan asal implementasi kalau requirement ambigu.
* Kalau ada bug backend, laporkan — jangan ditutup pakai fallback frontend.
* Jangan refactor file di luar scope task.
* Kalau menemukan design/problem architecture, diskusikan dulu sebelum implementasi besar.
* Ikuti struktur dan convention project yang sudah ada.
* Legacy code yang sudah tidak dipakai boleh langsung dihapus.
* Jangan mempertahankan fallback legacy behavior.
* Untuk testing yang tidak bisa dijalankan AI, arahkan user testing manual via terminal atau Postman.

---

# Project Structure

```text
Vokatif2/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── V1/
│   │   │   └── Web/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── organizer/
│       ├── tickets/
│       ├── events/
│       ├── layouts/
│       └── auth/
│
├── routes/
│   ├── api.php
│   └── web.php
│
├── storage/
├── tests/
├── vendor/
├── package.json
├── composer.json
├── vite.config.js
└── artisan
```

---

# Backend Rules (Laravel)

## Controller Rules

* API controller wajib return JSON response.
* Gunakan response format konsisten:

```json
{
    "success": true,
    "message": "Success message",
    "data": {}
}
```

* Gunakan HTTP status yang sesuai:

  * 200 OK
  * 201 Created
  * 401 Unauthorized
  * 403 Forbidden
  * 404 Not Found
  * 422 Validation Error
  * 500 Internal Server Error

---

# Authentication Rules

## JWT Authentication

JWT dipakai untuk:

* login user
* profile auth
* ticket user
* order user
* organizer access

Header:

```text
Authorization: Bearer TOKEN
```

JWT route wajib memakai middleware:

```php
auth:api
```

---

## API KEY Authentication

API KEY dipakai untuk public API access.

Header wajib:

```text
X-VOKATIF-KEY
```

Contoh:

```text
X-VOKATIF-KEY: vokatif_demo_key_2026
```

Middleware:

```php
ApiKeyMiddleware
```

API KEY tidak menggantikan JWT.

JWT dan API KEY memiliki fungsi berbeda.

---

# Database Rules

## Audit Fields

Gunakan:

* created_at
* updated_at

Laravel timestamps wajib aktif.

---

## Money Rules

Gunakan:

```php
decimal(15,2)
```

untuk:

* ticket price
* subtotal
* total payment
* revenue

---

# Ticket System Rules

## Ticket Status

Status ticket:

* active
* used
* invalid

---

## QR Ticket Rules

QR Code wajib menggunakan:

```php
$ticket->ticket_code
```

Jangan encode full JSON object ke QR.

QR harus berisi string ticket code langsung supaya scanner stabil.

Contoh:

```php
QrCode::size(320)->generate($ticket->ticket_code)
```

---

# Organizer Check-in Rules

## Check-in Validation

Ticket hanya valid jika:

```php
$ticket->status === 'active'
```

Jika success:

* status berubah menjadi `used`
* simpan check-in record

Jika gagal:

* return message error jelas

Contoh:

```json
{
    "success": false,
    "message": "Ticket sudah digunakan"
}
```

---

# Scanner Rules

Scanner organizer menggunakan:

```text
html5-qrcode
```

Features:

* realtime scan
* upload QR image
* mobile camera support

Jika scanner gagal:

* jangan fallback fake success
* tampilkan error asli backend

---

# Frontend Rules

## Blade Rules

Gunakan:

* Tailwind CSS
* glassmorphism UI
* consistent spacing
* rounded card design

---

## Dashboard Rules

Organizer dashboard harus menampilkan:

* total events
* tickets sold
* revenue
* check-ins
* latest orders
* analytics chart

---

# API Route Convention

Gunakan prefix:

```php
/api/v1/
```

Contoh:

```text
/api/v1/auth/login
/api/v1/events
/api/v1/orders
/api/v1/tickets
```

---

# API Testing Rules

Semua endpoint wajib bisa dites via Postman.

Minimal testing:

* login JWT
* auth me
* event list
* create order
* payment
* ticket list
* organizer check-in

---

# Postman Rules

Header testing:

## JWT

```text
Authorization: Bearer TOKEN
```

## API KEY

```text
X-VOKATIF-KEY: vokatif_demo_key_2026
```

---

# QR Scanner Rules

Scanner harus support:

* webcam realtime
* upload image QR
* mobile camera
* duplicate scan prevention

---

# Error Handling Rules

Jangan return HTML untuk API route.

Seluruh API wajib return JSON.

Jika muncul HTML Laravel page:

* berarti route salah
* middleware salah
* atau endpoint bukan API route

---

# Development Stage

Project masih tahap development aktif.

Diperbolehkan:

* hapus legacy code
* ubah struktur endpoint
* refactor scanner flow

Selama:

* contract API tetap konsisten
* Postman testing tetap jalan

---

# Current Main Features

## Public API

* event list
* event detail

## JWT Auth

* login
* me
* logout
* refresh

## Order System

* create order
* payment simulation

## Ticket System

* QR ticket
* ticket validation

## Organizer

* dashboard
* event management
* QR scanner
* realtime check-in

---

# Important Notes

* Backend menjadi source of truth.
* Frontend tidak boleh memalsukan validation success.
* QR validation wajib berasal dari backend.
* Jangan hardcode fake data untuk flow check-in.
* Semua API harus dapat dites via Postman sebelum dianggap selesai.
