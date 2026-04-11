<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div x-data="stokMasukForm()" class="max-w-4xl">
    <div class="flex items-center gap-2 text-[12px] text-slate-400 mb-4">
        <a href="<?= base_url('stok-masuk') ?>" class="hover:text-indigo-600 transition">Stok Masuk</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Tambah Stok Masuk</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                 style="background:linear-gradient(135deg,#6366f1,#818cf8)">
                <i class="fas fa-arrow-down-to-bracket text-white text-sm"></i>
            </div>
            <h2 class="font-semibold text-slate-800">Form Stok Masuk</h2>
        </div>

        <form method="post" action="<?= base_url('stok-masuk/store') ?>" class="px-6 py-5">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">No. Transaksi</label>
                    <input type="text" name="no_transaksi" value="<?= esc($no_transaksi) ?>" class="inp font-mono bg-slate-50">
                </div>
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Tanggal Masuk <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_masuk" value="<?= date('Y-m-d') ?>" class="inp">
                </div>
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Supplier</label>
                    <select name="id_supplier" class="inp">
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach($suppliers as $sup): ?>
                        <option value="<?= $sup['id'] ?>"><?= esc($sup['nama_supplier']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Tabel Barang -->
            <div class="border border-slate-200 rounded-xl overflow-hidden mb-5">
                <div class="flex items-center justify-between bg-slate-50 px-4 py-3 border-b border-slate-200">
                    <span class="text-[13px] font-semibold text-slate-700">Daftar Barang Masuk</span>
                    <button type="button" @click="tambahBaris()" class="btn-primary text-xs py-1.5 px-3">
                        <i class="fas fa-plus text-xs"></i> Tambah Baris
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/50">
                                <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Barang</th>
                                <th class="text-center px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wide w-28">Jumlah</th>
                                <th class="text-right px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wide w-44">Harga Beli</th>
                                <th class="text-right px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wide w-44">Subtotal</th>
                                <th class="w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="border-b border-slate-100">
                                    <td class="px-4 py-2.5">
                                        <select :name="`detail[${index}][id_barang]`"
                                                @change="pilihBarang(index, $event)" class="inp py-2 text-[13px]">
                                            <option value="">-- Pilih Barang --</option>
                                            <?php foreach($barangs as $b): ?>
                                            <option value="<?= $b['id'] ?>" data-harga="<?= $b['harga_beli'] ?>">
                                                <?= esc($b['nama_barang']) ?> (Stok: <?= $b['stok'] ?> <?= $b['satuan'] ?>)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <input type="number" :name="`detail[${index}][jumlah]`"
                                               x-model.number="item.jumlah" @input="hitungSubtotal(index)"
                                               min="1" placeholder="0"
                                               class="inp py-2 text-center text-[13px]">
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">Rp</span>
                                            <input type="number" :name="`detail[${index}][harga_beli]`"
                                                   x-model.number="item.harga_beli" @input="hitungSubtotal(index)"
                                                   min="0" placeholder="0"
                                                   class="inp py-2 pl-8 text-right text-[13px]">
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5 text-right font-bold text-slate-700 text-[13px]"
                                        x-text="'Rp ' + fmt(item.subtotal)"></td>
                                    <td class="px-4 py-2.5 text-center">
                                        <button type="button" @click="hapusBaris(index)"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-400 hover:text-rose-600 flex items-center justify-center transition mx-auto">
                                            <i class="fas fa-xmark text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr class="bg-indigo-50 border-t-2 border-indigo-100">
                                <td colspan="3" class="px-4 py-3 text-right text-[13px] font-semibold text-slate-600">Total Pembelian:</td>
                                <td class="px-4 py-3 text-right font-bold text-[15px] text-indigo-700" x-text="'Rp ' + fmt(total)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Keterangan</label>
                <input type="text" name="keterangan" placeholder="Catatan tambahan (opsional)" class="inp">
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk text-sm"></i> Simpan Stok Masuk
                </button>
                <a href="<?= base_url('stok-masuk') ?>"
                   class="text-[13px] text-slate-500 px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function stokMasukForm() {
    return {
        items: [{ id_barang:'', jumlah:1, harga_beli:0, subtotal:0 }],
        get total() { return this.items.reduce((s,i)=>s+(i.subtotal||0),0); },
        tambahBaris() { this.items.push({id_barang:'',jumlah:1,harga_beli:0,subtotal:0}); },
        hapusBaris(i) { if(this.items.length>1) this.items.splice(i,1); },
        pilihBarang(i, e) {
            const o = e.target.selectedOptions[0];
            this.items[i].harga_beli = parseFloat(o.dataset.harga||0);
            this.hitungSubtotal(i);
        },
        hitungSubtotal(i) {
            const it = this.items[i];
            it.subtotal = (it.jumlah||0)*(it.harga_beli||0);
        },
        fmt(n) { return new Intl.NumberFormat('id-ID').format(n||0); }
    }
}
</script>

<?= $this->endSection() ?>
