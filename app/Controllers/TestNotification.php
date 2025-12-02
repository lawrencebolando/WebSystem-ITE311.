<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class TestNotification extends Controller
{
    /**
     * Create a test notification for the logged-in user
     * Access: http://localhost/ITE311-BOLANDO/test-notification/create
     */
    public function create()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        
        if (!$userId) {
            session()->setFlashdata('error', 'User session not found.');
            return redirect()->to(base_url('login'));
        }

        // Check if table exists
        $db = \Config\Database::connect();
        if (!$db->tableExists('notifications')) {
            session()->setFlashdata('error', 'Notifications table does not exist. Please create it first: <a href="' . base_url('create-tables') . '">Create Tables</a>');
            return redirect()->to(base_url('dashboard'));
        }

        // Create test notification
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
                session()->setFlashdata('error', 'Failed to create notification.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to(base_url('dashboard'));
    }
}

