# API Documentation - Laundry App

## Authentication

Semua request ke endpoint API wajib menyertakan token keamanan pada bagian Header.

- **Header Key:** `X-API-KEY`
- **Header Value:** `laundry_secret_2026`

---

## 1. Get All Services

Mengambil daftar seluruh layanan laundry yang tersedia di sistem.

- **URL:** `/api/services`
- **Method:** `GET`
- **Headers:**
  - `X-API-KEY: laundry_secret_2026`

### Contoh Request cURL

```bash
curl -X GET http://localhost:8080/api/services \
  -H "X-API-KEY: laundry_secret_2026"
```

### Contoh Response (200 OK)

```json
{
  "status": 200,
  "message": "Daftar layanan laundry berhasil diambil.",
  "data": [
    {
      "id": "1",
      "name": "Cuci Biasa",
      "price": "7000",
      "description": "Cuci bersih menggunakan deterjen premium. Cocok untuk pakaian sehari-hari.",
      "duration": "48",
      "image": null,
      "created_at": "2026-06-29 14:28:53",
      "updated_at": "2026-06-29 14:28:53"
    },
    {
      "id": "2",
      "name": "Setrika",
      "price": "5000",
      "description": "Setrika rapi dengan uap. Pakaian dijamin licin dan wangi.",
      "duration": "24",
      "image": null,
      "created_at": "2026-06-29 14:28:53",
      "updated_at": "2026-06-29 14:28:53"
    }
  ]
}
```

---

## 2. Get Booking Status

Mengambil status detail pelacakan serta total harga dari pesanan berdasarkan ID Booking.

- **URL:** `/api/booking-status/{id}`
- **Method:** `GET`
- **Headers:**
  - `X-API-KEY: laundry_secret_2026`

### Contoh Request cURL

```bash
curl -X GET http://localhost:8080/api/booking-status/2 \
  -H "X-API-KEY: laundry_secret_2026"
```

### Contoh Response Sukses (200 OK)

```json
{
  "status": 200,
  "message": "Status pemesanan berhasil ditemukan.",
  "data": {
    "id_booking": "2",
    "status_order": "processing",
    "total_harga": "54000",
    "updated_at": "2026-06-29 14:28:53"
  }
}
```

---

## Error Responses

### 1. Missing or Invalid Token (401 Unauthorized)

Terjadi jika header `X-API-KEY` tidak disertakan atau nilai token rahasia salah.

```json
{
  "status": 401,
  "error": "Unauthorized",
  "message": "Akses ditolak. X-API-KEY tidak valid atau tidak disertakan pada Header request."
}
```

### 2. Data Not Found (404 Not Found)

Terjadi jika melakukan pencarian status booking dengan ID yang tidak terdaftar di database.

```json
{
  "status": 404,
  "error": "Not Found",
  "message": "Data pemesanan dengan ID 999 tidak ditemukan."
}
```
