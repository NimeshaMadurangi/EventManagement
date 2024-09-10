<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #7C93C3, #ffdde1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .upload-card {
            border-radius: 20px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .upload-card .form-control {
            border-radius: 30px;
            padding: 10px 15px;
        }
        button {
            background: #1E2A5E;
            border: none;
            border-radius: 30px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }
        button:hover {
            background: #7C93C3;
        }
        button.cancel-btn {
            background: #dc3545; 
            color: #fff;
        }
        button.cancel-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="upload-card">
        <h2 class="text-center mb-4">Upload File</h2>
        <form action="/upload" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="filename" class="form-label">File Name</label>
                <input type="text" class="form-control" id="filename" name="filename" placeholder="Enter file name" required>
            </div>
            <div class="mb-3">
                <label for="foldername" class="form-label">Folder Name</label>
                <input type="text" class="form-control" id="foldername" name="foldername" placeholder="Enter folder name" required>
            </div>
            <div class="mb-3">
                <label for="files" class="form-label">Select File</label>
                <input type="file" class="form-control" id="files" name="files[]" accept="image/*,video/*" multiple required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a description..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
            <button type="button" class="btn cancel-btn" onclick="redirectToDashboard()">Cancel</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToDashboard() {
            window.location.href = '/admin/admindashboard';
        }
    </script>
</body>
</html>
