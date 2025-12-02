<!DOCTYPE html>
<html>
<head>
    <title>Create Test Notification</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Create Test Notification</h1>
    
    <?php
    // Check if logged in
    if (!session()->get('isLoggedIn')) {
        echo '<div class="error">You must be logged in. <a href="' . base_url('login') . '">Login here</a></div>';
        exit;
    }
    
    $userId = session()->get('user_id');
    $db = \Config\Database::connect();
    
    // Check if table exists
    $tableExists = $db->tableExists('notifications');
    
    if (!$tableExists) {
        echo '<div class="error">';
        echo '<h2>❌ Notifications table does NOT exist!</h2>';
        echo '<p>You need to create the table first. Run this SQL in phpMyAdmin:</p>';
        echo '<pre style="background: #f4f4f4; padding: 15px; border: 1px solid #ddd;">';
        echo "CREATE TABLE IF NOT EXISTS `notifications` (\n";
        echo "  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,\n";
        echo "  `user_id` INT(11) UNSIGNED NOT NULL,\n";
        echo "  `message` VARCHAR(255) NOT NULL,\n";
        echo "  `is_read` TINYINT(1) DEFAULT 0,\n";
        echo "  `created_at` DATETIME NOT NULL,\n";
        echo "  PRIMARY KEY (`id`),\n";
        echo "  KEY `user_id` (`user_id`),\n";
        echo "  KEY `is_read` (`is_read`),\n";
        echo "  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE\n";
        echo ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        echo '</pre>';
        echo '<p><a href="' . base_url('login') . '">Go back to login</a></p>';
        echo '</div>';
        exit;
    }
    
    // Try to create notification
    if (isset($_GET['create'])) {
        try {
            $notificationModel = new \App\Models\NotificationModel();
            $testData = [
                'user_id' => $userId,
                'message' => 'Test notification created at ' . date('Y-m-d H:i:s'),
                'is_read' => 0
            ];
            $id = $notificationModel->createNotification($testData);
            
            if ($id) {
                echo '<div class="success">';
                echo '<h2>✅ SUCCESS! Notification created!</h2>';
                echo '<p>Notification ID: ' . $id . '</p>';
                echo '<p><strong>Now refresh your dashboard page and check the bell icon!</strong></p>';
                echo '<p><a href="' . base_url('student/dashboard') . '">Go to Student Dashboard</a></p>';
                echo '</div>';
            } else {
                echo '<div class="error">Failed to create notification. Check database.</div>';
            }
        } catch (\Exception $e) {
            echo '<div class="error">';
            echo '<h2>❌ ERROR creating notification:</h2>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
    } else {
        // Show current status
        $notificationModel = new \App\Models\NotificationModel();
        $notifications = $notificationModel->getNotificationsForUser($userId, 10);
        $unreadCount = $notificationModel->getUnreadCount($userId);
        
        echo '<div style="background: #e7f3ff; padding: 15px; border: 1px solid #b3d9ff; margin-bottom: 20px;">';
        echo '<h2>✅ Table exists! System is ready.</h2>';
        echo '<p><strong>Your User ID:</strong> ' . $userId . '</p>';
        echo '<p><strong>Current Notifications:</strong> ' . count($notifications) . '</p>';
        echo '<p><strong>Unread Count:</strong> ' . $unreadCount . '</p>';
        echo '</div>';
        
        if (count($notifications) > 0) {
            echo '<h3>Your Notifications:</h3>';
            echo '<ul>';
            foreach ($notifications as $notif) {
                $status = $notif['is_read'] == 0 ? '<span style="color: red;">UNREAD</span>' : '<span style="color: green;">READ</span>';
                echo '<li>' . htmlspecialchars($notif['message']) . ' - ' . $status . ' (' . $notif['created_at'] . ')</li>';
            }
            echo '</ul>';
        }
        
        echo '<hr>';
        echo '<h3>Create Test Notification</h3>';
        echo '<p>Click the button below to create a test notification:</p>';
        echo '<a href="?create=1"><button>Create Test Notification</button></a>';
        echo '<p><a href="' . base_url('student/dashboard') . '">Go to Student Dashboard</a></p>';
    }
    ?>
</body>
</html>

