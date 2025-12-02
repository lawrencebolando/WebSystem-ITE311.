<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Course extends Controller
{
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Display all available courses
     */
    public function index()
    {
        $data = [
            'title' => 'Available Courses',
            'courses' => $this->courseModel->getCoursesWithInstructor()
        ];

        return view('courses/index', $data);
    }

    /**
     * Display a specific course
     */
    public function view($id)
    {
        $course = $this->courseModel->getCourseWithInstructor($id);
        
        if (!$course) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Course not found');
        }

        $data = [
            'title' => $course['title'],
            'course' => $course
        ];

        return view('courses/view', $data);
    }

    /**
     * Handle course enrollment via AJAX
     */
    public function enroll()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to enroll in courses.'
            ]);
        }

        // Check if request is POST (CodeIgniter returns uppercase)
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method. Expected POST, got: ' . $this->request->getMethod()
            ]);
        }

        // Get user ID from session
        $user_id = session()->get('user_id');
        
        if (!$user_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User session not found. Please login again.'
            ]);
        }

        // Get course_id from POST request
        $course_id = $this->request->getPost('course_id');
        
        if (!$course_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course ID is required.'
            ]);
        }

        // Validate course exists
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course not found.'
            ]);
        }

        // Check if user is already enrolled
        if ($this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        // Prepare enrollment data
        $enrollmentData = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s'),
            'status' => 'active',
            'progress' => 0.00
        ];

        // Insert new enrollment record
        $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

        if ($enrollmentId) {
            // Get the enrollment with course details for the response
            $allEnrollments = $this->enrollmentModel->getUserEnrollments($user_id);
            $newEnrollment = null;
            foreach ($allEnrollments as $enr) {
                if ($enr['course_id'] == $course_id) {
                    $newEnrollment = $enr;
                    break;
                }
            }

            // If we couldn't find it in the joined query, create a basic structure
            if (!$newEnrollment) {
                $newEnrollment = [
                    'course_id' => $course_id,
                    'course_title' => $course['title'],
                    'course_description' => $course['description'] ?? '',
                    'enrollment_date' => $enrollmentData['enrollment_date'],
                    'status' => $enrollmentData['status'],
                    'progress' => $enrollmentData['progress']
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully enrolled in ' . $course['title'] . '!',
                'enrollment' => $newEnrollment,
                'course' => $course
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to enroll in course. Please try again.'
            ]);
        }
    }

    /**
     * Handle course unenrollment via AJAX
     */
    public function unenroll()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to unenroll from courses.'
            ]);
        }

        // Check if request is POST (CodeIgniter returns uppercase)
        if ($this->request->getMethod() !== 'POST') {
            session()->setFlashdata('error', 'Invalid request method.');
            return redirect()->to('student/dashboard');
        }

        // Get course_id from POST request
        $course_id = $this->request->getPost('course_id');
        
        if (!$course_id) {
            session()->setFlashdata('error', 'Course ID is required.');
            return redirect()->to('student/dashboard');
        }

        // Get user ID from session
        $user_id = session()->get('user_id');

        // Check if user is enrolled
        $enrollment = $this->enrollmentModel->getEnrollment($user_id, $course_id);
        if (!$enrollment) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are not enrolled in this course.'
            ]);
        }

        // Update enrollment status to dropped
        $result = $this->enrollmentModel->updateStatus($user_id, $course_id, 'dropped');

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully unenrolled from course.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to unenroll from course. Please try again.'
            ]);
        }
    }

    /**
     * Get user's enrolled courses
     */
    public function myEnrollments()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $user_id = session()->get('user_id');
        $enrollments = $this->enrollmentModel->getUserEnrollments($user_id);

        $data = [
            'title' => 'My Enrollments',
            'enrollments' => $enrollments
        ];

        return view('courses/my_enrollments', $data);
    }
}
