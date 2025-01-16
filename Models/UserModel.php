<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $useTimestamps = false;

    protected $allowedFields = ['username', 'email', 'password', 'created_at', 'updated_at'];

    // Method to check if the user is already registered by email
    public function isUserAlreadyRegisteredByEmail($email)
    {
        return $this->where('email', $email)->first();  
    }

    // Method to update user details
    public function updateUserDetails($data, $user_id)
    {
        return $this->update($user_id, $data);
    }

    // Method to insert new user
    public function insertUserDetails($data)
    {
        return $this->insert($data);
    }
    
}


