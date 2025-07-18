<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_type', 'name', 'address', 'email', 'date_of_birth',
        'gender', 'password', 'phone', 'created_at', 'updated_at', 'occupation', 'nationality', 'age', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'email' => 'required|valid_email',
        'password' => 'required|min_length[6]',
        'name' => 'required|min_length[2]',
        'user_type' => 'required|in_list[admin,doctor,patient,staff,guest]',
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters long'
        ],
        'user_type' => [
            'required' => 'User type is required',
            'in_list' => 'Invalid user type'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Authenticate user login with email or username
     */
    public function authenticate($emailOrUsername, $password)
    {
        // Try to find user by email first
        $user = $this->where('email', $emailOrUsername)->first();
        
        // If not found by email, try by name (username)
        if (!$user) {
            $user = $this->where('name', $emailOrUsername)->first();
        }
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    /**
     * Hash password before saving
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }
        
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get users by type
     */
    public function getUsersByType($userType)
    {
        return $this->where('user_type', $userType)->findAll();
    }
} 