<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'fileid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'foldername' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('fileid', true); // Set 'fileid' as primary key
        $this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');
        $this->forge->createTable('file');
    }

    public function down()
    {
        $this->forge->dropTable('file');
    }
}
