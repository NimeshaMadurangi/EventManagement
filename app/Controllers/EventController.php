<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\UserModel;

class EventController extends BaseController
{
    // Display the event creation form
    public function eventForm()
    {
        $userModel = new UserModel();

        // Fetch all photographers from the database
        try {
            $photographers = $userModel->where('role', 'photographer')->findAll();
        } catch (\Exception $e) {
            // Log an error message for troubleshooting
            log_message('error', 'Failed to fetch photographers from the database: ' . $e->getMessage());
            $photographers = []; // Set to an empty array if fetching fails
        }

        // Pass the photographers list to the view
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
            'eventname'    => 'required|min_length[3]|max_length[255]',
            'eventdate'    => 'required|valid_date[Y-m-d]',
            'time'         => 'required|regex_match[/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/]', // Validate time in HH:MM format
            'location'     => 'required|min_length[3]|max_length[255]',
            'photographer'  => 'required|min_length[3]|max_length[100]'
        ];

        // Validate the form inputs
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare the data for insertion
        $data = [
            'eventname'    => $this->request->getPost('eventname'),
            'eventdate'    => $this->request->getPost('eventdate'),
            'time'         => $this->request->getPost('time'),
            'location'     => $this->request->getPost('location'),
            'username'     => $username, // Organizer's username
            'photographer' => $this->request->getPost('photographer') // Corrected field name
        ];

        // Try inserting data into the database
        try {
            if ($eventModel->save($data)) {
                return redirect()->to('/admin/admindashboard')->with('success', 'Event created successfully.');
            } else {
                // Handle the case where save returns false
                return redirect()->back()->withInput()->with('error', 'Failed to create event. Please try again.');
            }
        } catch (\Exception $e) {
            // Log any error if the event creation fails
            log_message('error', 'Event creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Unable to create event. Please try again.');
        }
    }

    // Display a list of events
    public function eventList()
    {
        $eventModel = new EventModel();
        $session = session();

        // Retrieve the list of events from the database
        try {
            $events = $eventModel->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Failed to fetch events: ' . $e->getMessage());
            $events = []; // Return an empty array if fetching fails
        }

        return view('eventList', [
            'events'   => $events,
            'username' => $session->get('username')
        ]);
    }
}
