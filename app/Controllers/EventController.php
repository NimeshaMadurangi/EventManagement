<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use CodeIgniter\I18n\Time;

class EventController extends BaseController
{
    // Display the admin dashboard with event details
    public function eventlist()
    {
        $eventModel = new EventModel();

        // Fetch the total count of events
        $eventCount = $eventModel->countAllResults();

        // Fetch upcoming events (events where the date is today or in the future)
        $today = date('Y-m-d');
        $upcomingEvents = $eventModel->where('eventdate >=', $today)
                                     ->orderBy('eventdate', 'ASC')
                                     ->findAll();

        // Pass the data to the view
        $data = [
            'eventCount' => $eventCount,
            'upcomingEvents' => $upcomingEvents
        ];

        return view('eventlist', $data);
    }

    // Display the event creation form
    public function eventForm()
    {
        return view('eventCreate');
    }

    // Store the event data
    public function storeEvent()
    {
        $eventModel = new EventModel();

        $validation = $this->validate([
            'eventname' => 'required|max_length[255]',
            'eventdate' => 'required|valid_date',
            'time' => 'required',
            'location' => 'required|max_length[255]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'eventname' => $this->request->getPost('eventname'),
            'eventdate' => $this->request->getPost('eventdate'),
            'time' => $this->request->getPost('time'),
            'location' => $this->request->getPost('location'),
        ];

        $eventModel->save($data);

        return redirect()->to('/admin/admindashboard')->with('success', 'Event created successfully.');
    }
}
