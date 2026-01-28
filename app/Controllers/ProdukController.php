<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\StatusModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
        $this->statusModel = new StatusModel();
    }
    public function index()
    {
        $getProduk = $this->produkModel->select('produk.*, kategori.nama_kategori, status.nama_status')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->join('status', 'status.id_status = produk.status_id', 'left')
            ->where('status.nama_status', 'bisa dijual')
            ->findAll();;
        $data = [
            'title' => 'Halaman Produk',
            'subtitle' => 'Daftar Produk',
            'page' => 'produk',
            'produk' => $getProduk
        ];
        return \view('Layouts/wrapper', $data);
    }
    public function create()
    {
        $getKategori = $this->kategoriModel->findAll();
        $getStatus = $this->statusModel->findAll();
        $data = [
            'title' => 'Halaman Tambah Produk',
            'subtitle' => 'Tambah Produk',
            'page' => 'addProduk',
            'kategori' => $getKategori,
            'status' => $getStatus,
        ];
        return \view('Layouts/wrapper', $data);
    }

    public function store()
    {
        $rules = [
            'namaProduk' => [
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus dipilih',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = [
            'nama_produk' => $this->request->getPost('namaProduk'),
            'harga' => $this->request->getPost('harga'),
            'kategori_id' => $this->request->getPost('kategori'),
            'status_id' => $this->request->getPost('status')
        ];
        $this->produkModel->insert($data);
        return \redirect('/')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $getProdukId = $this->produkModel->find($id);
        $getKategori = $this->kategoriModel->findAll();
        $getStatus = $this->statusModel->findAll();
        $data = [
            'title' => 'Halaman Edit Produk',
            'subtitle' => 'Edit Produk',
            'page' => 'EditProduk',
            'produk' => $getProdukId,
            'kategori' => $getKategori,
            'status' => $getStatus,
        ];
        return \view('Layouts/wrapper', $data);
    }

    public function update($id)
    {
        $rules = [
            'namaProduk' => [
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'numeric',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus dipilih',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $getProdukId = $this->produkModel->find($id);
        if (!$getProdukId) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan');
        }
        $data = [
            'nama_produk' => $this->request->getPost('namaProduk'),
            'harga' => $this->request->getPost('harga'),
            'kategori_id' => $this->request->getPost('kategori'),
            'status_id' => $this->request->getPost('status')
        ];
        $this->produkModel->update($id, $data);
        return \redirect('/')->with('success', 'Produk berhasil diubah');
    }

    public function delete($id)
    {
        $getProdukId = $this->produkModel->find($id);
        if (!$getProdukId) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan');
        }
        $this->produkModel->delete($id);
        return \redirect('/')->with('success', 'Produk berhasil dihapus');
    }
}
