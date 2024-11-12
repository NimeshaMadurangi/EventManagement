<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLB Event Management</title>
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
        h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #ffffff;
            padding: 10px;
        }
        .navbar-vertical {
            width: 220px;
            height: 100vh;
            background-color: #746cc0;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 5px;
        }
        .navbar-nav {
            list-style-type: none;
            padding: 5px;
            margin-bottom: 200px;
        }
        .navbar-nav .nav-item {
            position: relative;
        }
        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .navbar-nav .nav-link i {
            margin-right: 10px;
        }
        .navbar-nav .nav-link.active {
            border-radius: 0.25rem;
        }
        .navbar-nav .nav-link:hover {
            background-color: #e6e6fa;
        }
        .navbar-nav .nav-link:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.5);
        }
        .navbar-vertical .nav-link {
            color: white;
            padding: 15px;
        }
        .navbar-vertical .nav-link:hover {
            background-color: #e6e6fa;
        }
        .navbar-vertical .navbar-brand {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-logo {
            width: 120px;
            height: 120px;
            margin-left: 40px;
            display: block;
            margin-top: 30px;
            margin-bottom: 60px;
        }
        .register-card, .upload-card {
            background-color: white;
            color: #746cc0;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
            height: 430px;
        }
        .register-card h2, .upload-card h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }
        .form-control {
            background-color: white;
            color: #808080;
            border: 1px solid #746cc0;
            border-radius: 5px;
        }
        .form-control::placeholder {
            color: #808080;
        }
        .form-control:focus {
            background-color: #e6e6fa;
            border-color: #1d2951;
            color: black;
            box-shadow: 0 0 0 0.2rem rgba(138, 43, 226, 0.25);
        }
        .btn-primary {
            background-color: #746cc0;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #7851a9;
        }
        .upload-form-group {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
        }
        .upload-form-group > div {
            flex: 1;
        }
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-vertical">
    <img class="navbar-logo" src="app\Views\images\dlb.png" alt="Logo">
        <h3>Manage Events</h3>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('/admin/admindashboard'); ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('listusers'); ?>">
                    <i class="fas fa-users"></i> Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('approved-uploads'); ?>">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('gallery'); ?>">
                    <i class="fas fa-photo-video"></i> Gallery
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="logoutLink">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div class="content">
        <div class="container mt-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
            <?php endif; ?>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="register-card">
                        <h2 class="text-center">Register User</h2>
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('errors') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="<?= site_url('user/createuser'); ?>">
                            <?= csrf_field(); ?>
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required aria-label="Username">
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required aria-label="Email">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required aria-label="Password">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required aria-label="Confirm Password">
                            </div>
                            <div class="mb-3">
                                <select name="role" class="form-control" required aria-label="User Role">
                                    <option value="" disabled selected>Select a role</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="photographer">Photographer</option>
                                    <option value="fbteam">FB Team</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="upload-card">
                    <h2 class="text-center mb-4">Create Event</h2>
                        <form action="/storeEvent" method="post">
                            <!-- CSRF Token Placeholder -->
                            <?= csrf_field() ?>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Enter event name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="date" class="form-control" id="eventdate" name="eventdate" required>
                                </div>
                                <div class="mb-3">
                                    <input type="time" class="form-control" id="time" name="time" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="photographer" name="photographer" placeholder="Enter Photographer Name" required>
                                </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                </div>
            </div>

            <div class="container mt-4">
                <h2>Upcoming Events</h2>
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

            <div class="row">
                <?php if (!empty($folders)): ?>
                    <?php foreach ($folders as $folderName => $folderFiles) : ?>
                        <div class="col-md-3 mb-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa-solid fa-folder fa-3x" style="color: #55679C;"></i>
                                    <h5 class="card-title mt-3"><?= esc($folderName); ?></h5>
                                    <a href="<?= base_url('folder/' . urlencode($folderName)); ?>" class="btn btn-sm" style="background-color: #55679C; color: white;">Open Folder</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No folders found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
