<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        return view('splash');
    }

    public function register()
    {
        return view('register');
    }

    public function createuser()
    {
        $userModel = new UserModel();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirmPassword' => 'required|matches[password]',
            'role' => 'required|in_list[admin,manager,photographer,fbteam]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Store plain text password
            'role' => $this->request->getPost('role'),
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Account created successfully. Please log in.');
        } else {
            log_message('error', print_r($userModel->errors(), true));
            return redirect()->back()->withInput()->with('error', 'Unable to create account. Please try again.');
        }
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $userModel = new UserModel();
        
        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Find user by email
        $user = $userModel->where('email', $email)->first();

        // Check if user exists and password is correct
        if ($user && $user['password'] === $password) {
            // Set user session
            $this->setUserSession($user);

            // Redirect based on user role
            switch ($user['role']) {
                case 'admin':
                    return redirect()->to('/admin/admindashboard');
                case 'manager':
                    return redirect()->to('/manager/managerdashboard');
                case 'photographer':
                    return redirect()->to('/photographer/photographerdashboard');
                case 'fbteam':
                    return redirect()->to('/fbteam/fbteamdashboard');
                default:
                    return redirect()->to('/login')->with('error', 'Invalid role.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    private function setUserSession($user)
    {
        $sessionData = [
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ];
        session()->set($sessionData);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function listUsers()
    {
        // Load the UserModel
        $userModel = new UserModel();
        
        // Get all users
        $data['users'] = $userModel->findAll();

        // Pass the users data to the view
        return view('listusers', $data);
    }

    public function deleteUser($userId)
    {
        // Load the UserModel
        $userModel = new UserModel();
        
        // Find the user
        $user = $userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/listusers')->with('error', 'User not found');
        }
        
        // Perform delete operation
        $userModel->delete($userId);
        
        return redirect()->to('/listusers')->with('success', 'User deleted successfully');
    }
}
