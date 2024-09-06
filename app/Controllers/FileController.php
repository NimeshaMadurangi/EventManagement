<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;

class FileController extends BaseController
{
    // Method to handle file download
    public function download($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($fileId);

        if (!$file) {
            return redirect()->to('/admin')->with('error', 'File not found');
        }

        $filePath = WRITEPATH . 'uploads/' . $file['foldername'] . '/' . $file['filename'];

        if (!is_file($filePath)) {
            return redirect()->to('/admin')->with('error', 'File does not exist');
        }

        return $this->response->download($filePath, null);
    }

    // Method to display the form for uploading
    public function uploadForm()
    {
        return view('uploadForm');  // Adjust this to match your view's name
    }

    // Method to handle file upload
    public function upload()
    {
        $fileModel = new FileModel();

        // Retrieve the current session
        $session = session();
        $username = $session->get('username'); // Ensure that 'username' is set in the session

        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        // Get form input
        $fileName = $this->request->getPost('filename');
        $folderName = $this->request->getPost('foldername');
        $description = $this->request->getPost('description');

        // Check for folder name
        if (empty($folderName)) {
            return redirect()->back()->with('error', 'Folder name is required.');
        }

        // Create the folder if it doesn't exist
        $uploadPath = WRITEPATH . 'uploads/' . $folderName;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Create the folder with proper permissions
        }

        // Handle file upload
        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate a random file name and move it to the folder
                    $newFileName = $file->getRandomName();
                    $file->move($uploadPath, $newFileName);

                    // Save file details into the database
                    $fileModel->save([
                        'filename' => $newFileName,
                        'foldername' => $folderName,
                        'description' => $description,
                        'username' => $username,  // Save the current user's username
                    ]);
                }
            }
            return redirect()->to('/admin/admindashboard')->with('success', 'Files uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    // Other methods like download, edit, update, delete...
}
