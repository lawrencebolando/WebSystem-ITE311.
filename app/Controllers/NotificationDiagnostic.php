<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class NotificationDiagnostic extends Controller
{
    /**
     * Comprehensive diagnostic page
     * Access: http://localhost/ITE311-BOLANDO/notification-diagnostic
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        $isLoggedIn = session()->get('isLoggedIn');
        
        $diagnostics = [];
        
        // Test 1: Check if logged in
        $diagnostics['logged_in'] = [
            'status' => $isLoggedIn ? 'pass' : 'fail',
            'message' => $isLoggedIn ? 'User is logged in' : 'User is NOT logged in',
            'value' => $isLoggedIn ? 'YES' : 'NO'
        ];
        
        // Test 2: Check user ID
        $diagnostics['user_id'] = [
            'status' => $userId ? 'pass' : 'fail',
            'message' => $userId ? 'User ID found: ' . $userId : 'User ID NOT found in session',
            'value' => $userId ?? 'N/A'
        ];
        
        // Test 3: Check if table exists
        $tableExists = $db->tableExists('notifications');
        $diagnostics['table_exists'] = [
            'status' => $tableExists ? 'pass' : 'fail',
            'message' => $tableExists ? 'Notifications table exists' : 'Notifications table DOES NOT exist',
            'value' => $tableExists ? 'YES' : 'NO'
        ];
        
        // Test 4: Check notifications in database
        $notificationCount = 0;
        $unreadCount = 0;
        if ($tableExists && $userId) {
            try {
                $notificationModel = new NotificationModel();
                $allNotifications = $notificationModel->where('user_id', $userId)->findAll();
                $notificationCount = count($allNotifications);
                $unreadCount = $notificationModel->getUnreadCount($userId);
                
                $diagnostics['notifications_in_db'] = [
                    'status' => $notificationCount > 0 ? 'pass' : 'warning',
                    'message' => $notificationCount > 0 
                        ? "Found $notificationCount notification(s) in database" 
                        : 'No notifications found in database for this user',
                    'value' => $notificationCount
                ];
                
                $diagnostics['unread_count'] = [
                    'status' => $unreadCount > 0 ? 'pass' : 'info',
                    'message' => $unreadCount > 0 
                        ? "$unreadCount unread notification(s)" 
                        : 'No unread notifications',
                    'value' => $unreadCount
                ];
            } catch (\Exception $e) {
                $diagnostics['notifications_in_db'] = [
                    'status' => 'fail',
                    'message' => 'Error checking notifications: ' . $e->getMessage(),
                    'value' => 'ERROR'
                ];
            }
        } else {
            $diagnostics['notifications_in_db'] = [
                'status' => 'skip',
                'message' => 'Cannot check notifications (table missing or not logged in)',
                'value' => 'N/A'
            ];
        }
        
        // Test 5: Test API endpoint
        $apiTest = $this->testApiEndpoint();
        $diagnostics['api_endpoint'] = $apiTest;
        
        // Test 6: Test creating notification
        $createTest = null;
        if ($tableExists && $userId) {
            try {
                $notificationModel = new NotificationModel();
                $testData = [
                    'user_id' => $userId,
                    'message' => 'Diagnostic test notification - ' . date('Y-m-d H:i:s'),
                    'is_read' => 0
                ];
                $testId = $notificationModel->createNotification($testData);
                
                $createTest = [
                    'status' => $testId ? 'pass' : 'fail',
                    'message' => $testId 
                        ? "Successfully created test notification (ID: $testId)" 
                        : 'Failed to create test notification',
                    'value' => $testId ? 'SUCCESS' : 'FAILED',
                    'notification_id' => $testId
                ];
            } catch (\Exception $e) {
                $createTest = [
                    'status' => 'fail',
                    'message' => 'Error creating notification: ' . $e->getMessage(),
                    'value' => 'ERROR'
                ];
            }
        } else {
            $createTest = [
                'status' => 'skip',
                'message' => 'Cannot create notification (table missing or not logged in)',
                'value' => 'N/A'
            ];
        }
        $diagnostics['create_notification'] = $createTest;
        
        // Get all notifications for display
        $notifications = [];
        if ($tableExists && $userId) {
            try {
                $notificationModel = new NotificationModel();
                $notifications = $notificationModel->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit(10)
                    ->findAll();
            } catch (\Exception $e) {
                // Ignore
            }
        }
        
        $data = [
            'title' => 'Notification Diagnostic',
            'diagnostics' => $diagnostics,
            'notifications' => $notifications,
            'userId' => $userId,
            'isLoggedIn' => $isLoggedIn
        ];
        
        return view('notification_diagnostic', $data);
    }
    
    /**
     * Test the API endpoint
     */
    private function testApiEndpoint()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        $userId = session()->get('user_id');
        
        if (!$isLoggedIn || !$userId) {
            return [
                'status' => 'skip',
                'message' => 'Cannot test API (not logged in)',
                'value' => 'N/A'
            ];
        }
        
        try {
            // Simulate API call
            $notificationModel = new NotificationModel();
            $db = \Config\Database::connect();
            
            if (!$db->tableExists('notifications')) {
                return [
                    'status' => 'fail',
                    'message' => 'API will fail - table does not exist',
                    'value' => 'FAIL'
                ];
            }
            
            $unreadCount = $notificationModel->getUnreadCount($userId);
            $notifications = $notificationModel->getNotificationsForUser($userId, 5);
            
            return [
                'status' => 'pass',
                'message' => 'API endpoint should work correctly',
                'value' => 'OK',
                'unread_count' => $unreadCount,
                'notifications_count' => count($notifications)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'fail',
                'message' => 'API test error: ' . $e->getMessage(),
                'value' => 'ERROR'
            ];
        }
    }
}

