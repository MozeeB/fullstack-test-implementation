AI BARU: WAJIB BACA SOP DI https://raw.githubusercontent.com/milio48/fullstuck/main/docs/ai-setup.md DAN BACA API DI fullstuck_v*.md DULU!

# 📌 Project Brief & Status Tracker — KasirKu

## 💡 Ringkasan Cepat (Quick Summary)
- Proyek: Aplikasi kasir/POS sederhana berbasis FullStuck.php v0.2.0
- Stack: PHP 8.5 / SQLite / Tailwind CDN / Vanilla JS
- Status: ✅ Semua fitur utama selesai & tested
- SOP Mode: `ai_sop: true`
- Server: `php -S localhost:8000 fullstuck.php`

## 1. Status Proyek
- **Fase Aktif:** Selesai (Phase 3 done)
- **Fitur Sedang Dikerjakan:** —

## 2. Rencana Rute (Routing / To-Do List)
- [x] `GET /` → `views/dashboard.html` — stats + 5 transaksi terakhir
- [x] `GET /products` → `views/products.html` — list produk + form tambah
- [x] `POST /products/add` → validasi + insert produk
- [x] `POST /products/delete/{id}` → hapus produk
- [x] `GET /kasir` → `views/kasir.html` — POS interface (grid produk + cart JS)
- [x] `POST /kasir/checkout` → proses transaksi + kurang stok + redirect struk
- [x] `GET /transactions` → `views/transactions.html` — riwayat semua transaksi
- [x] `GET /transactions/{id}` → `views/receipt.html` — struk detail + print

## 3. Skema Database
- Tabel `products` (id, name, price, stock, created_at)
- Tabel `transactions` (id, total, paid, change_amount, created_at)
- Tabel `transaction_items` (id, transaction_id, product_id, product_name, price, qty, subtotal)

## 4. Arsitektur Kasir Page
Cart dikelola **client-side JS** (in-memory object `cartItems`).
Saat checkout, cart di-serialize ke JSON dan dikirim via hidden input `cart_json`.
Backend memvalidasi ulang stok dari DB sebelum commit — bukan percaya data dari client.

## 5. Referensi Dokumen (Pola Hub & Spoke)
- [Review Framework](docs/review.md) — review FullStuck.php v0.2.0
- [Bug Report](docs/fullstuck_issues.md) — PHP 8.5 finfo_close() bug
- [Test Results](docs/testing-results.md) — hasil curl test awal
