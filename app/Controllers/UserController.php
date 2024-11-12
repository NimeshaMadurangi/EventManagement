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

        if (!$this->validate($userModel->validationRules)) {
            log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
        ];

        try {
            if ($userModel->insert($data)) {
                return redirect()->to('/login')->with('success', 'Account created successfully. Please log in.');
            } else {
                log_message('error', 'Database insert failed: ' . json_encode($userModel->errors()));
                return redirect()->back()->withInput()->with('error', 'Unable to create account. Please try again.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
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

    //profile
    public function profile()
    {
        $session = session();
        $username = $session->get('username'); // Retrieve the logged-in user's username

        // Fetch user details from the database
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        return view('profile', [
            'user' => $user,
        ]);
    }

    // Handle profile update
    public function updateProfile()
    {
        $session = session();
        $username = $session->get('username'); // Retrieve the logged-in user's username

        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Prepare data for update
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        // Update password only if it's provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Update the user profile in the database
        $userModel = new UserModel();
        try {
            $userModel->update($session->get('id'), $data);
            return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            log_message('error', 'Profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to update profile. Please try again.');
        }
    }
}