<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .profile-card {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        .form-control {
            border-radius: 5px;
        }
        button {
            background: #1E2A5E;
            border: none;
            padding: 10px;
            width: 100%;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }
        button:hover {
            background: #7C93C3;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <h2 class="text-center mb-4">User Profile</h2>

        <!-- Display success/error messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/updateProfile" method="post">
            <!-- CSRF Token -->
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank if unchanged)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
            </div>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
