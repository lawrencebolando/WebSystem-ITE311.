<!-- app/Views/announcements.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 40px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .announcement {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .buttons {
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #a71d2a;
        }
        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            background: #28a745;
            padding: 8px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-btn:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>

    <h1>Latest Announcements</h1>

    <!-- Add Button -->
    <a href="/add-announcement" class="add-btn">+ Add New Announcement</a>

    <?php if (!empty($announcements) && is_array($announcements)): ?>
        <?php foreach ($announcements as $row): ?>
            <div class="announcement">
                <h2><?= esc($row['title']) ?></h2>
                <p><?= esc($row['content']) ?></p>
                <small>Posted on: <?= esc($row['date_posted']) ?></small>

                <div class="buttons">
                    <a href="/edit-announcement/<?= $row['id'] ?>" class="btn">Edit</a>
                    <a href="/delete-announcement/<?= $row['id'] ?>" class="btn btn-delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No announcements found.</p>
    <?php endif; ?>

</body>
</html>
