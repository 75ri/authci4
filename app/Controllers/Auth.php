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

        // $input = 'asu';

        return view('auth/login');
    }
    public function login()
    {
        dd($this->request->getVar());
    }

    //--------------------------------------------------------------------
    public function register()
    {
        return view('auth/register');
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
