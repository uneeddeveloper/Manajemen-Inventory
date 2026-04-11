<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-[12px] text-slate-400 mb-4">
        <a href="<?= base_url('barang') ?>" class="hover:text-indigo-600 transition">Data Barang</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium"><?= $title ?></span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                 style="background:linear-gradient(135deg,#8b5cf6,#a78bfa)">
                <i class="fas fa-cube text-white text-sm"></i>
            </div>
            <h2 class="font-semibold text-slate-800"><?= $title ?></h2>
        </div>

        <form method="post" action="<?= $barang ? base_url('barang/update/'.$barang['id']) : base_url('barang/store') ?>" class="px-6 py-5">
            <?= csrf_field() ?>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Kode Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode_barang" value="<?= old('kode_barang', $kode) ?>" class="inp font-mono">
                </div>
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Satuan <span class="text-rose-500">*</span></label>
                    <select name="satuan" class="inp">
                        <?php foreach(['sak','pcs','buah','kg','gram','liter','kubik','meter','roll','set','unit'] as $s): ?>
                        <option value="<?= $s ?>" <?= old('satuan',$barang['satuan']??'') === $s ? 'selected':'' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Nama Barang <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_barang" value="<?= old('nama_barang',$barang['nama_barang']??'') ?>"
                       placeholder="Contoh: Semen Portland 40kg" class="inp">
            </div>

            <div class="mb-4">
                <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Kategori</label>
                <select name="id_kategori" class="inp">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach($kategoris as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= old('id_kategori',$barang['id_kategori']??'') == $k['id'] ? 'selected':'' ?>><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Harga Beli <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-slate-400 font-medium">Rp</span>
                        <input type="number" name="harga_beli" min="0"
                               value="<?= old('harga_beli',$barang['harga_beli']??'') ?>"
                               placeholder="0" class="inp pl-9">
                    </div>
                </div>
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Harga Jual <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[12px] text-slate-400 font-medium">Rp</span>
                        <input type="number" name="harga_jual" min="0"
                               value="<?= old('harga_jual',$barang['harga_jual']??'') ?>"
                               placeholder="0" class="inp pl-9">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Stok Awal <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" min="0" value="<?= old('stok',$barang['stok']??0) ?>" class="inp">
                </div>
                <div>
                    <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Stok Minimum
                        <span class="text-slate-400 font-normal text-[11px]">(alert)</span>
                    </label>
                    <input type="number" name="stok_minimum" min="0" value="<?= old('stok_minimum',$barang['stok_minimum']??0) ?>" class="inp">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[12.5px] font-semibold text-slate-600 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)"
                          class="inp resize-none"><?= old('keterangan',$barang['keterangan']??'') ?></textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk text-sm"></i> Simpan Barang
                </button>
                <a href="<?= base_url('barang') ?>"
                   class="text-[13px] text-slate-500 hover:text-slate-700 px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
