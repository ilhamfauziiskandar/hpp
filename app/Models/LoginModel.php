<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'username', 'password', 'password1', 'alamat', 'tmpt_lahir', 'tgl_lahir'];

    public function login($userid)
    {
        return $this->db->table('user')
            ->where(array('username' => $userid))
            ->get();
    }
}
