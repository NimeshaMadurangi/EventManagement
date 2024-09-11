<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'fileid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'foldername' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,  // Description is optional
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // Default status value (e.g., 0 for inactive)
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('fileid', true);  // Primary key
        $this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');  // Foreign key for username

        $this->forge->createTable('file');
    }

    public function down()
    {
        $this->forge->dropTable('file');
    }
}
