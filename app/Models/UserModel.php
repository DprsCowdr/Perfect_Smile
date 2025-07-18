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
        'username', 'email', 'password', 'user_type', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[user.username,id,{id}]|alpha_numeric_punct',
        'email' => 'required|valid_email|is_unique[user.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'user_type' => 'required|in_list[admin,doctor,staff,patient,guest]',
        'status' => 'in_list[active,inactive,suspended]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 50 characters',
            'is_unique' => 'This username is already taken',
            'alpha_numeric_punct' => 'Username can only contain letters, numbers, and basic punctuation'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'user_type' => [
            'required' => 'User type is required',
            'in_list' => 'Invalid user type selected'
        ],
        'status' => [
            'in_list' => 'Invalid status selected'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

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
     * Authenticate user login with email or username
     */
    public function authenticate($emailOrUsername, $password)
    {
        // Try to find user by email first
        $user = $this->where('email', $emailOrUsername)->first();
        
        // If not found by email, try by username
        if (!$user) {
            $user = $this->where('username', $emailOrUsername)->first();
        }
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    /**
     * Create new user with password confirmation validation
     */
    public function createUser($data)
    {
        // Validate confirm password
        if (isset($data['confirm_password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                $this->errors = ['confirm_password' => 'Passwords do not match'];
                return false;
            }
            // Remove confirm_password before saving
            unset($data['confirm_password']);
        }

        // Set default values
        if (!isset($data['user_type'])) {
            $data['user_type'] = 'patient';
        }
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        return $this->save($data);
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->where('status', 'active')->first();
    }

    /**
     * Get user by username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->where('status', 'active')->first();
    }

    /**
     * Get users by type
     */
    public function getUsersByType($userType)
    {
        return $this->where('user_type', $userType)->where('status', 'active')->findAll();
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Search users by username or email
     */
    public function searchUsers($searchTerm)
    {
        return $this->groupStart()
                    ->like('username', $searchTerm)
                    ->orLike('email', $searchTerm)
                    ->groupEnd()
                    ->where('status', 'active')
                    ->findAll();
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'admins' => $this->where('user_type', 'admin')->countAllResults(),
            'doctors' => $this->where('user_type', 'doctor')->countAllResults(),
            'staff' => $this->where('user_type', 'staff')->countAllResults(),
            'patients' => $this->where('user_type', 'patient')->countAllResults(),
        ];
    }
}