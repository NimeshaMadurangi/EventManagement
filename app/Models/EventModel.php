<?php

namespace App\Models;

class EventModel extends BaseModel
{
    protected $table            = 'event';
    protected $primaryKey       = 'eventid';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Allowed fields
    protected $allowedFields    = ['eventname', 'eventdate', 'time', 'location', 'username', 'photographername'];

    protected bool $allowEmptyInserts = false;

    // Validation
    protected $validationRules = [
        'eventname' => 'required|min_length[3]|max_length[255]',
        'eventdate' => 'required|valid_date[Y-m-d]',
        'time'      => 'required|valid_date[H:i]',
        'location'  => 'required|max_length[255]',
        'username'  => 'required|min_length[3]|max_length[100]',
        'photographername' => 'required|min_length[3]|max_length[100]', // Added validation for photographername
    ];

    protected $validationMessages = [
        'eventname' => [
            'required'   => 'Event name is required',
            'min_length' => 'Event name must be at least 3 characters long',
            'max_length' => 'Event name cannot exceed 255 characters'
        ],
        'eventdate' => [
            'required'   => 'Event date is required',
            'valid_date' => 'Event date must be in the format Y-m-d (e.g., 2023-09-05)'
        ],
        'time' => [
            'required'   => 'Event time is required',
            'valid_date' => 'Event time must be in the format H:i (e.g., 14:30)'
        ],
        'location' => [
            'required'   => 'Location is required',
            'max_length' => 'Location cannot exceed 255 characters'
        ],
        'username' => [
            'required'   => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 100 characters'
        ],
        'photographername' => [
            'required'   => 'Photographer name is required',
            'min_length' => 'Photographer name must be at least 3 characters long',
            'max_length' => 'Photographer name cannot exceed 100 characters',
        ]
    ];
}
