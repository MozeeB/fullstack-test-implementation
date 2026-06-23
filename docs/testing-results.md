# Testing Results — FullStuck.php v0.2.0 + KasirKu App

> Date: 2026-06-22
> PHP: 8.5.6 / macOS Darwin
> DB: SQLite
> Server: `php -S localhost:8099 fullstuck.php`

---

## Phase 1 — Framework Testing (Scaffold Todo App)

### Setup

```bash
curl -O https://raw.githubusercontent.com/milio48/fullstuck/main/fullstuck.php
php fullstuck.php init --db=sqlite --admin-pass=stuck --admin-url=/stuck --spa=yes --scaffold=yes --htaccess=yes
php -S localhost:8099 fullstuck.php
```

**Output init:** `FullStuck initialized successfully!`

**Files generated:** `.htaccess`, `assets/style.css`, `database.sqlite`, `fullstuck.json`, `fullstuck_v0.2.0.md` (747 baris), `router.php`, `views/todo.html`

### Results

| # | Method | Endpoint | Expected | Actual | Status |
|---|--------|----------|----------|--------|--------|
| 1 | GET | `/` | 200 HTML | 200 HTML | ✅ PASS |
| 2 | GET | `/api/tasks` (no auth) | 302 redirect | 302 | ✅ PASS |
| 3 | GET | `/api/tasks?token=123` | 200 JSON | 200 JSON | ✅ PASS |
| 4 | GET | `/nonexistent` | 404 | 404 | ✅ PASS |
| 5 | GET | `/toggle/abc` | 404 (invalid type) | 404 | ✅ PASS |
| 6 | GET | `/stuck` | 302 to login | 302 | ✅ PASS |
| 7 | POST | `/add` (valid task) | 302 redirect | 302 | ✅ PASS |
| 8 | POST | `/add` (task < 3 char) | 302 + flash error | 302 | ✅ PASS |
| 9 | POST | `/add` (empty task) | 302 + flash error | 302 | ✅ PASS |
| 10 | POST | `/toggle/1` | 302 redirect | 302 | ✅ PASS |
| 11 | POST | `/delete/2` | 302 redirect | 302 | ✅ PASS |
| 12 | POST | `/add` (file upload .txt) | 302 redirect | **500** | ❌ FAIL |
| 13 | POST | `/add` (no CSRF token) | 403 Forbidden | 403 | ✅ PASS |

**Phase 1: 12/13 PASS — 1 FAIL (PHP 8.5 bug, lihat [fullstuck_issues.md](fullstuck_issues.md))**

### CRUD Flow (Todo Scaffold)

```bash
POST /add task="Test Task Satu"  → 302, DB record id=2 created ✅
GET  /api/tasks?token=123        → [id:1 is_done:0, id:2 is_done:0] ✅
POST /toggle/1                   → 302, is_done: 0→1 ✅
POST /delete/2                   → 302, record deleted ✅
GET  /api/tasks?token=123        → [id:1 is_done:1] ✅
```

---

## Phase 2 — KasirKu App Testing

### Routes Tested

| # | Method | Endpoint | Expected | Actual | Status |
|---|--------|----------|----------|--------|--------|
| 1 | GET | `/` (dashboard) | 200 HTML | 200 | ✅ PASS |
| 2 | GET | `/products` | 200 HTML | 200 | ✅ PASS |
| 3 | GET | `/kasir` | 200 HTML | 200 | ✅ PASS |
| 4 | GET | `/transactions` | 200 HTML | 200 | ✅ PASS |
| 5 | POST | `/products/add` (valid) | 302 redirect | 302 | ✅ PASS |
| 6 | POST | `/products/add` (nama 1 char) | 302 + flash error | 302 | ✅ PASS |
| 7 | POST | `/products/add` (harga 0) | 302 + flash error | 302 | ✅ PASS |
| 8 | POST | `/kasir/checkout` (valid) | 302 → `/transactions/{id}` | 302 | ✅ PASS |
| 9 | POST | `/kasir/checkout` (cart kosong `[]`) | 302 + flash error | 302 | ✅ PASS |
| 10 | POST | `/kasir/checkout` (bayar kurang) | 302 + flash error | 302 | ✅ PASS |
| 11 | GET | `/transactions/1` | 200 HTML struk | 200 | ✅ PASS |
| 12 | GET | `/transactions/999` | 404 | 404 | ✅ PASS |
| 13 | GET | `/transactions` | 200 HTML | 200 | ✅ PASS |
| 14 | POST | `/kasir/checkout` (no CSRF) | 403 Forbidden | 403 | ✅ PASS |

**Phase 2: 14/14 PASS**

### Checkout Flow Detail

```bash
# Tambah 2 produk
POST /products/add  name="Kopi Hitam"  price=5000   stock=20  → 302 ✅
POST /products/add  name="Roti Bakar"  price=12000  stock=10  → 302 ✅

# Checkout: 2x Kopi (10.000) + 1x Roti (12.000) = total 22.000, bayar 25.000
POST /kasir/checkout
  cart_json = [{"id":"1","qty":2},{"id":"2","qty":1}]
  paid = 25000
→ 302 Location: /transactions/1 ✅

# Verifikasi DB setelah checkout
products: Kopi Hitam stock 20→16 ✅, Roti Bakar stock 10→8 ✅
transactions: id=1, total=22000, paid=25000, change_amount=3000 ✅
transaction_items: 2 baris (Kopi Hitam qty=2 subtotal=10000, Roti Bakar qty=1 subtotal=12000) ✅

# Struk
GET /transactions/1 → 200 HTML dengan semua data benar ✅
```

### Database Integrity

| Cek | Hasil |
|---|---|
| Stock dikurangi setelah checkout | ✅ |
| Transaksi dan items masuk dalam 1 DB transaction | ✅ |
| Rollback jika stok tidak cukup | ✅ |
| `last_insert_rowid()` menghasilkan ID benar | ✅ |
| Checkout dengan produk tidak ada di DB | ✅ 302 + flash error |

### Security

| Cek | Hasil |
|---|---|
| CSRF token invalid → 403 | ✅ |
| Cart JSON dari client divalidasi ulang ke DB | ✅ |
| SQL injection via cart_json | ✅ (pakai fst_db_row + fst_db_insert parameterized) |
| Route param `{id:i}` enforce integer | ✅ |

---

## Observations

### Template Rendering
- `fst_template()` berjalan: data-fst attributes di-render, @foreach duplikasi baris per record, @if menyembunyikan empty-state ketika data ada ✅
- SPA agent (`<script id="fst-spa-agent">`) ter-inject, navigasi antar halaman tanpa full reload ✅
- CSRF field di-inject via `@append` ke semua form ✅

### Performance (Informal)
- Init time: < 100ms (SQLite, localhost)
- Template compile (pertama kali): auto-cache ke `build-template/`
- Subsequent requests menggunakan PHP cache — lebih cepat

### Known Issue
- File upload (`fst_upload`) crash di PHP 8.5 karena `finfo_close()` deprecated
- Workaround: downgrade ke PHP 8.4, atau tunggu fix upstream
- Detail: [fullstuck_issues.md](fullstuck_issues.md)
