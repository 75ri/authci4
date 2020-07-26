<?php

namespace App\Controllers;

use App\Models\m_auth;

class Auth extends BaseController
{
    protected  $m_auth;
    function __construct()
    {
        $this->m_auth = new m_auth();
    }




    public function index()
    {
        session();
        $data = [
            'title' => 'Login',
            'validation' => \config\Services::validation(),
        ];

        return view('auth/login', $data);
    }

    public function login()
    {
        helper('form');
        // $val = null;
        if ($this->request->getMethod() == 'post') { //jika tombol belum di pencet
            $val = $this->validate(
                [
                    'email' => 'required|valid_email',
                ],
                [   // Errors
                    'email' => [
                        'required' => 'email wajib diisi',
                        'valid_email' => 'email harus berisi alamat email yang valid',
                    ]
                ]
            );
        }

        $email = $this->request->getvar('email');
        $pass = $this->request->getvar('password');
        $cek = $this->m_auth->login($email);

        // dd($email = $cek);

        if (!$val) { //cek falidasi
            return redirect()->to('../auth')->withInput()->with('validation', $val);
        } else {
            $email = $this->request->getvar('email');
            $pass = $this->request->getvar('password');
            $cek = $this->m_auth->login($email);
            if ($cek) { //cek email apa sudah terdaftar

                if ($cek['is_active'] == 1) { // cek apa email sudah aktif

                    if ($pass == $cek['password']) { //apakham password benar

                        $data = [
                            'email' => $cek['email'],
                            'role' => $cek['role']
                        ];

                        session()->set($data);



                        // echo 'Selamat datang';

                        // session()->setFlashdata('pesan', 'Password anda salah');
                        return redirect()->to('user');
                    } else {
                        session()->setFlashdata('pesan', 'Password anda salah');
                        return redirect()->to('../auth');
                    }
                } else {
                    session()->setFlashdata('pesan', 'Email anda belum di aktifkan');
                    return redirect()->to('../auth');
                }

                // session()->setFlashdata('pesan', 'proses selanjutnya');
                // return redirect()->to('../auth');
            } else {
                session()->setFlashdata('pesan', 'email belum terdaftar');
                return redirect()->to('../auth');
            }
        }
    }
    public function logout()
    {
        session()->setTempdata('email');
        session()->setTempdata('password');
        session()->setFlashdata('sukses', 'anda berhasil kluar');
        return redirect()->to('home');
    }
    //--------------------------------------------------------------------
    public function register()
    {
        $data = [
            'title' => 'daftar membar',

        ];
        return view('auth/register', $data);
    }

    public function regis()
    {

        // dd($this->request->getVar());
        $this->m_auth->save([
            'username' => '',
            'password' => password_hash($this->request->getvar('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getvar('full_name'),
            'email' => $this->request->getvar('email'),
            'phone' => '',
            'role' => '1',
            'last_login' => '',
            'photo' => 'default.jpg',
            'created_at' => '0',
            'is_active' => '1',
        ]);

        // $this->m_auth->insert($_POST);
        return redirect()->to('auth');
    }

    //--------------------------------------------------------------------

}
