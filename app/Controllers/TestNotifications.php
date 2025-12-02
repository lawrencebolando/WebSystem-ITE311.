<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

/**
 * Test controller to help debug notifications
 * Remove this file after testing
 */
class TestNotifications extends Controller
{
    /**
     * Test page to check notifications system
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();

        // Check if table exists
        $db = \Config\Database::connect();
        $tableExists = $db->tableExists('notifications');

        // Get notifications
        $notifications = [];
        $unreadCount = 0;
        if ($tableExists) {
            $notifications = $notificationModel->getNotificationsForUser($userId, 10);
            $unreadCount = $notificationModel->getUnreadCount($userId);
        }

        // Try to create a test notification
        $testCreated = false;
        $testError = '';
        if ($tableExists) {
            try {
                $testData = [
                    'user_id' => $userId,
                    'message' => 'Test notification created at ' . date('Y-m-d H:i:s'),
                    'is_read' => 0
                ];
                $testId = $notificationModel->createNotification($testData);
                $testCreated = ($testId !== false);
            } catch (\Exception $e) {
                $testError = $e->getMessage();
            }
        }

        $data = [
            'title' => 'Notifications Test',
            'table_exists' => $tableExists,
            'user_id' => $userId,
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'test_created' => $testCreated,
            'test_error' => $testError
        ];

        return view('test_notifications', $data);
    }
}

