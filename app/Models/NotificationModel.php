<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'user_id',
        'message',
        'is_read',
        'created_at'
    ];

    // Dates - Disable timestamps and handle created_at manually
    protected $useTimestamps = false;

    protected $validationRules = [
        'user_id' => 'required|integer',
        'message' => 'required|max_length[255]',
        'is_read' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer'
        ],
        'message' => [
            'required' => 'Message is required',
            'max_length' => 'Message cannot exceed 255 characters'
        ]
    ];

    /**
     * Get unread notifications count for a user
     * 
     * @param int $userId User ID
     * @return int Unread count
     */
    public function getUnreadCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Get latest notifications for a user (default 5)
     * 
     * @param int $userId User ID
     * @param int $limit Number of notifications to fetch (default 5)
     * @return array Notifications
     */
    public function getNotificationsForUser($userId, $limit = 5)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Mark a notification as read
     * 
     * @param int $notificationId Notification ID
     * @return bool True on success, false on failure
     */
    public function markAsRead($notificationId)
    {
        return $this->update($notificationId, ['is_read' => 1]);
    }

    /**
     * Create a new notification
     * 
     * @param array $data Notification data
     * @return int|false Inserted ID or false on failure
     */
    public function createNotification($data)
    {
        // Set default values
        $data['is_read'] = $data['is_read'] ?? 0;
        $data['created_at'] = $data['created_at'] ?? date('Y-m-d H:i:s');
        
        return $this->insert($data);
    }
}

