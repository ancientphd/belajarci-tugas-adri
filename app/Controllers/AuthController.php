<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DiskonModel;

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where('username', $username)->first();

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        $sessionData = [
                            'username'    => $dataUser['username'],
                            'role'        => $dataUser['role'],
                            'isLoggedIn'  => true
                        ];

                        $diskonModel = new DiskonModel();
                        $diskon = $diskonModel->where('tanggal', date('Y-m-d'))->first();

                        if ($diskon) {
                            $sessionData['diskon_nominal'] = $diskon['nominal'];
                            $sessionData['diskon_tanggal'] = $diskon['tanggal'];
                        }
                        session()->set($sessionData);

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Password salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username tidak ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }
        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
