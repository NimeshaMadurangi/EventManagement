<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use CodeIgniter\HTTP\ResponseInterface;

class EventController extends BaseController
{
    // Display the event creation form
    public function eventForm()
    {
        return view("eventCreate");
    }

    public function storeEvent()
    {
        // Instantiate EventModel
        $eventModel = new EventModel();

        // Get the current session
        $session = session();
        $username = $session->get('username');

        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        // Retrieve form inputs
        $eventName = $this->request->getPost('eventname');
        $eventDate = $this->request->getPost('eventdate');
        $time = $this->request->getPost('time');
        $location = $this->request->getPost('location');

        // Validate the required fields
        if (empty($eventName)) {
            return redirect()->back()->with('error', 'Event name is required.');
        }

        // Save event details in the database
        $eventModel->save([
            'eventname' => $eventName,
            'eventdate' => $eventDate,
            'time' => $time,
            'location' => $location,
            'username' => $username,
        ]);

        return redirect()->to('/admin/admindashboard')->with('success', 'Event created successfully.');
    }
}
