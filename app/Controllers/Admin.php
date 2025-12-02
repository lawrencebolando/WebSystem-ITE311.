<?php

namespace App\Controllers;

use App\Controllers\BaseController;
<<<<<<< HEAD

class Admin extends BaseController
{ 
    public function dashboard()
    {
        // Must be logged in
        if  (!session () ->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please Login first.');
            return redirect()->to(base_url('login'));
        }

        // Must be admin
        if (session('role') !== 'admin') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('login'));
        }

        // Render unified wrapper with user context
        return view('auth/dashboard', [
            'user' => [
                'name'  => session('name'),
                'email' => session('email'),
                'role'  => session('role'),
            ]
        ]);
        }
}

=======
use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        // Check if user is logged in and is admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();

        $data = [
            'title' => 'Admin Dashboard',
            'users' => $userModel->findAll(),
            'courses' => $courseModel->findAll(),
            'enrollments' => $enrollmentModel->countAll(),
            'totalUsers' => $userModel->countAll(),
            'totalCourses' => $courseModel->countAll()
        ];

        return view('admin', $data);
    }

    // Additional admin methods can be added here, e.g., manage users, etc.
    public function users()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data = [
            'title' => 'Manage Users',
            'users' => $userModel->findAll()
        ];

        return view('admin/users', $data); // Assuming a view exists or create one
    }

    public function settings()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Admin Settings'
        ];

        return view('admin/settings', $data); // Assuming a view exists or create one
    }
}
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431
