# Review FullStuck.php v0.2.0

> Reviewer: Claude Sonnet 4.6 (via AI-assisted test run)
> Tanggal: 2026-06-22
> Environment: PHP 8.5.6 / macOS Darwin / SQLite
> Method: Live testing dengan curl, pembacaan source code fullstuck.php (2734 baris)

---

## Ringkasan Eksekutif

FullStuck.php adalah micro-framework PHP single-file yang dirancang untuk rapid development dan AI-friendliness. Konsepnya kuat dan eksekusinya mumpuni untuk target audiens (developer solo, project kecil-menengah, shared hosting). Testing live menunjukkan core functionality berjalan baik, dengan **satu bug PHP 8.5 compatibility** yang perlu segera diperbaiki.

**Score Overview:**

| Dimensi | Nilai | Keterangan |
|---|---|---|
| Core Functionality | ⭐⭐⭐⭐⭐ | Routing, DB, session, CSRF semua jalan |
| Developer Experience | ⭐⭐⭐⭐ | Scaffold jelas, SOP terstruktur, API docs lengkap |
| AI-Friendliness (SOP) | ⭐⭐⭐⭐ | SOP detail, tapi beberapa bagian bisa lebih eksplisit |
| Security | ⭐⭐⭐⭐ | CSRF, escape, upload filtering sudah ada |
| PHP Compatibility | ⭐⭐⭐ | Bug PHP 8.5 pada finfo_close() |
| Testing & Reliability | ⭐⭐⭐ | Tidak ada test suite, scaffold terlalu demo-heavy |

---

## ✅ Yang Sudah Baik

### 1. Arsitektur Single-File yang Konsisten
`fullstuck.php` memuat seluruh core (routing, templating, DB, session, upload, admin dashboard) dalam satu file 2734 baris. Deploy ke shared hosting cukup upload 1 file — ini adalah nilai jual utama dan eksekusinya konsisten.

### 2. CSRF Protection Out-of-the-Box
Implementasi CSRF solid:
- `fst_csrf_token()` menyimpan token di session dengan `random_bytes(32)`
- `fst_csrf_field()` menghasilkan hidden input
- `fst_csrf_check()` menggunakan `hash_equals()` (timing-safe)
- Scaffold scaffold bawaan sudah memasang `@append => fst_csrf_field()` di setiap form

Ini rare untuk micro-framework — banyak yang melewatkan CSRF.

### 3. DOM-Based Templating (fst_template)
Sistem `fst_template()` dengan `data-fst` attributes dan ruleset DSL adalah desain unik dan cerdas. PHP/HTML dipisah bersih — developer frontend bisa buat HTML statis dulu, baru diikat ke backend. Sesuai prinsip "Frontend-First" di Phase 2 SOP.

Contoh ruleset yang dihasilkan scaffold sudah mencakup kasus kompleks: `@foreach`, `@if`, nested selector, attribute binding `[src]`/`[href]`, dan `@append`.

### 4. SPA Client-Side Agent Tanpa Library
SPA agent (inject di `<script id="fst-spa-agent">`) berjalan pure vanilla JS — tidak ada jQuery, tidak ada Alpine, tidak ada library. Intercept link dan form, fetch partial HTML, swap DOM target. History API terintegrasi dengan benar (`pushState`/`popstate`).

Testing via curl membuktikan: response halaman utama langsung jalan, form POST dengan CSRF berjalan normal via redirect-after-POST pattern.

### 5. Init CLI yang Ergonomis
```bash
php fullstuck.php init --db=sqlite --admin-pass=stuck --admin-url=/stuck --spa=yes --scaffold=yes --htaccess=yes
```
Satu perintah menghasilkan: `fullstuck.json`, `router.php`, `views/todo.html`, `assets/style.css`, `database.sqlite`, `fullstuck_v0.2.0.md`. Zero friction untuk memulai.

### 6. Admin Dashboard Built-in
`/stuck` (atau URL admin yang dikonfigurasi) memberikan dashboard untuk: melihat konfigurasi, route list, melihat log error, generate password hash. Berguna untuk debugging produksi tanpa SSH.

### 7. Database Transaction di Scaffold
Contoh di `router.php` sudah menunjukkan pattern `fst_db_begin()` / `fst_db_commit()` / `fst_db_rollback()` yang benar untuk operasi yang melibatkan file system (hapus attachment + hapus DB record). Ini adalah best practice yang jarang diajarkan di contoh CRUD sederhana.

