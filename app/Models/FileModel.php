<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table            = 'file';
    protected $primaryKey       = 'fileid';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Allowed fields
    protected $allowedFields    = ['filename', 'foldername', 'username', 'description'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules
    protected $validationRules      = [
        'filename'   => 'required|min_length[3]|max_length[255]',
        'foldername' => 'required|min_length[2]|max_length[255]',
        'username'   => 'required|min_length[3]|max_length[100]',
        'description'=> 'max_length[500]'  // Optional description field
    ];

    protected $validationMessages   = [
        'filename' => [
            'required'   => 'File name is required',
            'min_length' => 'File name must be at least 3 characters long',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'foldername' => [
            'required'   => 'Folder name is required',
            'min_length' => 'Folder name must be at least 2 characters long',
            'max_length' => 'Folder name cannot exceed 255 characters'
        ],
        'username' => [
            'required'   => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 100 characters'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
