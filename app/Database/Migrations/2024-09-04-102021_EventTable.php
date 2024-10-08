<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'eventid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'eventname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'eventdate' => [
                'type' => 'DATE',
            ],
            'time' => [
                'type' => 'TIME',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'photographer' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unsigned'   => true,
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
        $this->forge->addKey('eventid', true);
        $this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');
        $this->forge->createTable('event');
    }

    public function down()
    {
        $this->forge->dropTable('event');
    }
}
