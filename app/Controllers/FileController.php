<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\UserModel;

class FileController extends BaseController
{
    public function download($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($fileId);

        if (!$file) {
            return redirect()->to('/admin')->with('error', 'File not found');
        }

        $filePath = FCPATH . 'uploads/' . $file['foldername'] . '/' . $file['filename']; // Changed path to FCPATH

        if (!is_file($filePath)) {
            return redirect()->to('/admin')->with('error', 'File does not exist');
        }

        return $this->response->download($filePath, null);
    }

    public function uploadForm()
    {
        return view('uploadForm'); 
    }

    public function upload()
    {
        $fileModel = new FileModel();

        // Get the current session
        $session = session();
        $username = $session->get('username'); 

        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        // Retrieve form inputs
        $fileName = $this->request->getPost('filename');
        $folderName = $this->request->getPost('foldername');
        $description = $this->request->getPost('description');

        if (empty($folderName)) {
            return redirect()->back()->with('error', 'Folder name is required.');
        }

        // Change path to save in project directory under public/uploads
        $uploadPath = FCPATH . 'uploads/' . $folderName;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); 
        }

        // Handle file upload
        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate a random file name and move file
                    $newFileName = $file->getRandomName();
                    $file->move($uploadPath, $newFileName);

                    // Save file details in the database
                    $fileModel->save([
                        'filename' => $newFileName,
                        'foldername' => $folderName,
                        'description' => $description,
                        'username' => $username,
                    ]);
                }
            }

            return redirect()->to('/admin/admindashboard')->with('success', 'Files uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }
}
