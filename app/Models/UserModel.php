<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
<<<<<<< HEAD

    protected $allowedFields = [
        'name',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at'
    ];
=======
    protected $protectFields = true;
    protected $allowedFields = ['name', 'email', 'password', 'role', 'created_at', 'updated_at'];
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
<<<<<<< HEAD

    // NO VALIDATION - Just save everything
    protected $skipValidation = true;
    protected $cleanValidationRules = false;

    // NO CALLBACKS - Let controller handle everything
    protected $beforeInsert = [];
    protected $beforeUpdate = [];

    /**
     * Find user by email
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Find user by ID
     */
    public function findById(int $id)
    {
        return $this->find($id);
    }

    /**
     * Get all users
     */
    public function getAllUsers()
    {
        return $this->findAll();
=======
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,user]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 3 characters long',
            'max_length' => 'Name cannot exceed 100 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Role must be either admin or user'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        return $this->passwordHash($data);
    }

    protected function beforeUpdate(array $data)
    {
        return $this->passwordHash($data);
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431
    }
}
