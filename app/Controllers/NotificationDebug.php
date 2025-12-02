<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class NotificationDebug extends Controller
{
    /**
     * Debug page to check notification system status
     * Access: http://localhost/ITE311-BOLANDO/notification-debug
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Notification Debug',
            'tableExists' => $db->tableExists('notifications'),
            'userId' => $userId,
            'isLoggedIn' => session()->get('isLoggedIn'),
            'notifications' => [],
            'unreadCount' => 0,
            'allNotifications' => []
        ];
        
        if ($data['tableExists'] && $userId) {
            try {
                $notificationModel = new NotificationModel();
                $data['notifications'] = $notificationModel->getNotificationsForUser($userId, 10);
                $data['unreadCount'] = $notificationModel->getUnreadCount($userId);
                
                // Get all notifications for debugging
                $data['allNotifications'] = $notificationModel->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
            } catch (\Exception $e) {
                $data['error'] = $e->getMessage();
            }
        }
        
        return view('notification_debug', $data);
    }
    
    /**
     * Create a test notification
     * Access: http://localhost/ITE311-BOLANDO/notification-debug/create-test
     */
    public function createTest()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('login'));
        }
        
        $userId = session()->get('user_id');
        
        if (!$userId) {
            session()->setFlashdata('error', 'User session not found.');
            return redirect()->to(base_url('login'));
        }
        
        $db = \Config\Database::connect();
        if (!$db->tableExists('notifications')) {
            session()->setFlashdata('error', 'Notifications table does not exist. Please create it first.');
            return redirect()->to(base_url('notification-debug'));
        }
        
        try {
            $notificationModel = new NotificationModel();
            $notificationData = [
                'user_id' => $userId,
                'message' => 'Test notification created at ' . date('Y-m-d H:i:s'),
                'is_read' => 0
            ];
            
            $notificationId = $notificationModel->createNotification($notificationData);
            
            if ($notificationId) {
                session()->setFlashdata('success', 'Test notification created successfully! ID: ' . $notificationId);
            } else {
                session()->setFlashdata('error', 'Failed to create notification. Check database.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }
        
        return redirect()->to(base_url('notification-debug'));
    }
}
