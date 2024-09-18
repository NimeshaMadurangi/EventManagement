<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Uploads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .share-icon {
            font-size: 20px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <!-- Approved Uploads Gallery -->
    <div class="container my-4">
        <div class="row">
            <?php if (!empty($uploads)): ?>
                <?php foreach ($uploads as $row) : ?>
                    <div class="col-md-3 mb-4">
                        <div class="gallery-item card position-relative">
                            <div class="card-body d-flex flex-column">
                                <?php 
                                $filePath = base_url('uploads/' . esc($row['foldername']) . '/' . esc($row['filename']));
                                $fileExtension = strtolower(pathinfo($row['filename'], PATHINFO_EXTENSION));
                                ?>

                                <!-- Display Image or Video -->
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
                                <p class="card-text">Uploaded by: <?= esc($row['username']); ?></p>
                                <p class="card-text text-muted">Date: <?= esc($row['created_at']); ?></p>
                            </div>

                            <!-- Share Icon -->
                            <i class="fas fa-share-alt share-icon" onclick="shareContent('<?= base_url('uploads/' . esc($row['foldername']) . '/' . esc($row['filename'])); ?>')"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No approved uploads available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Logout link functionality
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url('logout'); ?>';
        });

        // Share function
        function shareContent(filePath) {
            if (navigator.share) {
                navigator.share({
                    title: 'Check out this upload',
                    url: filePath
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch((error) => {
                    console.log('Error sharing:', error);
                });
            } else {
                alert('Your browser does not support sharing.');
            }
        }
    </script>
</body>
</html>