### 8. File Upload Security
`fst_upload()` mengimplementasikan:
- Cek extension vs allowed_types
- MIME type detection via `finfo` (anti-extension-spoofing)
- Blocked PHP MIME types
- Path traversal protection (`str_starts_with realpath`)
- Safe filename sanitization (regex replace non-alphanum)
- Auto-create direktori dengan `mkdir(..., 0755, true)`

### 9. SOP AI yang Terstruktur (ai-setup.md)
Dokumen SOP untuk AI developer cukup komprehensif:
- Ada opt-out mode (Free-Style vs Guided)
- Ada tracker template (`fullstuck_brief.md`) dengan format jelas
- Ada aturan keamanan (escape, CSRF, credentials)
- Ada phase workflow yang logis (plan → UI → backend → deploy)
- Ada instruksi spesifik cara baca `fullstuck_v*.md` sebelum coding

### 10. Error Handling & Logging
- `_fst_error_handler` mengkonversi PHP errors ke `ErrorException`
- Di development mode: tampil error detail dengan stack trace
- Di production mode: tulis ke `.fst-error.log`, tampil generic message
- Error 404/403/405/500 handler bisa dikonfigurasi per-route di `fullstuck.json`

---

## ❌ Yang Kurang / Perlu Diperbaiki

### 1. Bug Kritis: PHP 8.5 Incompatibility pada `finfo_close()`

**Severity: HIGH**

`finfo_close()` deprecated di PHP 8.5 — finfo objects di-free otomatis. Karena `_fst_error_handler` mengkonversi E_DEPRECATED ke `ErrorException`, setiap file upload menghasilkan HTTP 500.

**Lokasi:** `fullstuck.php` baris 970

```php
// SEKARANG (RUSAK di PHP 8.5)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$actual_mime = finfo_file($finfo, $tmp_name);
finfo_close($finfo);  // ← Deprecated in PHP 8.5!

// FIX: Hapus finfo_close(), atau gunakan OOP approach
$finfo = new finfo(FILEINFO_MIME_TYPE);
$actual_mime = $finfo->file($tmp_name);
// (OOP finfo tidak perlu close manual)
```

Detail lengkap di [fullstuck_issues.md](fullstuck_issues.md).

### 2. SOP: Tidak Ada Instruksi Error Recovery untuk AI

SOP tidak menjelaskan apa yang harus dilakukan AI jika:
- Server mengembalikan 500 saat pengembangan
- Migrasi database gagal tengah jalan
- Template cache korup

AI akan stuck atau melakukan langkah destruktif tanpa panduan ini.

**Saran:** Tambahkan section "Error Recovery Playbook" di SOP:
```
## 🚨 Error Recovery
- HTTP 500: Cek .fst-error.log, baca view-cache/ untuk debug template
- DB gagal: Jangan DROP TABLE, gunakan ALTER TABLE untuk rollback
- Cache rusak: Hapus folder view-cache/ lalu restart server
```

### 3. Scaffold Demo Terlalu Opinionated untuk Proyek Nyata

`router.php` yang digenerate scaffold berisi full todo app dengan auth middleware demo (`cek_auth` dengan `?token=123`). Ini bagus untuk showcase tapi bermasalah untuk proyek baru:

- Developer harus hapus manual semua scaffold sebelum mulai
- Token hardcoded `123` di middleware demo bisa tertinggal di produksi (security risk)
- SOP di Phase 1 memang bilang "Bersihkan scaffold" tapi tidak eksplisit menunjukkan cara/perintah

**Saran:** Tambahkan `--scaffold=minimal` flag yang hanya generate router kosong + satu route placeholder.

### 4. Tidak Ada Built-in Test Suite / Testing Helper

SOP menyebut "Gunakan script/cURL untuk test" tapi tidak menyediakan:
- Helper `fst_test()` atau assertion function
- Template cURL test script yang dihasilkan saat init
- Cara run test tanpa server hidup (unit test untuk fungsi helper)

Ini membuat AI developer harus selalu menjalankan server untuk validasi, padahal banyak logika bisa dites secara isolated.

**Saran:** Generate `test.sh` saat `--scaffold=yes` yang berisi contoh cURL test semua route scaffold.

### 5. SOP: Tidak Ada Penjelasan Tentang View Cache

