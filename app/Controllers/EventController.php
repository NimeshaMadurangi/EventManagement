<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    // Display the event creation form
    public function eventForm()
    {
        $userModel = new UserModel();

        // Fetch all photographers and videographers from the database
        $photographers = $userModel->where('role', 'photographer')->findAll();

        // Pass the lists to the view
        return view('eventCreate', [
            'photographers' => $photographers
        ]);
    }

    // Handle event creation
    public function storeEvent()
    {
        $eventModel = new EventModel();

        // Get the current session
        $session = session();
        $username = $session->get('username'); // Retrieve username from session

        // Check if the user is logged in
        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        // Define validation rules
        $rules = [
            'eventname' => 'required|min_length[3]|max_length[255]',
            'eventdate' => 'required|valid_date[Y-m-d]',
            'time'      => 'required|regex_match[/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/]', // Validate time in HH:MM format
            'location'  => 'required|min_length[3]|max_length[255]',
            'photographer'  => 'required|min_length[3]|max_length[100]'
        ];

        // Validate the form inputs
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Prepare the data for insertion
        $data = [
            'eventname' => $this->request->getPost('eventname'),
            'eventdate' => $this->request->getPost('eventdate'),
            'time'      => $this->request->getPost('time'),
            'location'  => $this->request->getPost('location'),
            'username'  => $username,
            'photographer'  => $this->request->getPost('photographer')
        ];

        // Attempt to insert the data into the database
        if ($eventModel->save($data)) {
            return redirect()->to('/admin/admindashboard')->with('success', 'Event created successfully.');
        } else {
            // Log the error details
            log_message('error', 'Event creation failed: ' . print_r($eventModel->errors(), true));
            return redirect()->back()->withInput()->with('error', 'Unable to create event. Please try again.');
        }
    }

    public function eventList()
    {
        return view('eventlist');
    }
}
