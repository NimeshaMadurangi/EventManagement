<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    // Common fields
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $usernameField = 'username';  // Field to store the username

    // Automatically fill the 'username' field
    protected $beforeInsert = ['addUsernameBeforeInsert'];
    protected $beforeUpdate = ['addUsernameBeforeUpdate'];

    /**
     * Add the current username before insert
     *
     * @param array $data
     * @return array
     */
    protected function addUsernameBeforeInsert(array $data)
    {
        if (isset($data['data'])) {
            // Assuming the username is stored in session
            $data['data'][$this->usernameField] = session()->get('username');  // Get the current username from session
        }

        return $data;
    }

    /**
     * Add the current username before update
     *
     * @param array $data
     * @return array
     */
    protected function addUsernameBeforeUpdate(array $data)
    {
        if (isset($data['data'])) {
            // Assuming the username is stored in session
            $data['data'][$this->usernameField] = session()->get('username');
        }

        return $data;
    }
}
