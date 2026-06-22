<?php
// === DB MIGRATIONS ===
fst_db('SCALAR', "CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price INTEGER NOT NULL DEFAULT 0,
    stock INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
fst_db('SCALAR', "CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    total INTEGER NOT NULL DEFAULT 0,
    paid INTEGER NOT NULL DEFAULT 0,
    change_amount INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
fst_db('SCALAR', "CREATE TABLE IF NOT EXISTS transaction_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_id INTEGER NOT NULL,
    product_id INTEGER,
    product_name TEXT NOT NULL,
    price INTEGER NOT NULL,
    qty INTEGER NOT NULL,
    subtotal INTEGER NOT NULL
)");

function rp($n) { return 'Rp ' . number_format((int)$n, 0, ',', '.'); }

// === DASHBOARD ===
fst_get('/', function() {
    $total_products = (int) fst_db('SCALAR', "SELECT COUNT(*) FROM products");
    $today_trx      = (int) fst_db('SCALAR', "SELECT COUNT(*) FROM transactions WHERE DATE(created_at)=DATE('now','localtime')");
    $today_revenue  = (int) fst_db('SCALAR', "SELECT COALESCE(SUM(total),0) FROM transactions WHERE DATE(created_at)=DATE('now','localtime')");
    $total_revenue  = (int) fst_db('SCALAR', "SELECT COALESCE(SUM(total),0) FROM transactions");
    $recent         = fst_db('ALL', "SELECT * FROM transactions ORDER BY created_at DESC LIMIT 5") ?: [];

    fst_template(FST_ROOT_DIR . '/views/dashboard.html',
        compact('total_products','today_trx','today_revenue','total_revenue','recent'),
    [
        '[data-fst=total-products]' => '$total_products',
        '[data-fst=today-trx]'      => '$today_trx',
        '[data-fst=today-revenue]'  => 'rp($today_revenue)',
        '[data-fst=total-revenue]'  => 'rp($total_revenue)',
        'tr.trx-row' => [
            '@foreach' => '$recent as $trx',
            'td.trx-id'    => '"#" . $trx["id"]',
            'td.trx-total' => 'rp($trx["total"])',
            'td.trx-date'  => '$trx["created_at"]',
            'a.trx-link'   => ['[href]' => '"/transactions/" . $trx["id"]'],
        ],
        'tr.empty-row' => ['@if' => 'empty($recent)'],
    ], FST_ROOT_DIR . '/build-template', true);
});

// === PRODUCTS ===
fst_get('/products', function() {
    $products = fst_db('ALL', "SELECT * FROM products ORDER BY name ASC") ?: [];

    fst_template(FST_ROOT_DIR . '/views/products.html', compact('products'), [
        'div.flash-msg'   => ['@if' => 'fst_flash_has("msg")',   '@text' => 'fst_flash_get("msg")'],
        'div.flash-error' => ['@if' => 'fst_flash_has("error")', '@text' => 'fst_flash_get("error")'],
        'form.form-add-product' => ['@append' => 'fst_csrf_field()'],
        'tr.product-row' => [
            '@foreach' => '$products as $p',
            'td.p-name'  => 'e($p["name"])',
            'td.p-price' => 'rp($p["price"])',
            'td.p-stock' => '$p["stock"]',
            'form.form-delete-product' => [
                '[action]'  => '"/products/delete/" . $p["id"]',
                '@append'   => 'fst_csrf_field()',
            ],
        ],
        'tr.product-empty' => ['@if' => 'empty($products)'],
    ], FST_ROOT_DIR . '/build-template', true);
});

fst_post('/products/add', function() {
    fst_csrf_check();
    $val = fst_validate(fst_request(), [
        'name'  => 'required|min:2',
        'price' => 'required',
        'stock' => 'required',
    ]);
    if ($val['valid']) {
        $price = max(0, (int) preg_replace('/[^0-9]/', '', $val['data']['price']));
        $stock = max(0, (int) $val['data']['stock']);
        if ($price === 0) {
            fst_flash_set('error', 'Harga tidak boleh 0.');
        } else {
            fst_db_insert('products', [
                'name'  => trim($val['data']['name']),
                'price' => $price,
                'stock' => $stock,
            ]);
            fst_flash_set('msg', 'Produk berhasil ditambahkan!');
        }
    } else {
        fst_flash_set('error', implode(', ', array_merge(...array_values($val['errors']))));
    }
    fst_redirect('/products');
});

fst_post('/products/delete/{id:i}', function($id) {
    fst_csrf_check();
    fst_db_delete('products', ['id' => $id]);
    fst_flash_set('msg', 'Produk dihapus.');
    fst_redirect('/products');
});

// === KASIR (POS) ===
fst_get('/kasir', function() {
    $products = fst_db('ALL', "SELECT * FROM products WHERE stock > 0 ORDER BY name ASC") ?: [];

    fst_template(FST_ROOT_DIR . '/views/kasir.html', compact('products'), [
        'div.flash-error' => ['@if' => 'fst_flash_has("error")', '@text' => 'fst_flash_get("error")'],
        'form#checkout-form' => ['@append' => 'fst_csrf_field()'],
        'button.product-btn' => [
            '@foreach' => '$products as $p',
            '[data-id]'    => '$p["id"]',
            '[data-name]'  => 'e($p["name"])',
            '[data-price]' => '$p["price"]',
            '[data-stock]' => '$p["stock"]',
            'span.btn-name'  => 'e($p["name"])',
            'span.btn-price' => 'rp($p["price"])',
            'span.btn-stock' => '"Stok: " . $p["stock"]',
        ],
        'p.no-products' => ['@if' => 'empty($products)'],
    ], FST_ROOT_DIR . '/build-template', true);
});

fst_post('/kasir/checkout', function() {
    fst_csrf_check();

    $cart = json_decode(fst_input('cart_json', '[]'), true);
    $paid = (int) fst_input('paid', 0);

    if (empty($cart) || !is_array($cart)) {
        fst_flash_set('error', 'Keranjang belanja kosong.');
        fst_redirect('/kasir');
        return;
    }

    try {
        fst_db_begin();
        $total     = 0;
        $validated = [];

        foreach ($cart as $item) {
            $product = fst_db_row('products', ['id' => (int)($item['id'] ?? 0)]);
            if (!$product) throw new Exception('Produk tidak ditemukan.');
            $qty = (int)($item['qty'] ?? 0);
            if ($qty <= 0) throw new Exception('Jumlah item tidak valid.');
            if ($product['stock'] < $qty) {
                throw new Exception("Stok \"{$product['name']}\" tidak cukup (sisa: {$product['stock']}).");
            }
            $subtotal  = $product['price'] * $qty;
            $total    += $subtotal;
            $validated[] = compact('product', 'qty', 'subtotal');
        }

        if ($paid < $total) throw new Exception('Jumlah bayar kurang dari total (' . rp($total) . ').');

        $change = $paid - $total;
        fst_db_insert('transactions', [
            'total'         => $total,
            'paid'          => $paid,
            'change_amount' => $change,
        ]);
        $trx_id = (int) fst_db('SCALAR', "SELECT last_insert_rowid()");

        foreach ($validated as $vi) {
            fst_db_insert('transaction_items', [
                'transaction_id' => $trx_id,
                'product_id'     => $vi['product']['id'],
                'product_name'   => $vi['product']['name'],
                'price'          => $vi['product']['price'],
                'qty'            => $vi['qty'],
                'subtotal'       => $vi['subtotal'],
            ]);
            fst_db('SCALAR', "UPDATE products SET stock = stock - ? WHERE id = ?",
                [$vi['qty'], $vi['product']['id']]);
        }

        fst_db_commit();
        fst_redirect('/transactions/' . $trx_id);
    } catch (Exception $e) {
        fst_db_rollback();
        fst_flash_set('error', $e->getMessage());
        fst_redirect('/kasir');
    }
});

// === TRANSACTIONS ===
fst_get('/transactions', function() {
    $transactions = fst_db('ALL', "
        SELECT t.*, COUNT(ti.id) AS item_count
        FROM transactions t
        LEFT JOIN transaction_items ti ON t.id = ti.transaction_id
        GROUP BY t.id
        ORDER BY t.created_at DESC
    ") ?: [];

    fst_template(FST_ROOT_DIR . '/views/transactions.html', compact('transactions'), [
        'tr.trx-row' => [
            '@foreach' => '$transactions as $trx',
            'td.trx-id'         => '"#" . $trx["id"]',
            'td.trx-count'      => '$trx["item_count"] . " item"',
            'td.trx-total'      => 'rp($trx["total"])',
            'td.trx-date'       => '$trx["created_at"]',
            'a.trx-detail-link' => ['[href]' => '"/transactions/" . $trx["id"]'],
        ],
        'tr.trx-empty' => ['@if' => 'empty($transactions)'],
    ], FST_ROOT_DIR . '/build-template', true);
});

fst_get('/transactions/{id:i}', function($id) {
    $trx = fst_db_row('transactions', ['id' => $id]);
    if (!$trx) fst_abort(404, 'Transaksi tidak ditemukan.');
    $items = fst_db('ALL', "SELECT * FROM transaction_items WHERE transaction_id = ?", [$id]) ?: [];

    fst_template(FST_ROOT_DIR . '/views/receipt.html', compact('trx', 'items'), [
        '[data-fst=trx-id]'     => '"#" . $trx["id"]',
        '[data-fst=trx-date]'   => '$trx["created_at"]',
        '[data-fst=trx-total]'  => 'rp($trx["total"])',
        '[data-fst=trx-paid]'   => 'rp($trx["paid"])',
        '[data-fst=trx-change]' => 'rp($trx["change_amount"])',
        'tr.item-row' => [
            '@foreach' => '$items as $item',
            'td.item-name'     => 'e($item["product_name"])',
            'td.item-qty'      => '$item["qty"]',
            'td.item-price'    => 'rp($item["price"])',
            'td.item-subtotal' => 'rp($item["subtotal"])',
        ],
    ], FST_ROOT_DIR . '/build-template', true);
});
