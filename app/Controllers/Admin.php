<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
            return redirect()->to(base_url('login'));
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

        return view('admin/dashboard', $data);
    }

    // Additional admin methods can be added here, e.g., manage users, etc.
    public function users()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $data = [
            'title' => 'Manage Users',
            'users' => $userModel->findAll()
        ];

        return view('admin/users', $data);
    }

    public function settings()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title' => 'Admin Settings'
        ];

        return view('admin/settings', $data);
    }

    /**
     * List all courses for management
     */
    public function courses()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $courseModel = new CourseModel();
        $userModel = new UserModel();

        // Get all courses with instructor names
        $courses = $courseModel->select('courses.*, users.name as instructor_name')
                              ->join('users', 'users.id = courses.instructor_id', 'left')
                              ->orderBy('courses.created_at', 'DESC')
                              ->findAll();

        // Get all teachers for the create form
        $teachers = $userModel->where('role', 'teacher')->findAll();

        $data = [
            'title' => 'Manage Courses',
            'courses' => $courses,
            'teachers' => $teachers
        ];

        return view('admin/courses', $data);
    }

    /**
     * Show create course form
     */
    public function createCourse()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $teachers = $userModel->where('role', 'teacher')->findAll();

        $data = [
            'title' => 'Create New Course',
            'teachers' => $teachers
        ];

        return view('admin/course_create', $data);
    }

    /**
     * Store new course
     */
    public function storeCourse()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $courseModel = new CourseModel();
        $userModel = new UserModel();

        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'instructor_id' => 'required|integer',
            'category' => 'permit_empty|max_length[100]',
            'level' => 'permit_empty|in_list[beginner,intermediate,advanced]',
            'duration' => 'permit_empty|integer',
            'price' => 'permit_empty|decimal',
            'status' => 'permit_empty|in_list[draft,published,archived]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Prepare course data
        $courseData = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'instructor_id' => $this->request->getPost('instructor_id'),
            'category' => $this->request->getPost('category') ?? null,
            'level' => $this->request->getPost('level') ?? 'beginner',
            'duration' => $this->request->getPost('duration') ?? null,
            'price' => $this->request->getPost('price') ?? 0.00,
            'status' => $this->request->getPost('status') ?? 'published'
        ];

        // Insert course
        if ($courseModel->insert($courseData)) {
            session()->setFlashdata('success', 'Course created successfully!');
            return redirect()->to(base_url('admin/courses'));
        } else {
            session()->setFlashdata('error', 'Failed to create course. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show edit course form
     */
    public function editCourse($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $courseModel = new CourseModel();
        $userModel = new UserModel();

        $course = $courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to(base_url('admin/courses'));
        }

        $teachers = $userModel->where('role', 'teacher')->findAll();

        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'teachers' => $teachers
        ];

        return view('admin/course_edit', $data);
    }

    /**
     * Update course
     */
    public function updateCourse($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $courseModel = new CourseModel();

        $course = $courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to(base_url('admin/courses'));
        }

        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'instructor_id' => 'required|integer',
            'category' => 'permit_empty|max_length[100]',
            'level' => 'permit_empty|in_list[beginner,intermediate,advanced]',
            'duration' => 'permit_empty|integer',
            'price' => 'permit_empty|decimal',
            'status' => 'permit_empty|in_list[draft,published,archived]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Prepare course data
        $courseData = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'instructor_id' => $this->request->getPost('instructor_id'),
            'category' => $this->request->getPost('category') ?? null,
            'level' => $this->request->getPost('level') ?? 'beginner',
            'duration' => $this->request->getPost('duration') ?? null,
            'price' => $this->request->getPost('price') ?? 0.00,
            'status' => $this->request->getPost('status') ?? 'published'
        ];

        // Update course
        if ($courseModel->update($id, $courseData)) {
            session()->setFlashdata('success', 'Course updated successfully!');
            return redirect()->to(base_url('admin/courses'));
        } else {
            session()->setFlashdata('error', 'Failed to update course. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Delete course
     */
    public function deleteCourse($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied. Admins only.');
            return redirect()->to(base_url('login'));
        }

        $courseModel = new CourseModel();

        $course = $courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to(base_url('admin/courses'));
        }

        // Delete course
        if ($courseModel->delete($id)) {
            session()->setFlashdata('success', 'Course deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete course. Please try again.');
        }

        return redirect()->to(base_url('admin/courses'));
    }
}
