<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Controller;

class EventController extends Controller
{
    public function createEvent()
    {
        $eventModel = new EventModel();

        $data = $this->request->getPost();
        if ($this->request->getMethod() === 'post') {
            if ($eventModel->insert($data)) {
                return redirect()->back()->with('success', 'Event created successfully');
            } else {
                return redirect()->back()->with('errors', $eventModel->errors());
            }
        }
    }

    public function showUpcomingEvents()
    {
        $eventModel = new EventModel();
        $data['upcomingEvents'] = $eventModel->findAll(); // Fetch all events from DB
        return view('events', $data);
    }
}
