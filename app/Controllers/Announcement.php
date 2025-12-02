<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class Announcement extends BaseController
{
    public function index()
    {
        $model = new AnnouncementModel();
        $data['announcements'] = $model->findAll();
        return view('announcements', $data);
    }

    public function add()
    {
        helper(['form']);
        $model = new AnnouncementModel();

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required|min_length[10]'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($model->insert($data)) {
                    session()->setFlashdata('success', 'Announcement added successfully.');
                    return redirect()->to(base_url('announcements'));
                } else {
                    session()->setFlashdata('error', 'Failed to add announcement.');
                }
            } else {
                session()->setFlashdata('error', 'Validation failed. Please check your input.');
            }
        }

        return view('add_announcement', [
            'validation' => $this->validator
        ]);
    }

    public function edit($id = null)
    {
        echo "Edit announcement with ID: " . $id;
    }

    public function delete($id = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'You must be logged in to delete announcements.');
            return redirect()->to(base_url('login'));
        }

        // Check if user is admin (only admins can delete announcements)
        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Only administrators can delete announcements.');
            return redirect()->to(base_url('announcements'));
        }

        // Validate ID
        if (!$id) {
            session()->setFlashdata('error', 'Invalid announcement ID.');
            return redirect()->to(base_url('announcements'));
        }

        $model = new AnnouncementModel();
        
        // Check if announcement exists
        $announcement = $model->find($id);
        if (!$announcement) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('announcements'));
        }

        // Delete announcement
        if ($model->delete($id)) {
            session()->setFlashdata('success', 'Announcement deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete announcement. Please try again.');
        }

        return redirect()->to(base_url('announcements'));
    }
}
