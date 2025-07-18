<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        helper('form');
    }

    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('Templates/Login');
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $emailOrUsername = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Try to authenticate using email or username
        $user = $this->userModel->authenticate($emailOrUsername, $password);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Invalid email/username or password');
        }

        // Set session data
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'], // Using 'name' field from the model
            'email' => $user['email'],
            'user_type' => $user['user_type'],
            'logged_in' => true
        ];

        $this->session->set($sessionData);

        return redirect()->to('/dashboard')->with('success', 'Login successful!');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out successfully');
    }

    public function register()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('Templates/Register');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[user.username]|alpha_numeric_punct',
            'email'    => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        $messages = [
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
            'confirm_password' => [
                'required' => 'Please confirm your password',
                'matches' => 'Passwords do not match'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'user_type' => 'patient', // Default user type
            'status' => 'active'
        ];

        if ($this->userModel->save($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful! Please login with your credentials.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to access dashboard');
        }

        $data = [
            'user' => [
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email'),
                'user_type' => $this->session->get('user_type')
            ]
        ];

        // Route to appropriate dashboard based on user type
        $userType = $this->session->get('user_type');
        
        switch ($userType) {
            case 'admin':
                return view('Admin/AdminDashboard', $data);
            case 'doctor':
                return view('Doctor/DoctorDashboard', $data);
            case 'staff':
                return view('Staff/StaffDashboard', $data);
            case 'patient':
                return view('Patient/PatientDashboard', $data);
            default:
                return view('Templates/Dashboard', $data); // Fallback to generic dashboard
        }
    }
}