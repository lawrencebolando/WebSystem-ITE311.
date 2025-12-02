<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CreateTables extends Controller
{
    /**
     * Create missing database tables
     * Access: http://localhost/ITE311-BOLANDO/create-tables
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        
        $results = [];
        
        // 1. Create Announcements Table
        if ($db->tableExists('announcements')) {
            $results['announcements'] = ['status' => 'exists', 'message' => 'Table already exists'];
        } else {
            try {
                $fields = [
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'title' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'content' => [
                        'type' => 'TEXT',
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => false,
                    ],
                ];
                
                $forge->addField($fields);
                $forge->addKey('id', true);
                $forge->createTable('announcements');
                $results['announcements'] = ['status' => 'created', 'message' => 'Table created successfully!'];
            } catch (\Exception $e) {
                $results['announcements'] = ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        
        // 2. Create Notifications Table
        if ($db->tableExists('notifications')) {
            $results['notifications'] = ['status' => 'exists', 'message' => 'Table already exists'];
        } else {
            try {
                $fields = [
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'user_id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                    ],
                    'message' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'is_read' => [
                        'type' => 'TINYINT',
                        'constraint' => 1,
                        'default' => 0,
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => false,
                    ],
                ];
                
                $forge->addField($fields);
                $forge->addKey('id', true);
                $forge->addKey('user_id');
                $forge->addKey('is_read');
                $forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
                $forge->createTable('notifications');
                $results['notifications'] = ['status' => 'created', 'message' => 'Table created successfully!'];
            } catch (\Exception $e) {
                $results['notifications'] = ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        
        // 3. Create Materials Table
        if ($db->tableExists('materials')) {
            $results['materials'] = ['status' => 'exists', 'message' => 'Table already exists'];
        } else {
            try {
                $fields = [
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'course_id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                    ],
                    'file_name' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'file_path' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'file_size' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'null' => true,
                    ],
                    'file_type' => [
                        'type' => 'VARCHAR',
                        'constraint' => 100,
                        'null' => true,
                    ],
                    'uploaded_by' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'null' => true,
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => false,
                    ],
                    'updated_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                    ],
                ];
                
                $forge->addField($fields);
                $forge->addKey('id', true);
                $forge->addKey('course_id');
                $forge->addKey('uploaded_by');
                $forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
                $forge->addForeignKey('uploaded_by', 'users', 'id', 'SET NULL', 'CASCADE');
                $forge->createTable('materials');
                $results['materials'] = ['status' => 'created', 'message' => 'Table created successfully!'];
            } catch (\Exception $e) {
                $results['materials'] = ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        
        $data = [
            'title' => 'Create Database Tables',
            'results' => $results
        ];
        
        return view('create_tables_result', $data);
    }
}

