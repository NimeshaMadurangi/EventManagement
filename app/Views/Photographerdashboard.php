<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <style>
        .navbar-dark-red {
            background-color: #8B0000;
        }
        .card {
            border-radius: 10px;
        }
        .card-body {
            text-align: center;
            position: relative;
        }
        .card-body i {
            font-size: 2.5rem;
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0.2;
        }
        .folder-card {
            background-color: #00563f !important;
            color: white;
            margin-bottom: 20px;
        }
        .file-card {
            background-color: #55679C !important;
            color: white;
            margin-bottom: 20px;
        }
        .search-bar {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .table thead th {
            border-bottom: 2px solid #dee2e6;
        }
        .thumbnail {
            width: 100px;
            height: auto;
        }
        .card-custom-bg {
            background-color: #00563f !important;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E2A5E;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Photographer Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Upcoming Events Section -->
    <div class="container mt-4">
        <h3>Upcoming Events</h3>
        <div class="row mb-4">
            <?php if (!empty($upcomingEvents)): ?>
                <?php foreach ($upcomingEvents as $event) : ?>
                    <div class="col-md-3 mb-4">
                        <div class="card card-custom-bg"> <!-- Applying the custom background class -->
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($event['eventname']); ?></h5>
                                <p class="card-text"><?= esc($event['location']); ?></p>
                                <p class="card-text"><strong>Date:</strong> <?= esc($event['eventdate']); ?></p>
                                <p class="card-text"><strong>Time:</strong> <?= esc($event['time']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="container mt-4">
        <div class="d-flex mb-4">
            <a href="<?= base_url('uploadForm'); ?>" class="btn btn" style="background-color: #55679C; color: white; margin-right: 10px;">Upload New Files</a>
        </div>
    </div>

    <!-- User Folders Section -->
    <div class="container mt-4">
        <h3>Your Folders</h3>
        <div class="row">
            <?php if (!empty($folders)): ?>
                <?php foreach ($folders as $foldername => $files): ?>
                    <div class="col-md-12 mb-4">
                        <div class="card folder-card">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($foldername); ?></h5>
                            </div>
                        </div>

                        <!-- Files in this folder -->
                        <div class="row">
                            <?php foreach ($files as $file): ?>
                                <div class="col-md-3">
                                    <div class="card file-card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($file['filename']); ?></h5>
                                            <p class="card-text"><?= esc($file['description']); ?></p>
                                            <p class="card-text"><strong>Status:</strong> <?= $file['status'] == 1 ? 'Active' : 'Inactive'; ?></p>
                                            <a href="<?= base_url('file/' . $file['fileid']); ?>" class="btn btn-light">View File</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No folders or files found.</p>
            <?php endif; ?>
        </div>
    </div>
    
</body>
</html>
