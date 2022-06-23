<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'email';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'email', 'alias', 'password', 'level', 'uid'];



    function isExist($email)
    {
        $result = $this->find($email);
        if ($result == NULL) {
            return false;
        } else {
            return true;
        }
    }

    function insertUser($data = array())
    {
        if ($this->isExist($data['email']) == NULL) {
            $this->insert($data);
            return true;
        } else {
            return false;
        }
    }

    function getUser($email)
    {
        return $this->find($email);
    }
}
