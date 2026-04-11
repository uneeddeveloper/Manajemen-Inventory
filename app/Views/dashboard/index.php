<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <!-- Penjualan -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 card-lift shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#6366f1,#818cf8)">
                <i class="fas fa-cash-register text-white text-sm"></i>
            </div>
            <span class="badge bg-indigo-50 text-indigo-600"><?= $transaksi_hari_ini ?> transaksi</span>
        </div>
        <p class="text-[22px] font-bold text-slate-800 leading-tight">Rp <?= number_format($penjualan_hari_ini, 0, ',', '.') ?></p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Penjualan Hari Ini</p>
    </div>

    <!-- Barang -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 card-lift shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#8b5cf6,#a78bfa)">
                <i class="fas fa-cube text-white text-sm"></i>
            </div>
            <span class="badge bg-violet-50 text-violet-600">SKU</span>
        </div>
        <p class="text-[22px] font-bold text-slate-800 leading-tight"><?= number_format($total_barang) ?></p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Jenis Barang</p>
    </div>

    <!-- Supplier -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 card-lift shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#10b981,#34d399)">
                <i class="fas fa-truck text-white text-sm"></i>
            </div>
            <span class="badge bg-emerald-50 text-emerald-600">Aktif</span>
        </div>
        <p class="text-[22px] font-bold text-slate-800 leading-tight"><?= number_format($total_supplier) ?></p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Total Supplier</p>
    </div>

    <!-- Stok Menipis -->
    <div class="rounded-2xl p-5 card-lift shadow-sm <?= $stok_minimum > 0 ? 'bg-rose-500 border border-rose-400' : 'bg-white border border-slate-100' ?>">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center <?= $stok_minimum > 0 ? 'bg-white/20' : 'bg-orange-50' ?>">
                <i class="fas fa-triangle-exclamation text-sm <?= $stok_minimum > 0 ? 'text-white' : 'text-orange-500' ?>"></i>
            </div>
            <?php if($stok_minimum > 0): ?>
            <span class="badge bg-white/20 text-white">Perlu Restock</span>
            <?php endif; ?>
        </div>
        <p class="text-[22px] font-bold leading-tight <?= $stok_minimum > 0 ? 'text-white' : 'text-slate-800' ?>"><?= number_format($stok_minimum) ?></p>
        <p class="text-xs mt-1 font-medium <?= $stok_minimum > 0 ? 'text-rose-100' : 'text-slate-400' ?>">Stok Menipis</p>
    </div>
</div>

<!-- Row 2 -->
<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 mb-4">

    <!-- Transaksi Terbaru -->
    <div class="xl:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-1.5 h-5 bg-indigo-500 rounded-full"></div>
                <h3 class="font-semibold text-slate-800 text-[14px]">Transaksi Terbaru</h3>
            </div>
            <a href="<?= base_url('penjualan') ?>"
               class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                Lihat semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <?php if (empty($transaksi_terbaru)): ?>
        <div class="flex flex-col items-center justify-center py-14 text-slate-300">
            <i class="fas fa-receipt text-4xl mb-3"></i>
            <p class="text-sm text-slate-400">Belum ada transaksi</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-50">
            <?php foreach ($transaksi_terbaru as $trx): ?>
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-indigo-500 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold text-slate-800 font-mono"><?= esc($trx['no_transaksi']) ?></p>
                    <p class="text-[11px] text-slate-400 mt-0.5"><?= esc($trx['nama_pembeli'] ?? 'Umum') ?> &bull; <?= date('d M Y', strtotime($trx['tanggal_jual'])) ?></p>
                </div>
                <span class="text-[13px] font-bold text-slate-700">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Barang Terlaris -->
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100">
            <div class="w-1.5 h-5 bg-violet-500 rounded-full"></div>
            <h3 class="font-semibold text-slate-800 text-[14px]">Barang Terlaris</h3>
        </div>

        <?php if (empty($barang_terlaris)): ?>
        <div class="flex flex-col items-center justify-center py-14 text-slate-300">
            <i class="fas fa-chart-bar text-4xl mb-3"></i>
            <p class="text-sm text-slate-400">Belum ada data</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-50">
            <?php
            $rankColors = ['bg-amber-400','bg-slate-300','bg-orange-400','bg-slate-200','bg-slate-200'];
            foreach ($barang_terlaris as $i => $brg):
            ?>
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                <span class="w-6 h-6 rounded-full text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 <?= $rankColors[$i] ?? 'bg-slate-200' ?>">
                    <?= $i + 1 ?>
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold text-slate-800 truncate"><?= esc($brg['nama_barang']) ?></p>
                    <p class="text-[11px] text-slate-400 mt-0.5"><?= number_format($brg['total_terjual']) ?> <?= esc($brg['satuan']) ?> terjual</p>
                </div>
                <span class="text-[12px] font-bold text-emerald-600 flex-shrink-0">Rp <?= number_format($brg['total_pendapatan'], 0, ',', '.') ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Stok Menipis Alert -->
<?php if (!empty($stok_menipis)): ?>
<div class="bg-white rounded-2xl border border-rose-200 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 bg-rose-50 border-b border-rose-100">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 bg-rose-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-triangle-exclamation text-white text-xs"></i>
            </div>
            <div>
                <h3 class="font-semibold text-rose-800 text-[14px]">Peringatan Stok Menipis</h3>
                <p class="text-[11px] text-rose-500"><?= count($stok_menipis) ?> barang perlu segera direstock</p>
            </div>
        </div>
        <a href="<?= base_url('stok-masuk/create') ?>" class="btn-primary text-xs py-2 px-4" style="background:#ef4444">
            <i class="fas fa-plus text-xs"></i> Tambah Stok
        </a>
    </div>
    <table class="tbl w-full">
        <thead>
            <tr>
                <th class="text-left">Nama Barang</th>
                <th class="text-left">Kategori</th>
                <th class="text-center">Stok Saat Ini</th>
                <th class="text-center">Minimum</th>
                <th class="text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stok_menipis as $brg): ?>
            <tr>
                <td class="font-semibold text-slate-800"><?= esc($brg['nama_barang']) ?></td>
                <td><span class="badge bg-slate-100 text-slate-600"><?= esc($brg['nama_kategori'] ?? '-') ?></span></td>
                <td class="text-center">
                    <span class="badge bg-rose-100 text-rose-700">
                        <?= number_format($brg['stok']) ?> <?= esc($brg['satuan']) ?>
                    </span>
                </td>
                <td class="text-center text-slate-500 font-medium"><?= number_format($brg['stok_minimum']) ?></td>
                <td>
                    <a href="<?= base_url('stok-masuk/create') ?>"
                       class="text-[12px] text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1">
                        Restock <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
