<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Transaksi &mdash; KasirKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-indigo-700 text-white shadow">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="/" class="font-bold text-lg">&#129534; KasirKu</a>
    <div class="flex gap-6 text-sm font-medium">
      <a href="/" class="hover:text-indigo-200 transition">Dashboard</a>
      <a href="/products" class="hover:text-indigo-200 transition">Produk</a>
      <a href="/kasir" class="hover:text-indigo-200 transition">Kasir</a>
      <a href="/transactions" class="text-indigo-200 border-b-2 border-indigo-200 pb-0.5">Transaksi</a>
    </div>
  </div>
</nav>

<div class="max-w-4xl mx-auto px-4 py-8">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
    <a href="/kasir" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
      + Transaksi Baru
    </a>
  </div>

  <div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500 bg-gray-50">
          <th class="px-6 py-3 font-medium rounded-tl-xl">No.</th>
          <th class="px-6 py-3 font-medium">Item</th>
          <th class="px-6 py-3 font-medium">Total</th>
          <th class="px-6 py-3 font-medium">Waktu</th>
          <th class="px-6 py-3 font-medium text-right rounded-tr-xl">Struk</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (empty($transactions)): ?><tr class="trx-empty">
          <td colspan="5" class="px-6 py-12 text-center text-gray-400">
            Belum ada transaksi. <a href="/kasir" class="text-indigo-600 underline">Mulai transaksi</a> sekarang.
          </td>
        </tr><?php endif; ?>
        <?php foreach ($transactions as $trx): ?><tr class="trx-row hover:bg-gray-50 transition">
          <td class="trx-id px-6 py-3 font-mono font-medium text-indigo-600"><?= htmlspecialchars("#" . $trx["id"] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="trx-count px-6 py-3 text-gray-600"><?= htmlspecialchars($trx["item_count"] . " item" ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="trx-total px-6 py-3 font-semibold text-gray-800"><?= htmlspecialchars(rp($trx["total"]) ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="trx-date px-6 py-3 text-gray-500 text-xs"><?= htmlspecialchars($trx["created_at"] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td class="px-6 py-3 text-right">
            <a href="<?= htmlspecialchars("/transactions/" . $trx["id"] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="trx-detail-link text-indigo-600 hover:underline font-medium">Lihat &rarr;</a>
          </td>
        </tr><?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
