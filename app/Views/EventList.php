<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E2A5E;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Events</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('/admin/admindashboard'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('listusers'); ?>">User List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('approved-uploads'); ?>">Accept List</a>
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
                        <a href="<?= base_url('eventlist'); ?>">
                        <p class="card-text fs-1"><?= esc($eventCount); ?></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex mb-4">
            <a href="<?= base_url('eventForm'); ?>" class="btn btn" style="background-color: #55679C; color: white;">Create Event</a>
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
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();
            // Add your logout functionality here
            // For example: window.location.href = '<?= base_url('logout'); ?>';
        });
    </script>
</body>
</html>
