<?php
/**
 * Quick script to create missing database tables
 * Run this by going to: http://localhost/ITE311-BOLANDO/create_tables.php
 */

// Bootstrap CodeIgniter
define('ENVIRONMENT', 'development');
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', ROOTPATH . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', ROOTPATH . 'app' . DIRECTORY_SEPARATOR);
define('WRITEPATH', ROOTPATH . 'writable' . DIRECTORY_SEPARATOR);
define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

require_once SYSTEMPATH . 'bootstrap.php';

// Get database connection
$db = \Config\Database::connect();

echo "<!DOCTYPE html><html><head><title>Create Tables</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;}";
echo ".success{color:green;padding:15px;background:#d4edda;border:1px solid #c3e6cb;margin:10px 0;border-radius:5px;}";
echo ".error{color:red;padding:15px;background:#f8d7da;border:1px solid #f5c6cb;margin:10px 0;border-radius:5px;}";
echo ".info{color:#0c5460;padding:15px;background:#d1ecf1;border:1px solid #bee5eb;margin:10px 0;border-radius:5px;}";
echo "h1{color:#333;} h2{color:#666;margin-top:20px;}</style></head><body>";

echo "<h1>🔧 Creating Missing Database Tables</h1>";

$forge = \Config\Database::forge();

// 1. Create Announcements Table
echo "<h2>1. Creating announcements table...</h2>";
try {
    if ($db->tableExists('announcements')) {
        echo "<div class='info'>ℹ️ Announcements table already exists. Skipping...</div>";
    } else {
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
        echo "<div class='success'>✅ Announcements table created successfully!</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// 2. Create Notifications Table
echo "<h2>2. Creating notifications table...</h2>";
try {
    if ($db->tableExists('notifications')) {
        echo "<div class='info'>ℹ️ Notifications table already exists. Skipping...</div>";
    } else {
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
        echo "<div class='success'>✅ Notifications table created successfully!</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// 3. Create Materials Table
echo "<h2>3. Creating materials table...</h2>";
try {
    if ($db->tableExists('materials')) {
        echo "<div class='info'>ℹ️ Materials table already exists. Skipping...</div>";
    } else {
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
        echo "<div class='success'>✅ Materials table created successfully!</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "<hr>";
echo "<h2>✅ Process Complete!</h2>";
echo "<div class='success'>";
echo "<p><strong>All tables have been checked/created!</strong></p>";
echo "<p>Now refresh your application page and the errors should be gone.</p>";
echo "<p><a href='/ITE311-BOLANDO/' style='padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Go to Home Page</a></p>";
echo "</div>";

echo "</body></html>";
?>
