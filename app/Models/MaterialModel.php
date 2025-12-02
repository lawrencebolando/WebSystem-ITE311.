<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'course_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'uploaded_by',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'course_id' => 'required|integer',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be an integer'
        ],
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'file_path' => [
            'required' => 'File path is required',
            'max_length' => 'File path cannot exceed 255 characters'
        ]
    ];

    /**
     * Insert a new material record
     * 
     * @param array $data Material data
     * @return int|false Inserted ID or false on failure
     */
    public function insertMaterial($data)
    {
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     * 
     * @param int $course_id Course ID
     * @return array Materials for the course
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->select('materials.*, users.name as uploaded_by_name')
                    ->join('users', 'users.id = materials.uploaded_by', 'left')
                    ->where('materials.course_id', $course_id)
                    ->orderBy('materials.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get material by ID
     * 
     * @param int $material_id Material ID
     * @return array|null Material data or null if not found
     */
    public function getMaterialById($material_id)
    {
        return $this->select('materials.*, users.name as uploaded_by_name, courses.title as course_title')
                    ->join('users', 'users.id = materials.uploaded_by', 'left')
                    ->join('courses', 'courses.id = materials.course_id', 'left')
                    ->where('materials.id', $material_id)
                    ->first();
    }

    /**
     * Delete material by ID
     * 
     * @param int $material_id Material ID
     * @return bool True on success, false on failure
     */
    public function deleteMaterial($material_id)
    {
        return $this->delete($material_id);
    }
}

