<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl space-y-5">

    <!-- Struk Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Detail Penjualan</h2>
            <a href="<?= base_url('penjualan') ?>"
               class="text-xs text-slate-500 border border-slate-200 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition">
               <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <!-- Info Transaksi -->
        <div class="px-6 py-5 grid grid-cols-2 sm:grid-cols-4 gap-4 border-b border-slate-100">
            <div>
                <p class="text-xs text-slate-400 mb-1">No. Transaksi</p>
                <span class="font-mono text-sm bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg"><?= esc($penjualan['no_transaksi']) ?></span>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                <p class="text-sm font-medium text-slate-700"><?= date('d M Y', strtotime($penjualan['tanggal_jual'])) ?></p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Pembeli</p>
                <p class="text-sm font-medium text-slate-700"><?= esc($penjualan['nama_pembeli'] ?? 'Umum') ?></p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Status</p>
                <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">Lunas</span>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Barang</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Jumlah</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Harga</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($details as $d): ?>
                    <tr>
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-slate-800"><?= esc($d['nama_barang']) ?></p>
                            <p class="text-xs text-slate-400 font-mono"><?= esc($d['kode_barang']) ?></p>
                        </td>
                        <td class="px-6 py-3.5 text-center text-slate-700"><?= number_format($d['jumlah']) ?> <?= esc($d['satuan']) ?></td>
                        <td class="px-6 py-3.5 text-right text-slate-700">Rp <?= number_format($d['harga_jual'], 0, ',', '.') ?></td>
                        <td class="px-6 py-3.5 text-right font-semibold text-slate-800">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Bayar -->
        <div class="px-6 py-5 bg-slate-50 rounded-b-2xl space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Total Belanja</span>
                <span class="font-semibold text-slate-800">Rp <?= number_format($penjualan['total_harga'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Uang Bayar</span>
                <span class="font-semibold text-slate-800">Rp <?= number_format($penjualan['bayar'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between text-sm pt-2 border-t border-slate-200">
                <span class="font-semibold text-slate-700">Kembalian</span>
                <span class="font-bold text-lg text-emerald-600">Rp <?= number_format($penjualan['kembalian'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
