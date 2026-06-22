<?php
// 1. Auto-Migrate Database (SQLite)
fst_db('SCALAR', "CREATE TABLE IF NOT EXISTS todos (id INTEGER PRIMARY KEY AUTOINCREMENT, task TEXT NOT NULL, attachment TEXT, is_done INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

// 2. Global View Share & Middleware Demo
fst_view_share('app_version', 'v0.2.0');
function cek_auth($next) {
    if (fst_input('token') !== '123' && !fst_session_get('logged_in')) {
        fst_flash_set('error', 'Akses ditolak! Middleware memblokir request (gunakan ?token=123)');
        return fst_redirect('/');
    }
    return $next();
}

fst_group('/api', function() {
    fst_get('/tasks', fn() => fst_json(['status' => 'success', 'data' => fst_db_select('todos', [])]));
}, 'cek_auth');

// 3. Tampilkan Halaman Utama
fst_get('/', function() {
    $todos = fst_db_select('todos', [], ['order_by' => 'is_done ASC, created_at DESC']);
    $app_version = fst_app('shared_view_data')['app_version'] ?? '';
    fst_template(FST_ROOT_DIR . '/views/todo.html', ['todos' => $todos], [
        "title" => '"Tasks - FullStuck Showcase (" . "' . $app_version . '" . ")"',
        "div.alert-msg" => ["@if" => 'fst_flash_has("msg")', "@text" => 'fst_flash_get("msg")'],
        "div.alert-error" => ["@if" => 'fst_flash_has("error")', "@text" => 'fst_flash_get("error")'],
        "form.form-add" => ["@append" => 'fst_csrf_field()'],
        "li.todo-item" => [
            "@foreach" => '$todos as $todo',
            "[class]" => '$todo["is_done"] ? "todo-item done" : "todo-item"',
            "span.task-text" => '$todo["task"]',
            "a.task-file" => ["@if" => '!empty($todo["attachment"]) && !preg_match("/\.(png|jpg|jpeg|gif|webp)$/i", $todo["attachment"])', "[href]" => '"/" . $todo["attachment"]', "@text" => '"📄 View " . strtoupper(pathinfo($todo["attachment"], PATHINFO_EXTENSION))'],
            "img.task-img" => ["@if" => '!empty($todo["attachment"]) && preg_match("/\.(png|jpg|jpeg|gif|webp)$/i", $todo["attachment"])', "[src]" => '"/" . $todo["attachment"]'],
            "form.form-toggle" => ["[action]" => '"/toggle/" . $todo["id"]', "@append" => 'fst_csrf_field()'],
            "form.form-toggle button" => ["@text" => '$todo["is_done"] ? "Undo" : "Done"'],
            "form.form-delete" => ["[action]" => '"/delete/" . $todo["id"]', "@append" => 'fst_csrf_field()']
        ],
        "li.empty-state" => ["@if" => 'empty($todos)']
    ], FST_ROOT_DIR . '/build-template', true);
});

// 4. Tambah Task & Upload File
fst_post('/add', function() {
    fst_csrf_check();
    $val = fst_validate(fst_request(), ['task' => 'required|min:3']);
    if ($val['valid']) {
        $upload = !empty($_FILES['file']['name']) ? fst_upload('file', 'assets', ['max_size' => 2048, 'allowed_types' => ['png', 'jpg', 'txt', 'pdf']]) : null;
        fst_db_insert('todos', ['task' => $val['data']['task'], 'attachment' => $upload['path'] ?? null]);
        fst_flash_set('msg', 'Task berhasil ditambahkan!');
    } else {
        fst_flash_set('error', implode(', ', $val['errors']['task']));
    }
    fst_redirect('/');
});

// 5. Toggle Status Task
fst_post('/toggle/{id:i}', function($id) {
    fst_csrf_check();
    if ($todo = fst_db_row('todos', ['id' => $id])) fst_db_update('todos', ['is_done' => !$todo['is_done']], ['id' => $id]);
    fst_redirect('/');
});

// 6. Hapus Task (Demonstrasi Database Transaction)
fst_post('/delete/{id:i}', function($id) {
    fst_csrf_check();
    try {
        fst_db_begin();
        if (($todo = fst_db_row('todos', ['id' => $id])) && !empty($todo['attachment'])) @unlink(FST_ROOT_DIR . '/' . $todo['attachment']);
        fst_db_delete('todos', ['id' => $id]);
        fst_db_commit();
        fst_flash_set('msg', 'Task & attachment dihapus!');
    } catch (Exception $e) {
        fst_db_rollback();
        fst_flash_set('error', 'Gagal menghapus task!');
    }
    fst_redirect('/');
});