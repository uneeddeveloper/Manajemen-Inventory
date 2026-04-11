<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_transaksi', 'tanggal_jual', 'nama_pembeli',
        'total_harga', 'bayar', 'kembalian', 'keterangan',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal_jual' => 'required|valid_date',
        'total_harga'  => 'permit_empty|decimal',
        'bayar'        => 'permit_empty|decimal',
        'kembalian'    => 'permit_empty|decimal',
    ];
    protected $validationMessages = [
        'tanggal_jual' => [
            'required'   => 'Tanggal penjualan wajib diisi.',
            'valid_date' => 'Format tanggal tidak valid.',
        ],
    ];
    protected $skipValidation = false;

    // Ambil semua penjualan dengan total item
    public function getAllWithCount()
    {
        return $this->select('penjualan.*, COUNT(detail_penjualan.id) as jumlah_item')
                    ->join('detail_penjualan', 'detail_penjualan.id_penjualan = penjualan.id', 'left')
                    ->groupBy('penjualan.id')
                    ->orderBy('penjualan.tanggal_jual', 'DESC')
                    ->findAll();
    }

    // Rekap penjualan per hari (untuk dashboard)
    public function rekapHarian($tanggal = null)
    {
        $tanggal = $tanggal ?? date('Y-m-d');
        return $this->selectSum('total_harga', 'total')
                    ->selectCount('id', 'jumlah_transaksi')
                    ->where('tanggal_jual', $tanggal)
                    ->first();
    }

    // Rekap penjualan per bulan
    public function rekapBulanan($bulan = null, $tahun = null)
    {
        $bulan = $bulan ?? date('m');
        $tahun = $tahun ?? date('Y');

        return $this->select('DATE(tanggal_jual) as tanggal, SUM(total_harga) as total, COUNT(id) as jumlah_transaksi')
                    ->where('MONTH(tanggal_jual)', $bulan)
                    ->where('YEAR(tanggal_jual)', $tahun)
                    ->groupBy('DATE(tanggal_jual)')
                    ->orderBy('tanggal_jual', 'ASC')
                    ->findAll();
    }

    // Generate nomor transaksi otomatis: PJ-YYYYMMDD-XXX
    public function generateNoTransaksi()
    {
        $prefix = 'PJ-' . date('Ymd') . '-';
        $last   = $this->like('no_transaksi', $prefix, 'after')
                       ->orderBy('id', 'DESC')
                       ->first();

        if (!$last) {
            return $prefix . '001';
        }

        $num = (int) substr($last['no_transaksi'], -3);
        return $prefix . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    }
}