`fst_template()` menggenerate PHP cache di folder `view-cache/` (atau `build-template` di scaffold). SOP sama sekali tidak menyebut:
- Kapan cache di-invalidate?
- Apakah cache perlu dihapus saat deploy?
- Bagaimana jika template dikompilasi dengan syntax error?

SOP hanya menyebut "periksa berkas PHP hasil kompilasi di dalam folder cache" tapi tidak menjelaskan cara aksesnya atau kapan ini perlu dilakukan.

### 6. Validasi Error Message Tidak Ditampilkan di Flash

Saat validasi gagal (contoh: `task` terlalu pendek), flash message dikirim via `fst_flash_set('error', implode(', ', $val['errors']['task']))` tapi response tetap HTTP 302. Ini membuat testing via curl sulit karena tidak bisa verifikasi error message tanpa follow redirect dan render template.

Tidak ada endpoint yang return validation error langsung (contoh: HTTP 422 dengan JSON body untuk API response).

### 7. `fullstuck_v0.2.0.md` Tidak Muncul di Autocomplete AI Context

Dokumentasi API sangat detail (747 baris) tapi namanya mengandung versi (`_v0.2.0`). Setiap update versi berarti nama file berubah. SOP menyebut `fullstuck_v*.md` (glob pattern) tapi tidak semua AI tool mendukung glob untuk file reading.

**Saran:** Tambahkan symlink atau hardlink `fullstuck_api.md -> fullstuck_v0.2.0.md` agar nama stabil, atau dokumentasikan di `fullstuck_brief.md` nama file exact-nya.

### 8. Admin Dashboard Tidak Ada Rate Limiting pada Login

`/stuck` login hanya cek password hash + optional IP whitelist. Tidak ada:
- Rate limiting pada percobaan login
- Lockout setelah N gagal
- Logging percobaan login gagal

Di shared hosting (target utama FullStuck), ini bisa dibrute-force jika `admin_url` tebak-able.

---

## 💡 Saran Improvement (Nice to Have)

### Improvement 1: Tambahkan Flag `--scaffold=minimal`
```bash
php fullstuck.php init --db=sqlite --scaffold=minimal
```
Generate router.php hanya dengan satu route placeholder, tanpa todo demo app dan tanpa hardcoded middleware.

### Improvement 2: Health Check Endpoint Built-in
```
GET /__health
```
Return JSON: `{"status":"ok","version":"0.2.0","php":"8.5.6","db":"connected"}`. Berguna untuk monitoring dan untuk AI developer memverifikasi server sudah jalan.

### Improvement 3: Environment Variable Support di fullstuck.json
SOP menyebut "Rekomendasikan penggunaan variabel lingkungan (seperti `${DB_HOST}`)" tapi tidak ada dokumentasi tentang cara ini benar-benar bekerja. Perlu contoh di API docs.

### Improvement 4: SOP — Tambahkan Checklist Pre-Deploy
```markdown
## ✅ Pre-Deploy Checklist
- [ ] Ubah `environment` ke `production` di fullstuck.json
- [ ] Hapus `?token=123` dari middleware demo
- [ ] Compile Tailwind CSS (npx tailwindcss ...)
- [ ] Pastikan .htaccess terupload
- [ ] Rotasi admin password dari default 'stuck'
- [ ] Set `allowed_ips` di admin config jika perlu
```

### Improvement 5: Dokumentasi SPA Events (`fst:load`, `fst:unload`)
SPA agent men-dispatch `fst:load` dan `fst:unload` custom events, tapi tidak didokumentasikan di SOP atau API docs. Developer (dan AI) tidak tahu cara hook ke lifecycle ini untuk reinitialize third-party widgets setelah SPA navigation.

---

## Kesimpulan

FullStuck.php adalah micro-framework yang well-thought-out untuk target audiens-nya. Inovasi terbaiknya adalah DOM-based templating dengan `fst_template()` dan SPA agent tanpa dependency. SOP untuk AI juga menunjukkan pemikiran yang matang tentang AI-assisted development workflow.

**Bug PHP 8.5 harus diperbaiki segera** karena ini breaking feature (file upload) di PHP versi terbaru.

Prioritas perbaikan:
1. 🔴 Fix `finfo_close()` deprecation (PHP 8.5 compat)
2. 🟡 Tambah error recovery guide di SOP
3. 🟡 Scaffold minimal option
4. 🟢 Test helper / generated test.sh
5. 🟢 Pre-deploy checklist di SOP
