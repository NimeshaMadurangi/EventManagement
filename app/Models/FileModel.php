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
    protected $allowedFields    = ['filename', 'foldername', 'username', 'description', 'status'];

    // Dates
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Validation rules
    protected $validationRules  = [
        'filename'   => 'required|min_length[3]|max_length[255]',
        'foldername' => 'required|min_length[2]|max_length[255]',
        'username'   => 'required|min_length[3]|max_length[100]',
        'description'=> 'max_length[500]',
        'status'     => 'required|in_list[0,1]' // Assuming status is an integer (0 or 1)
    ];

    protected $validationMessages = [
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
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list'  => 'Status must be 0 or 1'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Update the status of a file record.
     *
     * @param int $id File ID
     * @param int $status New status (0 or 1)
     * @return bool True on success, False on failure
     */
    public function updateStatus($id, $status)
    {
        // Validate the status
        if (!in_array($status, [0, 1])) {
            return false;
        }

        // Update the status
        return $this->update($id, ['status' => $status]);
    }
}
