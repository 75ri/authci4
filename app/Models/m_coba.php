<?php

namespace App\Models;

use CodeIgniter\Model;

class m_coba extends Model
{
    protected $table = 'coba';
    // // protected $useTimestamps = true;
    // protected $allowedFields = ['id', 'username', 'password', 'email', 'full_name', 'phone', 'role', 'last_login', 'photo', 'created_at', 'is_active'];

    // function login($email)
    // {
    //     return $this->db->table('users')
    //         ->where(array('email' => $email))
    //         ->get()->getRowArray();
    //     // dd($cek['email']);
    // }

    public function saveProduct($nama)
    {
        $query = $this->db->table('coba')->insert($nama);
        return $query;
    }

    public function get_menu()
    {
        $role = session('role');
        return  $this->db->table('user_menu')
            ->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id ')
            ->where(['user_access_menu', 'role_id' => $role])
            ->get()->getResultArray();
    }
}
