<?php

namespace App\Controllers;

class Admin extends BaseController
{
    // protected  $m_menu;
    function __construct()
    {
    }
    //--------------------------------------------------------------------
    public function index()
    {
        $role = session()->get('email');
        $data = [
            'title' => 'Admin',
            'user' => $role,
        ];
        return view('tamplate/admin', $data);
    }
}
