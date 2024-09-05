<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FileModel;

class FileController extends BaseController
{
    public function download($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($fileId);

        if (!$file) {
            return redirect()->to('/admin')->with('error', 'File not found');
        }

        $filePath = WRITEPATH . 'uploads/' . $file['filename'];

        return $this->response->download($filePath, null);
    }

    public function edit($fileId)
    {
        // Add your edit logic here
    }

    public function delete($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($fileId);

        if (!$file) {
            return redirect()->to('/admin')->with('error', 'File not found');
        }

        // Perform delete operation
        $fileModel->delete($fileId);

        return redirect()->to('/admin')->with('success', 'File deleted successfully');
    }
}
