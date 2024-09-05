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
    protected $allowedFields    = ['filename', 'foldername', 'username'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'filename' => 'required|min_length[3]|max_length[225]',
        'foldername' => 'required|min_length[2]|max_length[225]',
        'username' => 'require|min_length[3]|max_length[100]'
    ];
    protected $validationMessages   = [
        'filename' => [
            'required' => 'File name is required',
            'min_length' => 'File name must be at least 3 characters long',
            'max_length' => 'File name cannot exceed 225 characters'
        ],
        'foldername' => [
            'required' => 'Folder name is required',
            'min_length' => 'Folder name must be at least 2 characters long',
            'max_length' => 'Folder name cannot exceed 225 characters'
        ],
        'username' => [
            'required'   => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 100 characters'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
