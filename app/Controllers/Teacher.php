<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Teacher extends BaseController
{
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login first.');
            return redirect()->to(base_url('login'));
        }

        if (session('role') !== 'teacher') {
            session()->setFlashdata('error', 'Unauthorized access.');
            return redirect()->to(base_url('login'));
        }

        $teacher_id = session()->get('user_id');
        
        // Get teacher's courses
        $myCourses = $this->courseModel->getCoursesByInstructor($teacher_id);
        
        // Get enrollment counts for each course
        $totalStudents = 0;
        $coursesWithEnrollments = [];
        foreach ($myCourses as $course) {
            $courseEnrollments = $this->enrollmentModel->getCourseEnrollments($course['id']);
            $enrollmentCount = count($courseEnrollments);
            $totalStudents += $enrollmentCount;
            $course['student_count'] = $enrollmentCount;
            $coursesWithEnrollments[] = $course;
        }

        return view('teacher/dashboard', [
            'user' => [
              'name'  => session('name'),
              'email' => session('email'),
              'role'  => session('role'),
            ],
            'myCourses' => $coursesWithEnrollments,
            'totalCourses' => count($myCourses),
            'totalStudents' => $totalStudents
          ]);
    }
}