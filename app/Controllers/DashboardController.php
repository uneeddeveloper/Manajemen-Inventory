<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\SupplierModel;
use App\Models\DetailPenjualanModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $barangModel        = new BarangModel();
        $penjualanModel     = new PenjualanModel();
        $supplierModel      = new SupplierModel();
        $detailPenjualanModel = new DetailPenjualanModel();

        $rekapHarian = $penjualanModel->rekapHarian();

        $stokMinimumCount = $barangModel->where('stok_minimum >', 0)
                                        ->where('stok <= stok_minimum', null, false)
                                        ->countAllResults();

        $stokMenipis = (new BarangModel())
                        ->select('barang.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id = barang.id_kategori', 'left')
                        ->where('barang.stok_minimum >', 0)
                        ->where('barang.stok <= barang.stok_minimum', null, false)
                        ->limit(5)->findAll();

        $data = [
            'title'             => 'Dashboard',
            'total_barang'      => $barangModel->countAll(),
            'total_supplier'    => $supplierModel->countAll(),
            'penjualan_hari_ini'  => $rekapHarian['total'] ?? 0,
            'transaksi_hari_ini'  => $rekapHarian['jumlah_transaksi'] ?? 0,
            'stok_minimum'      => $stokMinimumCount,
            'barang_terlaris'   => $detailPenjualanModel->getBarangTerlaris(5),
            'transaksi_terbaru' => $penjualanModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'stok_menipis'      => $stokMenipis,
        ];

        return view('dashboard/index', $data);
    }
}
