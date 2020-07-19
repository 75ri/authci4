<?php

namespace App\Models;

use CodeIgniter\Model;

class m_auth extends Model
{

    protected $table = 'users';
    // protected $useTimestamps = true;
    protected $allowedFields = ['id', 'username', 'password', 'email', 'full_name', 'phone', 'role', 'last_login', 'photo', 'created_at', 'is_active'];
}
