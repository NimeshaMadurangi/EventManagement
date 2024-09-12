<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Uploads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E2A5E;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Approved Uploads</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/admin/admindashboard'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('approved-uploads'); ?>">Approved Uploads</a>
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

        <!-- Approved Uploads Gallery -->
        <div class="row">
            <?php if (!empty($files)): ?>
                <?php foreach ($files as $row): ?>
                    <div class="col-md-3 mb-4">
                        <div class="gallery-item card">
                            <div class="card-body d-flex flex-column">
                                <?php
                                $filePath = base_url('uploads' . $row['foldername'] . '/' . $row['filename']);
                                $fileExtension = strtolower(pathinfo($row['filename'], PATHINFO_EXTENSION));
                                ?>

                                <h5 class="card-title mt-2"><?= esc($row['filename']); ?></h5>
                                <p class="card-text"><?= esc($row['foldername']); ?></p>
                                <p class="card-text"><?= esc($row['username']); ?></p>
                                <p class="card-text text-muted"><?= esc($row['created_at']); ?></p>

                                <a href="<?= base_url('download/' . $row['id']); ?>" class="btn btn-sm btn-primary">Download</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No approved uploads available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('logout'); ?>'; // Implement the logout URL
        });
    </script>
</body>
</html>
