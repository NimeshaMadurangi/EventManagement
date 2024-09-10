<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EventController extends BaseController
{
    // Display the event creation form
    public function eventForm()
    {
        return view('eventCreate');
    }

    public function storeEvent()
    {
        $eventModel = new EventModel();

        $session = session();
        $username = $session->get('username');

        // Check if the user is logged in
        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        // Validate event data
        $rules = [
            'eventname' => 'required|min_length[3]|max_length[255]',
            'eventdate' => 'required|valid_date',
            'time'      => 'required|valid_time',
            'location'  => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'eventname' => $this->request->getPost('eventname'),
            'eventdate' => $this->request->getPost('eventdate'),
            'time'      => $this->request->getPost('time'),
            'location'  => $this->request->getPost('location'),
        ];

        if ($eventModel->insert($data)) {
            return redirect()->to('/admin/dashboard')->with('success', 'Event created successfully.');
        } else {
            log_message('error', print_r($eventModel->errors(), true));
            return redirect()->to('/eventForm')->with('error', 'Unable to create event. Please try again.');
        }
    }
}
