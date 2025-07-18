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
            'username' => $user['name'], // Using 'name' field from the model
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

        return view('Templates/Dashboard', $data);
    }
}