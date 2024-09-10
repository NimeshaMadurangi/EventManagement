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
            // Filter files based on the search query
            $data['uploads'] = $fileModel->like('filename', $searchQuery)->findAll();
        } else {
            // Get all files if no search query
            $data['uploads'] = $fileModel->findAll();
        }

        // Pass the search query and uploads to the view
        $data['searchQuery'] = $searchQuery;

        // Load the view with data
        return view('admindashboard', $data);
    }

    public function manager()
    {
        return view('managerdashboard');
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
