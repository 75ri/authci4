<?php

namespace App\Controllers;

use App\Models\m_coba;

class Coba extends BaseController
{

    protected  $m_coba;
    function __construct()
    {
        helper('date');
        $this->m_coba = new m_coba();
    }
    public function index()
    {
        $data = [
            'title' => '75ri',
            'nama' => $this->m_coba->findAll(),
            // 'menu' =>  $this->m_menu->get_menu(),
            // 'subMenu' =>  $this->m_menu->get_menuSubMenu(),
        ];

        return view('coba', $data);
    }
}
