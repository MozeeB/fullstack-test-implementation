# Testing Results — FullStuck.php v0.2.0

> Date: 2026-06-22
> PHP: 8.5.6 / macOS Darwin
> DB: SQLite
> Server: `php -S localhost:8099 fullstuck.php`

---

## Setup

```bash
curl -O https://raw.githubusercontent.com/milio48/fullstuck/main/fullstuck.php
php fullstuck.php init --db=sqlite --admin-pass=stuck --admin-url=/stuck --spa=yes --scaffold=yes --htaccess=yes
php -S localhost:8099 fullstuck.php
```

**Output init:** `FullStuck initialized successfully!`

**Files generated:**
- `.htaccess` ✅
- `assets/style.css` ✅
- `database.sqlite` ✅
- `fullstuck.json` ✅
- `fullstuck_v0.2.0.md` ✅ (747 baris API docs)
- `router.php` ✅
- `views/todo.html` ✅

---

## Test Results

| # | Method | Endpoint | Expected | Actual | Status |
|---|--------|----------|----------|--------|--------|
| 1 | GET | `/` | 200 HTML | 200 HTML ✅ | PASS |
| 2 | GET | `/api/tasks` (no auth) | 302 redirect | 302 ✅ | PASS |
| 3 | GET | `/api/tasks?token=123` | 200 JSON | 200 JSON ✅ | PASS |
| 4 | GET | `/nonexistent` | 404 | 404 ✅ | PASS |
| 5 | GET | `/toggle/abc` | 404 (invalid param type) | 404 ✅ | PASS |
| 6 | GET | `/stuck` | 302 to login | 302 ✅ | PASS |
| 7 | POST | `/add` (valid task) | 302 redirect | 302 ✅ | PASS |
| 8 | POST | `/add` (task < 3 char) | 302 + flash error | 302 ✅ | PASS |
| 9 | POST | `/add` (empty task) | 302 + flash error | 302 ✅ | PASS |
| 10 | POST | `/toggle/1` | 302 redirect | 302 ✅ | PASS |
| 11 | POST | `/delete/2` | 302 redirect | 302 ✅ | PASS |
| 12 | POST | `/add` (with file, .txt) | 302 redirect | **500 ❌** | **FAIL** |
| 13 | POST | `/add` (no CSRF token) | 403 Forbidden | 403 ✅ | PASS |

**Pass: 12/13 | Fail: 1/13**

---

## Test Detail — CRUD Flow

```bash
# Tambah task
POST /add task="Test Task Satu" → 302 → DB record id=2 created ✅

# Verifikasi via API
GET /api/tasks?token=123
→ {"status":"success","data":[{"id":1,...,"is_done":0},{"id":2,...,"is_done":0}]} ✅

# Toggle task 1 (is_done: 0 → 1)
POST /toggle/1 → 302 ✅

# Delete task 2
POST /delete/2 → 302 ✅

# Final state
GET /api/tasks?token=123
→ {"status":"success","data":[{"id":1,...,"is_done":1}]} ✅
```

---

## Test Detail — Security

### CSRF Protection
- Request tanpa `_token`: **403 Forbidden** ✅
- Request dengan token sesi berbeda: **403 Forbidden** ✅  
- Request dengan token yang valid (sesi sama): **302 redirect** ✅

### Route Parameter Type Enforcement
- `GET /toggle/abc` (route didefinisikan sebagai `{id:i}` = integer only): **404** ✅

### API Middleware
- `GET /api/tasks` tanpa token/session: **302** (redirect ke `/`) ✅
- `GET /api/tasks?token=123`: **200 JSON** ✅

---

## Test Detail — File Upload (FAIL)

```bash
POST /add
  task = "Task with file"
  file = test_upload.txt (21 bytes, text/plain)

Response: HTTP 500 Internal Server Error

Error: Function finfo_close() is deprecated since 8.5,
       as finfo objects are freed automatically

Location: fullstuck.php:970
Root cause: E_DEPRECATED dikonversi ke ErrorException oleh _fst_error_handler
```

Lihat [fullstuck_issues.md](fullstuck_issues.md) untuk detail dan fix.

---

## Observations

### Homepage Rendering
- Template `fst_template()` berjalan benar: title diset dinamis, CSRF field di-inject ke form, empty-state ditampilkan saat DB kosong
- SPA agent JS ter-inject di `<script id="fst-spa-agent">` ✅

### Database
- SQLite auto-migrate via `CREATE TABLE IF NOT EXISTS` di router.php berjalan ✅
- Transaction pattern (begin/commit/rollback) pada delete berjalan ✅

### Response Headers
- Redirect menggunakan `X-FST-Redirect` header untuk SPA mode ✅
- Content-type `text/html` untuk SPA partial response ✅
