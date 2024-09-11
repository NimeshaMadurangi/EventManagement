<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\FileModel;
use App\Models\EventModel;

class DashboardController extends BaseController
{
    public function admin()
    {
        // Load models
        $userModel = new UserModel();
        $fileModel = new FileModel();
        $eventModel = new EventModel();

        // Get user and file counts
        $data['userCount'] = $userModel->countAllResults();
        $data['fileCount'] = $fileModel->countAllResults();
        $data['eventCount'] = $eventModel->countAllResults();

        // Get search query if any
        $searchQuery = $this->request->getGet('search');
        if ($searchQuery) {
            // Filter files based on the search query and limit to 12 results
            $data['uploads'] = $fileModel->like('filename', $searchQuery)
                                         ->orderBy('created_at', 'DESC')
                                         ->limit(12)
                                         ->findAll();
        } else {
            // Get the latest 12 files
            $data['uploads'] = $fileModel->orderBy('created_at', 'DESC')
                                         ->limit(12)
                                         ->findAll();
        }

        // Pass the search query and uploads to the view
        $data['searchQuery'] = $searchQuery;

        // Load the view with data
        return view('admindashboard', $data);
    }

    public function manager()
    {
        // Load models
        $fileModel = new FileModel();
        $eventModel = new EventModel();

        // Get user and file counts
        $data['fileCount'] = $fileModel->countAllResults();
        $data['eventCount'] = $eventModel->countAllResults();

        // Get search query if any
        $searchQuery = $this->request->getGet('search');
        if ($searchQuery) {
            // Filter files based on the search query and limit to 12 results
            $data['uploads'] = $fileModel->like('filename', $searchQuery)
                                         ->orderBy('created_at', 'DESC')
                                         ->limit(12)
                                         ->findAll();
        } else {
            // Get the latest 12 files
            $data['uploads'] = $fileModel->orderBy('created_at', 'DESC')
                                         ->limit(12)
                                         ->findAll();
        }

        // Pass the search query and uploads to the view
        $data['searchQuery'] = $searchQuery;



        return view('managerdashboard', $data);
    }

    public function photographer()
    {
        return view('photographerdashboard');
    }

    public function fbteam()
    {
        return view('fbteamdashboard');
    }
}
