<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard &mdash; KasirKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-indigo-700 text-white shadow">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="/" class="font-bold text-lg">&#129534; KasirKu</a>
    <div class="flex gap-6 text-sm font-medium">
      <a href="/" class="text-indigo-200 border-b-2 border-indigo-200 pb-0.5">Dashboard</a>
      <a href="/products" class="hover:text-indigo-200 transition">Produk</a>
      <a href="/kasir" class="hover:text-indigo-200 transition">Kasir</a>
      <a href="/transactions" class="hover:text-indigo-200 transition">Transaksi</a>
    </div>
  </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

  <!-- Stats Grid -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
      <p class="text-sm text-gray-500 mb-1">Total Produk</p>
      <p class="text-3xl font-bold text-indigo-600" data-fst="total-products">0</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
      <p class="text-sm text-gray-500 mb-1">Transaksi Hari Ini</p>
      <p class="text-3xl font-bold text-green-600" data-fst="today-trx">0</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
      <p class="text-sm text-gray-500 mb-1">Pendapatan Hari Ini</p>
      <p class="text-2xl font-bold text-green-600" data-fst="today-revenue">Rp 0</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
      <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
      <p class="text-2xl font-bold text-gray-800" data-fst="total-revenue">Rp 0</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="flex gap-3 mb-8">
    <a href="/kasir" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition text-sm">
      + Transaksi Baru
    </a>
    <a href="/products" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-5 py-2.5 rounded-lg font-medium transition text-sm">
      Kelola Produk
    </a>
  </div>

  <!-- Recent Transactions -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100">
      <h2 class="font-semibold text-gray-700">Transaksi Terbaru</h2>
    </div>
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500 bg-gray-50">
          <th class="px-6 py-3 font-medium">No.</th>
          <th class="px-6 py-3 font-medium">Total</th>
          <th class="px-6 py-3 font-medium">Waktu</th>
          <th class="px-6 py-3 font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (empty($recent)): ?><tr class="empty-row">
          <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi hari ini.</td>
        </tr><?php endif; ?>
        <?php foreach ($recent as $trx): ?><tr class="trx-row hover:bg-gray-50">
          <td class="trx-id px-6 py-3 font-medium text-indigo-600"><?= htmlspecialchars("#" . $trx["id"] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="trx-total px-6 py-3 font-semibold text-gray-800"><?= htmlspecialchars(rp($trx["total"]) ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="trx-date px-6 py-3 text-gray-500"><?= htmlspecialchars($trx["created_at"] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="px-6 py-3">
            <a href="<?= htmlspecialchars("/transactions/" . $trx["id"] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="trx-link text-indigo-600 hover:underline">Detail &rarr;</a>
          </td>
        </tr><?php endforeach; ?>
      </tbody>
    </table>
    <div class="px-6 py-3 border-t border-gray-100 text-right">
      <a href="/transactions" class="text-sm text-indigo-600 hover:underline">Lihat semua transaksi &rarr;</a>
    </div>
  </div>
</div>

</body>
</html>
