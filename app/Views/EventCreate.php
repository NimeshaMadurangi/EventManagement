<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
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
            width: 600px;
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
        <h2 class="text-center mb-4">Create Event</h2>
        <form action="/storeEvent" method="post">
            <!-- CSRF Token Placeholder -->
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="eventname" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Enter event name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="eventdate" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="eventdate" name="eventdate" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
                </div>
            </div>
            <button type="submit">Create Event</button>
        </form>
        <a href="/admin/admindashboard">
            <button type="button" class="cancel-btn mt-3">Cancel</button>
        </a>
    </div>
</body>
</html>
