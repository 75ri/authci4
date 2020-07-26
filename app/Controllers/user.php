<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        echo (session()->get('email'));

        if (session()->getFlashdata('pesan')) {
            echo ' masuk halaman user';
            echo session()->getFlashdata('pesan');
        }
    }

    //--------------------------------------------------------------------


    //--------------------------------------------------------------------

}
