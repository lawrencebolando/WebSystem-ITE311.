<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'title',
        'description',
        'instructor_id',
        'category',
        'level',
        'duration',
        'price',
        'thumbnail',
        'status',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'instructor_id' => 'required|integer',
        'category' => 'permit_empty|max_length[100]',
        'duration' => 'permit_empty|integer',
        'price' => 'permit_empty|decimal',
        'status' => 'in_list[draft,published,archived]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Course title is required',
            'min_length' => 'Course title must be at least 3 characters long',
            'max_length' => 'Course title cannot exceed 255 characters'
        ],
        'description' => [
            'required' => 'Course description is required',
            'min_length' => 'Course description must be at least 10 characters long'
        ],
        'instructor_id' => [
            'required' => 'Instructor is required',
            'integer' => 'Instructor ID must be an integer'
        ],
        'category' => [
            'max_length' => 'Category cannot exceed 100 characters'
        ],
        'duration' => [
            'integer' => 'Duration must be a number'
        ],
        'price' => [
            'decimal' => 'Price must be a valid decimal number'
        ],
        'status' => [
            'in_list' => 'Status must be one of: draft, published, archived'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get courses with instructor information
     */
    public function getCoursesWithInstructor()
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id')
                    ->where('courses.status', 'published')
                    ->findAll();
    }

    /**
     * Get course by ID with instructor information
     */
    public function getCourseWithInstructor($id)
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id')
                    ->where('courses.id', $id)
                    ->first();
    }

    /**
     * Get courses by instructor
     */
    public function getCoursesByInstructor($instructor_id)
    {
        return $this->where('instructor_id', $instructor_id)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
