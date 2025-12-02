<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class QuickTest extends Controller
{
    /**
     * Quick test page that shows notifications directly
     * Access: http://localhost/ITE311-BOLANDO/quick-test
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }
        
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Quick Test',
            'tableExists' => $db->tableExists('notifications'),
            'userId' => $userId,
            'notifications' => []
        ];
        
        if ($data['tableExists'] && $userId) {
            try {
                $notificationModel = new NotificationModel();
                $data['notifications'] = $notificationModel->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
                $data['unreadCount'] = $notificationModel->getUnreadCount($userId);
            } catch (\Exception $e) {
                $data['error'] = $e->getMessage();
            }
        }
        
        // Test API endpoint
        $data['apiUrl'] = base_url('notifications');
        $data['testApiResponse'] = null;
        
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $data['apiUrl']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $data['apiHttpCode'] = $httpCode;
            $data['testApiResponse'] = json_decode($response, true);
        } catch (\Exception $e) {
            $data['apiError'] = $e->getMessage();
        }
        
        return view('quick_test', $data);
    }
}

