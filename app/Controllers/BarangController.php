<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;

class BarangController extends BaseController
{
    protected BarangModel $model;
    protected KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->model        = new BarangModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        return view('barang/index', [
            'title'   => 'Data Barang',
            'barangs' => $this->model->getBarangWithKategori(),
        ]);
    }

    public function create()
    {
        return view('barang/form', [
            'title'     => 'Tambah Barang',
            'barang'    => null,
            'kategoris' => $this->kategoriModel->orderBy('nama_kategori')->findAll(),
            'kode'      => $this->model->generateKode(),
        ]);
    }

    public function store()
    {
        if (!$this->model->save($this->request->getPost())) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->model->errors()));
        }
        return redirect()->to('barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = $this->model->find($id);
        if (!$barang) return redirect()->to('barang')->with('error', 'Barang tidak ditemukan.');

        return view('barang/form', [
            'title'     => 'Edit Barang',
            'barang'    => $barang,
            'kategoris' => $this->kategoriModel->orderBy('nama_kategori')->findAll(),
            'kode'      => $barang['kode_barang'],
        ]);
    }

    public function update($id)
    {
        $barang = $this->model->find($id);
        if (!$barang) return redirect()->to('barang')->with('error', 'Barang tidak ditemukan.');

        if (!$this->model->update($id, $this->request->getPost())) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->model->errors()));
        }
        return redirect()->to('barang')->with('success', 'Barang berhasil diperbarui.');
    }

    public function delete($id)
    {
        $barang = $this->model->find($id);
        if (!$barang) return redirect()->to('barang')->with('error', 'Barang tidak ditemukan.');

        $this->model->delete($id);
        return redirect()->to('barang')->with('success', 'Barang berhasil dihapus.');
    }

    public function show($id)
    {
        $barang = $this->model->select('barang.*, kategori.nama_kategori')
                              ->join('kategori', 'kategori.id = barang.id_kategori', 'left')
                              ->find($id);
        if (!$barang) return redirect()->to('barang')->with('error', 'Barang tidak ditemukan.');

        return view('barang/show', ['title' => 'Detail Barang', 'barang' => $barang]);
    }

    // API: ambil harga barang untuk AJAX di form penjualan/stok masuk
    public function getHarga($id)
    {
        $barang = $this->model->find($id);
        if (!$barang) return $this->response->setJSON(['error' => 'Barang tidak ditemukan'])->setStatusCode(404);

        return $this->response->setJSON([
            'id'         => $barang['id'],
            'nama'       => $barang['nama_barang'],
            'satuan'     => $barang['satuan'],
            'harga_beli' => $barang['harga_beli'],
            'harga_jual' => $barang['harga_jual'],
            'stok'       => $barang['stok'],
        ]);
    }
}
