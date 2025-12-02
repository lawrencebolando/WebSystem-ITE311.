<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class Notifications extends Controller
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for logged-in user
     * Returns JSON with unread count and latest notifications
     */
    public function get()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to view notifications.'
            ]);
        }

        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User session not found.'
            ]);
        }

        // Check if table exists first
        $db = \Config\Database::connect();
        if (!$db->tableExists('notifications')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notifications table does not exist. Please create it: <a href="' . base_url('create-tables') . '">Create Tables</a>',
                'unread_count' => 0,
                'notifications' => []
            ]);
        }

        // Get unread count
        try {
            $unreadCount = $this->notificationModel->getUnreadCount($userId);
            
            // Get latest notifications
            $notifications = $this->notificationModel->getNotificationsForUser($userId, 5);
            
            // Log for debugging
            log_message('info', 'Notifications fetched for user ' . $userId . ': count=' . $unreadCount . ', notifications=' . count($notifications));

            // Format notifications for display
            $formattedNotifications = [];
            foreach ($notifications as $notification) {
                $formattedNotifications[] = [
                    'id' => $notification['id'],
                    'message' => $notification['message'],
                    'is_read' => (bool)$notification['is_read'],
                    'created_at' => $notification['created_at'],
                    'time_ago' => $this->timeAgo($notification['created_at'])
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'unread_count' => $unreadCount,
                'notifications' => $formattedNotifications,
                'debug' => [
                    'user_id' => $userId,
                    'table_exists' => true,
                    'notifications_count' => count($notifications)
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching notifications: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching notifications: ' . $e->getMessage(),
                'unread_count' => 0,
                'notifications' => []
            ]);
        }
    }

    /**
     * Mark a notification as read
     * 
     * @param int $id Notification ID
     */
    public function mark_as_read($id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to mark notifications as read.'
            ]);
        }

        $userId = session()->get('user_id');

        // Verify notification belongs to user
        $notification = $this->notificationModel->find($id);
        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification not found.'
            ]);
        }

        if ($notification['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to mark this notification as read.'
            ]);
        }

        // Mark as read
        if ($this->notificationModel->markAsRead($id)) {
            // Get updated unread count
            $unreadCount = $this->notificationModel->getUnreadCount($userId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notification marked as read.',
                'unread_count' => $unreadCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to mark notification as read.'
            ]);
        }
    }

    /**
     * Helper function to calculate time ago
     * 
     * @param string $datetime
     * @return string
     */
    private function timeAgo($datetime)
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M d, Y', $timestamp);
        }
    }
}

