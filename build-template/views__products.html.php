<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk &mdash; KasirKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-indigo-700 text-white shadow">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="/" class="font-bold text-lg">&#129534; KasirKu</a>
    <div class="flex gap-6 text-sm font-medium">
      <a href="/" class="hover:text-indigo-200 transition">Dashboard</a>
      <a href="/products" class="text-indigo-200 border-b-2 border-indigo-200 pb-0.5">Produk</a>
      <a href="/kasir" class="hover:text-indigo-200 transition">Kasir</a>
      <a href="/transactions" class="hover:text-indigo-200 transition">Transaksi</a>
    </div>
  </div>
</nav>

<div class="max-w-4xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Produk</h1>

  <!-- Flash messages -->
  <?php if (fst_flash_has("msg")): ?><div class="flash-msg hidden bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm"><?= htmlspecialchars(fst_flash_get("msg") ?? '', ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
  <?php if (fst_flash_has("error")): ?><div class="flash-error hidden bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm"><?= htmlspecialchars(fst_flash_get("error") ?? '', ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

  <!-- Add Product Form -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h2 class="font-semibold text-gray-700 mb-4">Tambah Produk Baru</h2>
    <form class="form-add-product flex flex-col sm:flex-row gap-3" action="/products/add" method="POST">
      <!-- CSRF injected by fst_template -->
      <input type="text" name="name" placeholder="Nama produk" required class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
      <input type="text" name="price" placeholder="Harga (Rp)" required inputmode="numeric" class="w-36 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
      <input type="number" name="stock" placeholder="Stok" required min="0" class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
        + Tambah
      </button>
    <?= fst_csrf_field() ?? '' ?></form>
  </div>

  <!-- Products Table -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100">
      <h2 class="font-semibold text-gray-700">Daftar Produk</h2>
    </div>
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500 bg-gray-50">
          <th class="px-6 py-3 font-medium">Nama</th>
          <th class="px-6 py-3 font-medium">Harga</th>
          <th class="px-6 py-3 font-medium">Stok</th>
          <th class="px-6 py-3 font-medium text-right">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (empty($products)): ?><tr class="product-empty">
          <td colspan="4" class="px-6 py-10 text-center text-gray-400">
            Belum ada produk. Tambahkan produk pertama Anda di atas.
          </td>
        </tr><?php endif; ?>
        <?php foreach ($products as $p): ?><tr class="product-row hover:bg-gray-50">
          <td class="p-name px-6 py-3 font-medium text-gray-800"><?= htmlspecialchars(e($p["name"]) ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="p-price px-6 py-3 text-gray-700"><?= htmlspecialchars(rp($p["price"]) ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="p-stock px-6 py-3"><?= htmlspecialchars($p["stock"] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="px-6 py-3 text-right">
            <form class="form-delete-product inline" action="<?= htmlspecialchars("/products/delete/" . $p["id"] ?? '', ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Hapus produk ini?')">
              <!-- CSRF injected by fst_template -->
              <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">
                Hapus
              </button>
            <?= fst_csrf_field() ?? '' ?></form>
          </td>
        </tr><?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
