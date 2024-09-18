<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .gallery-item {
            border: 2px solid #ddd;
            border-radius: .25rem;
            overflow: hidden;
            margin-bottom: 1rem;
            height: 450px;
            display: flex;
            flex-direction: column;
        }
        .gallery-item img, .gallery-item video {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-item .card-body {
            padding: .75rem;
            flex: 1;
            overflow: hidden;
        }
        .gallery-item .btn {
            margin-right: .5rem;
        }
        .navbar-dark .navbar-nav .nav-link.active {
            background-color: #55679C;
            border-radius: .25rem;
        }
        @media (max-width: 768px) {
            .gallery-item {
                margin-bottom: .5rem;
            }
        }
        .toggle-switch {
            position: relative;
            width: 40px;
            height: 20px;
            display: inline-block;
        }
        .toggle-switch input {
            display: none;
        }
        .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 34px;
            transition: 0.4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #4CAF50;
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E2A5E;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manager Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('/admin/admindashboard'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/approved-uploads'); ?>">Accept List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logoutLink">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Success and Error Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card text-white" style="background-color: #7C93C3;">
                    <div class="card-body d-flex flex-column align-items-center">
                        <i class="fa-solid fa-file fa-2x mb-2"></i>
                        <h5 class="card-title">Events</h5>
                        <p class="card-text fs-1"><?= esc($eventCount); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white" style="background-color: #7C93C3;">
                    <div class="card-body d-flex flex-column align-items-center">
                        <i class="fa-solid fa-file fa-2x mb-2"></i>
                        <h5 class="card-title">Files</h5>
                        <p class="card-text fs-1"><?= esc($fileCount); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex mb-4">
            <a href="<?= base_url('uploadForm'); ?>" class="btn" style="background-color: #55679C; color: white; margin-right: 10px;">Upload</a>
            <a href="<?= base_url('eventForm'); ?>" class="btn" style="background-color: #55679C; color: white;">Create Event</a>
        </div>

        <!-- Search Form -->
        <div class="mb-4">
            <form method="get" action="<?= base_url('admin'); ?>">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search uploads..." value="<?= esc($searchQuery); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>

        <!-- Upcoming Events Section -->
<div class="container mt-4">
    <h3>Upcoming Events</h3>
    <div class="row mb-4">
        <?php if (!empty($upcomingEvents)): ?>
            <?php foreach ($upcomingEvents as $event) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-white" style="background-color: #55679C;">
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

        <!-- Uploads Gallery -->
        <div class="row">
            <?php foreach ($uploads as $row) : ?>
                <div class="col-md-3 mb-4">
                    <div class="gallery-item card">
                        <div class="card-body d-flex flex-column">
                            <?php 
                            $filePath = base_url('uploads/' . $row['foldername'] . '/' . $row['filename']);
                            $fileExtension = strtolower(pathinfo($row['filename'], PATHINFO_EXTENSION));
                            ?>

                            <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])): ?>
                                <img src="<?= $filePath; ?>" alt="Preview">
                            <?php elseif (in_array($fileExtension, ['mp4', 'avi', 'mov'])): ?>
                                <video controls>
                                    <source src="<?= $filePath; ?>" type="video/<?= $fileExtension; ?>">
                                    Your browser does not support the video tag.
                                </video>
                            <?php else: ?>
                                <p>Unsupported file type</p>
                            <?php endif; ?>

                            <h5 class="card-title mt-2"><?= esc($row['filename']); ?></h5>
                            <p class="card-text"><?= esc($row['foldername']); ?></p>
                            <p class="card-text"><?= esc($row['username']); ?></p>
                            <p class="card-text text-muted"><?= esc($row['created_at']); ?></p>

                            <div class="mt-auto text-end">
                                <a href="<?= base_url('download/' . $row['fileid']); ?>" class="btn btn-sm" style="background-color: #254336; color: white; margin-bottom: 10px;">Download</a>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="approval-toggle" data-id="<?= $row['fileid']; ?>" <?= $row['status'] ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('logout'); ?>'; // Implement the logout URL here
        });

        $(document).on('change', '.approval-toggle', function() {
            var fileId = $(this).data('id');
            var isChecked = $(this).is(':checked');
            var status = isChecked ? 1 : 0; // Assuming 1 for approved and 0 for disapproved

        $.ajax({
            url: '<?= base_url('file/updateStatus'); ?>', // Ensure this URL matches your route
            method: 'POST',
            data: { fileid: fileId, status: status },
            success: function(response) {
                if (!response.success) {
                    alert('Failed to update status');
                }
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });
    </script>
</body>
</html>
