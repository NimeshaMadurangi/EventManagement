<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class FileController extends BaseController
{
    public function download($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($fileId);

        if (!$file) {
            return redirect()->to('/admin')->with('error', 'File not found');
        }

        $filePath = FCPATH . 'uploads/' . $file['foldername'] . '/' . $file['filename'];

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
        $session = session();
        $username = $session->get('username');

        if (!$username) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        $folderName = $this->request->getPost('foldername');
        $description = $this->request->getPost('description');

        if (empty($folderName)) {
            return redirect()->back()->with('error', 'Folder name is required.');
        }

        $uploadPath = FCPATH . 'uploads/' . $folderName;
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0777, true)) {
                return redirect()->back()->with('error', 'Failed to create directory.');
            }
        }

        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newFileName = $file->getRandomName();
                    $file->move($uploadPath, $newFileName);

                    $fileModel->save([
                        'filename' => $newFileName,
                        'foldername' => $folderName,
                        'description' => $description,
                        'username' => $username,
                        'status' => 0,
                    ]);
                }
            }

            return redirect()->to('/admin/admindashboard')->with('success', 'Files uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('fileid');
        $status = $this->request->getPost('status');

        log_message('debug', "Updating status for file ID $id to $status");

        $fileModel = new FileModel();

        if ($fileModel->updateStatus($id, $status)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update status']);
        }
    }

    public function approvedUploads()
    {
        $fileModel = new FileModel();
        $data['uploads'] = $fileModel->where('status', 1)->findAll();

        return view('approve', $data);
    }
    
}
