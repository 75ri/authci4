<?php

namespace App\Controllers;

use App\Models\m_auth;

class User extends BaseController
{
    function __construct()
    {
        $this->m_auth = new m_auth();
    }
    public function index()
    {
        $email = $this->m_auth->login((session()->get('email')));
        $data = [
            'title' => 'User',
            'user' => $email,
        ];
        return view('dashboard/user', $data);
        // echo (session()->get('email'));
    }

    //Ganti password--------------------------------------------------------------------
    public function gantipass()
    {
        session();
        $email = $this->m_auth->login((session()->get('email')));
        $data = [
            'title' => 'User',
            'user' => $email,
            'validation' => \config\Services::validation(),
        ];
        return view('dashboard/gantipass', $data);
    }

    public function ubahpass()
    {
        $user = $this->m_auth->login((session()->get('email')));

        if (!$this->validate([ //cek falidasi
            'password' => 'required|trim',
            'passwordBaru' => 'required|trim|min_length[3]|matches[passwordUlangi]',
            'passwordUlangi' => 'required|trim|min_length[3]|matches[passwordUlangi]',
        ], [   // Errors
            'password' => [
                'required' => 'Sandi wajib diisi',
            ],
            'passwordBaru' => [
                'required' => 'Sandi wajib diisi',
                'min_length' => 'Sandi minimal 3 huruf',
                'matches' => 'Password tidak cocok'
            ], 'passwordUlangi' => [
                'required' => 'Sandi wajib diisi',
                'min_length' => 'Sandi minimal 3 huruf',
                'matches' => 'Password tidak cocok'
            ],
        ])) {
            $val = \Config\Services::validation();
            return redirect()->to('gantipass')->withInput()->with('validation', $val);
        } else {
            $pass = $this->request->getvar('password');
            $gantipass = $this->request->getvar('passwordBaru');
            if ($user['password'] == $pass) {
                if ($user['password'] == $gantipass) {
                    session()->setFlashdata('pesan', 'Sandi Tidak Boleh mengunakan sandi yang lama ');
                    return redirect()->to('gantipass');
                } else {
                    session()->setFlashdata('pesan', 'Sandi Berhasil Di ubah');
                    return redirect()->to('gantipass');
                }
            } else {
                session()->setFlashdata('pesan', 'Sandi SALAH');
                return redirect()->to('gantipass');
            }
        }
    }
    //--------------------------------------------------------------------

    public function dataUser()
    {
    }
    //--------------------------------------------------------------------

}
