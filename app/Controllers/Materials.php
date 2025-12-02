<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Materials extends Controller
{
    protected $materialModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Display upload form and handle file upload
     * 
     * @param int $course_id Course ID
     */
    public function upload($course_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'You must be logged in to upload materials.');
            return redirect()->to(base_url('login'));
        }

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Check permissions: Admin can upload to any course, Instructor only to their courses
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->back();
        }

        if ($userRole === 'teacher' && $course['instructor_id'] != $userId) {
            session()->setFlashdata('error', 'You can only upload materials to your own courses.');
            return redirect()->back();
        }

        if ($userRole !== 'admin' && $userRole !== 'teacher') {
            session()->setFlashdata('error', 'You do not have permission to upload materials.');
            return redirect()->back();
        }

        // Handle POST request (file upload)
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            
            $validation->setRules([
                'material_file' => [
                    'label' => 'Material File',
                    'rules' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar]',
                    'errors' => [
                        'uploaded' => 'Please select a file to upload.',
                        'max_size' => 'File size must not exceed 10MB.',
                        'ext_in' => 'Only PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR files are allowed.'
                    ]
                ]
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data = [
                    'title' => 'Upload Material',
                    'course' => $course,
                    'validation' => $validation,
                    'materials' => $this->materialModel->getMaterialsByCourse($course_id)
                ];
                return view('materials/upload', $data);
            }

            $file = $this->request->getFile('material_file');
            
            if ($file->isValid() && !$file->hasMoved()) {
                // Create upload directory if it doesn't exist
                $uploadPath = WRITEPATH . 'uploads/materials/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate unique filename
                $newName = $file->getRandomName();
                $filePath = 'materials/' . $newName;

                // Move file to upload directory
                if ($file->move(WRITEPATH . 'uploads/materials/', $newName)) {
                    // Save material info to database
                    $materialData = [
                        'course_id' => $course_id,
                        'file_name' => $file->getClientName(),
                        'file_path' => $filePath,
                        'file_size' => $file->getSize(),
                        'file_type' => $file->getClientMimeType(),
                        'uploaded_by' => $userId
                    ];

                    if ($this->materialModel->insertMaterial($materialData)) {
                        session()->setFlashdata('success', 'Material uploaded successfully!');
                        return redirect()->to(base_url('admin/course/' . $course_id . '/upload'));
                    } else {
                        // Delete uploaded file if database insert fails
                        @unlink(WRITEPATH . 'uploads/' . $filePath);
                        session()->setFlashdata('error', 'Failed to save material information. Please try again.');
                    }
                } else {
                    session()->setFlashdata('error', 'Failed to upload file: ' . $file->getErrorString());
                }
            } else {
                session()->setFlashdata('error', 'Invalid file upload.');
            }
        }

        // Display upload form
        $data = [
            'title' => 'Upload Material - ' . $course['title'],
            'course' => $course,
            'materials' => $this->materialModel->getMaterialsByCourse($course_id),
            'validation' => \Config\Services::validation()
        ];

        return view('materials/upload', $data);
    }

    /**
     * Delete a material record and its file
     * 
     * @param int $material_id Material ID
     */
    public function delete($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'You must be logged in to delete materials.');
            return redirect()->to(base_url('login'));
        }

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Get material info
        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }

        // Check permissions
        $course = $this->courseModel->find($material['course_id']);
        if ($userRole === 'teacher' && $course['instructor_id'] != $userId) {
            session()->setFlashdata('error', 'You can only delete materials from your own courses.');
            return redirect()->back();
        }

        if ($userRole !== 'admin' && $userRole !== 'teacher') {
            session()->setFlashdata('error', 'You do not have permission to delete materials.');
            return redirect()->back();
        }

        // Delete file from server
        $filePath = WRITEPATH . 'uploads/' . $material['file_path'];
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        // Delete record from database
        if ($this->materialModel->deleteMaterial($material_id)) {
            session()->setFlashdata('success', 'Material deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to delete material. Please try again.');
        }

        return redirect()->back();
    }

    /**
     * Allow enrolled students to securely download materials
     * 
     * @param int $material_id Material ID
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'You must be logged in to download materials.');
            return redirect()->to(base_url('login'));
        }

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Get material info
        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }

        // Check permissions
        if ($userRole === 'student') {
            // Students must be enrolled in the course
            if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $material['course_id'])) {
                session()->setFlashdata('error', 'You must be enrolled in this course to download materials.');
                return redirect()->back();
            }
        } elseif ($userRole === 'teacher') {
            // Teachers can only download from their own courses
            $course = $this->courseModel->find($material['course_id']);
            if ($course['instructor_id'] != $userId) {
                session()->setFlashdata('error', 'You can only download materials from your own courses.');
                return redirect()->back();
            }
        } elseif ($userRole !== 'admin') {
            session()->setFlashdata('error', 'You do not have permission to download materials.');
            return redirect()->back();
        }

        // Check if file exists
        $filePath = WRITEPATH . 'uploads/' . $material['file_path'];
        if (!file_exists($filePath)) {
            session()->setFlashdata('error', 'File not found on server.');
            return redirect()->back();
        }

        // Serve file for download
        return $this->response->download($filePath, null)->setFileName($material['file_name']);
    }

    /**
     * View materials for a course
     * 
     * @param int $course_id Course ID
     */
    public function view($course_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'You must be logged in to view materials.');
            return redirect()->to(base_url('login'));
        }

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Get course info with instructor name
        $course = $this->courseModel->getCourseWithInstructor($course_id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->back();
        }

        // Check permissions based on role
        if ($userRole === 'student') {
            // Students must be enrolled in the course
            if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $course_id)) {
                session()->setFlashdata('error', 'You must be enrolled in this course to view materials.');
                return redirect()->to(base_url('courses'));
            }
        } elseif ($userRole === 'teacher') {
            // Teachers can view materials from their own courses
            if ($course['instructor_id'] != $userId) {
                session()->setFlashdata('error', 'You can only view materials from your own courses.');
                return redirect()->to(base_url('teacher/dashboard'));
            }
        } elseif ($userRole !== 'admin') {
            session()->setFlashdata('error', 'You do not have permission to view materials.');
            return redirect()->to(base_url('dashboard'));
        }

        // Get materials (already includes uploaded_by_name from join in model)
        $materials = $this->materialModel->getMaterialsByCourse($course_id);
        
        // Ensure uploaded_by_name is set for all materials
        foreach ($materials as &$material) {
            if (empty($material['uploaded_by_name'])) {
                $material['uploaded_by_name'] = 'Unknown';
            }
        }

        // Determine back URL based on role
        $backUrl = base_url('courses');
        if ($userRole === 'student') {
            $backUrl = base_url('student/dashboard');
        } elseif ($userRole === 'teacher') {
            $backUrl = base_url('teacher/dashboard');
        } elseif ($userRole === 'admin') {
            $backUrl = base_url('admin/courses');
        }

        $data = [
            'title' => 'Course Materials - ' . $course['title'],
            'course' => $course,
            'materials' => $materials,
            'userRole' => $userRole,
            'backUrl' => $backUrl,
            'canUpload' => ($userRole === 'admin' || ($userRole === 'teacher' && $course['instructor_id'] == $userId))
        ];

        return view('materials/view', $data);
    }
}

