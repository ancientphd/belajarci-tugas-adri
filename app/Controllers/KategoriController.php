<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    // Menampilkan semua kategori
    public function index()
    {
        $data['kategori'] = $this->kategori->findAll();
        return view('v_kategori', $data);
    }

    // Menyimpan kategori baru
    public function create()
    {
        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        $this->kategori->insert($dataForm);

        return redirect()->to('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Mengedit kategori
    public function edit($id)
    {
        $dataKategori = $this->kategori->find($id);

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->kategori->update($id, $dataForm);

        return redirect()->to('kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori
    public function delete($id)
    {
        $this->kategori->delete($id);

        return redirect()->to('kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
