<?php

namespace App\Controllers;

use App\Models\m_auth;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    protected  $m_auth;
    function __construct()
    {
        $this->email = \Config\Services::email();
        $this->db = \Config\Database::connect();
        $this->m_auth = new m_auth();
    }


    //--------------------------------------------------------------------


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

        // $email = $this->request->getvar('email');
        // $pass = $this->request->getvar('password');
        // $cek = $this->m_auth->login($email);

        // dd($email = $cek);

        if (!$val) { //cek falidasi
            return redirect()->to('../auth')->withInput()->with('validation', $val);
        } else {
            $email = $this->request->getvar('email');
            $pass = $this->request->getvar('password');
            $cek = $this->m_auth->login($email);
            if ($cek) { //cek email apa sudah terdaftar

                if ($cek['is_active'] == 1) { // cek apa email sudah aktif


                    if (password_verify($pass, $cek['password'])) {
                        // if ($pass == $cek['password']) { //apakham password benar

                        $suser = [
                            'email' => $cek['email'],
                            'role' => $cek['role'],

                        ];
                        session()->set($suser);
                        session()->setFlashdata('pesan', 'selamat datang');
                        return redirect()->to('../user');
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

    //--------------------------------------------------------------------
    public function register()
    {

        $data = [
            'title' => 'daftar membar',
            'validation' => \config\Services::validation(),

        ];
        return view('auth/register', $data);
    }
    public function regis()
    {
        session();
        $val = $this->validate(
            [
                'full_name' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required|trim|min_length[3]|matches[password2]',
                'password2' => 'required|trim|min_length[3]|matches[password]',
            ],
            [   // Errors
                'email' => [
                    'required' => 'email wajib diisi',
                    'valid_email' => 'email harus berisi alamat email yang valid',
                ]
            ]
        );
        if (!$val) { //cek falidasi
            return redirect()->to('/auth/register')->withInput();
        } else {
            $email = $this->request->getvar('email');
            $token = base64_encode(random_bytes(32));
            $token_user = [
                'email' => $email,
                'token' => $token,
                'date_created' => time(),
            ];
            $this->m_auth->token_user($token_user);
            $this->m_auth->save([
                'username' => '',
                'password' => password_hash($this->request->getvar('password'), PASSWORD_DEFAULT),
                'full_name' => $this->request->getvar('full_name'),
                'email' => $email,
                'phone' => '',
                'role' => '1',
                'last_login' => '',
                'photo' => 'default.jpg',
                'created_at' => Time(),
                'is_active' => '0',
            ]);
            $this->_sendEmail($token, 'verify');
            session()->setFlashdata('pesan', 'Silahkan aktifasi dari email anda');
            return redirect()->to('/auth/register');
        }
    }

    private function _sendEmail($token, $type)
    {
        $this->email->setFrom('jumarimj01@gmail.com', 'toni');
        $this->email->setTo($this->request->getvar('email'));
        // $this->email->setCC('another@another-example.com');
        // $this->email->setBCC('them@their-example.com');
        if ($type == 'verify') {
            $this->email->setSubject('Aktifasi Akun ');
            $this->email->setMessage('Silhkan klik link berikut untuk aktifasi akun anda.<a href="' . base_url() . '/auth/verify?email=' .  $this->request->getvar('email') . '&token=' . urlencode($token) .  '">Atifkan</a>');
        } else {
            $this->email->setSubject('Aktifasi Akun ');
            $this->email->setMessage('Silhkan klik link berikut untuk Melakukan Reset Password akun anda.<a href="' . base_url() . '/auth/VresetPass?email=' .  $this->request->getvar('email') . '&token=' . urlencode($token) .  '">Reset</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
        }
    }
    public function verify()
    {
        $email = $this->request->getvar('email');
        $token = $this->request->getvar('token');
        $cek = $this->m_auth->login($email);
        if ($cek) {
            $tokenCek = $this->m_auth->getToken($token);
            if ($tokenCek) {
                // echo 'bisa';
                $this->db->table('users')->update(['is_active' => 1]);
                session()->setFlashdata('pesan', 'Selamat Email Anda Sudah Aktif Silahakan Login');
                return redirect()->to('/auth');
            } else {
                $this->db->table('user_token')->delete(['email' => $email]);
                $this->db->table('users')->delete(['email' => $email]);
                session()->setFlashdata('pesan', 'Token Aktifasi gagal');
                return redirect()->to('/auth');
            }
        } else {
            session()->setFlashdata('pesan', 'Aktifasi gagal');
            return redirect()->to('/auth');
        }
    }
    //--------------------------------------------------------------------
    public function forgot()
    {
        $data = [
            'title' => 'Lupa Akun',
            'validation' => \config\Services::validation(),
        ];
        return view('auth/forgot', $data);
    }
    public function cekForgot()
    {
        $email = $this->request->getvar('email');
        $cek = $this->m_auth->login($email);
        session();
        if (!$this->validate([
            'email' => 'required|valid_email',
        ], [   // Errors
            'email' => [
                'required' => 'email wajib diisi',
                'valid_email' => 'email harus berisi alamat email yang valid',
            ]
        ],)) {
            return redirect()->to('forgot')->withInput();
        } else {
            if ($cek) {
                // dd($cek);
                $token = base64_encode(random_bytes(32));
                $token_user = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time(),
                ];
                $this->m_auth->token_user($token_user);
                $this->_sendEmail($token, 'forgot');
                session()->setFlashdata('pesan', 'Priksa Email Anda Untuk Reset Password');
                return redirect()->to('/auth');
            } else {
                session()->setFlashdata('pesan', 'Email belum terdaftar');
                return redirect()->to('/auth/forgot');
            }
            // return redirect()->to('forgot')->withInput();
        }
    }

    public function resetPass()
    {
        $email = $this->request->getvar('email');
        $token = $this->request->getvar('token');
        $cek = $this->m_auth->login($email);
        if ($cek) {
            $tokenCek = $this->m_auth->getToken($token);
            if ($tokenCek) {
                // echo 'bisa';
                session()->setFlashdata('pesan', 'Silahkan Mereset Password Anda');
                return redirect()->to('/auth/VresetPass');
            } else {
                // $this->db->table('user_token')->delete(['email' => $email]);
                session()->setFlashdata('pesan', 'Token Tidak Terdaftar Reset password gagal');
                return redirect()->to('/auth/forgot');
            }
        } else {
            session()->setFlashdata('pesan', 'Email Tidak Terdaftar ');
            return redirect()->to('/auth/forgot');
        }
    }
    public function VresetPass()
    {
        $data = [
            'title' => 'Ganti pasword Anda',
            'validation' => \config\Services::validation(),
            'email' => $this->request->getvar('email'),
        ];
        return view('auth/resetPass', $data);
    }
    public function CekResetPass()
    {
        // $pss = $this->request->getvar('password1');
        $email = $this->request->getvar('email');
        // dd($email);
        $pss = password_hash($this->request->getvar('password1'), PASSWORD_DEFAULT);
        if (!$this->validate(
            [
                'password1' => 'required|trim|min_length[3]',
                'password2' => 'required|trim|min_length[3]|matches[password1]',
            ],
        )) {
            $val = \Config\Services::validation();
            return redirect()->to('/auth/VresetPass')->withInput()->with('validation', $val);
        } else {
            $builder = $this->db->table('users');
            $builder->set('password', $pss)->where('email', $email);
            $builder->update();

            $builder = $this->db->table('user_token');
            $builder->set('password', $pss)->where('email', $email);
            $builder->delete();
            session()->setFlashdata('pesan', 'Selamat Pssword Anda Berhasil Di atur ulang');
            return redirect()->to('/auth');
        }
    }
    //--------------------------------------------------------------------
    public function logout()
    {
        // session()->remove('email');
        // session()->remove('role');
        session()->destroy();
        session()->setFlashdata('pesan', 'anda berhasil keluar');
        return redirect()->to('../auth');
    }
}
