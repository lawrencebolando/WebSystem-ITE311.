<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use CodeIgniter\Controller;

class Announcement extends BaseController
{
    // ✅ Display all announcements
    public function index()
    {
        $model = new AnnouncementModel();
        $data['announcements'] = $model->findAll();

        return view('announcements', $data);
    }

    // ✅ Show Add form or handle Add logic
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
                    'date_posted' => date('Y-m-d H:i:s'),
                    'posted_by' => session()->get('user_id')
                ];

                if ($model->insert($data)) {
                    session()->setFlashdata('success', 'Announcement added successfully.');
                    return redirect()->to('/announcements');
                } else {
                    session()->setFlashdata('error', 'Failed to add announcement.');
                }
            }
        }

        return view('add_announcement', [
            'validation' => $this->validator
        ]);
    }

    // ✅ Show Edit form or handle update
    public function edit($id = null)
    {
        echo "Edit announcement with ID: " . $id;
    }

    // ✅ Delete specific announcement
    public function delete($id = null)
    {
        echo "Delete announcement with ID: " . $id;
    }
}
