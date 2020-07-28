<?php

namespace App\Controllers;

use App\Models\m_coba;

class Coba extends BaseController
{

    protected  $m_coba;
    function __construct()
    {
        $this->m_coba = new m_coba();
    }
    public function index()
    {
        $data = [
            'title' => '75ri',
            'nama' => $this->m_coba->findAll(),
        ];


        if ($this->request->getvar('nama')) {
            $nama = ['nama' => $this->request->getvar('nama')];
            // var_dump($nama);
            $this->m_coba->saveProduct($nama);
        } else {
            // echo 'tidak ada';
        }
        return view('coba', $data);
    }
}
