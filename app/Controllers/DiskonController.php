<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('failed', 'Akses ditolak.');
        }

        $diskonModel = new DiskonModel();
        $data['diskon'] = $diskonModel->orderBy('tanggal', 'DESC')->findAll();

        return view('v_diskon', $data);
    }

    public function save()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $diskonModel = new DiskonModel();

        $rules = [
            'tanggal' => 'required|is_unique[diskon.tanggal]',
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('failed', $this->validator->listErrors());
        }

        $diskonModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $diskonModel = new DiskonModel();

        $rules = [
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('failed', $this->validator->listErrors());
        }

        $diskonModel->update($id, [
            'nominal' => $this->request->getPost('nominal'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diupdate.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $diskonModel = new DiskonModel();
        $diskonModel->delete($id);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }
}
