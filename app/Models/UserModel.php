<?php

namespace App\Models;

class UserModel extends BaseModel
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'role'];

    protected bool $allowEmptyInserts = false;

    // Validation
    protected $validationRules      = [
        'username' => 'required|min_length[3]|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'role'     => 'required|in_list[admin,manager,photographer,fbteam]',
    ];
    protected $validationMessages   = [
        'username' => [
            'required'   => 'Username is required',
            'is_unique'  => 'Username already exists',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 100 characters',
        ],
        'email' => [
            'required'     => 'Email is required',
            'valid_email'  => 'Email address is not valid',
            'is_unique'    => 'Email already exists',
        ],
        'password' => [
            'required'    => 'Password is required',
            'min_length'  => 'Password must be at least 8 characters long',
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list'  => 'Role must be one of the following: admin, manager, photographer, fbteam',
        ],
    ];
}
