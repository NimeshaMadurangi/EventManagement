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
            'photographername' => [  // Changed to 'photographername' as requested
                'type' => 'VARCHAR',
                'constraint' => '100',
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

        // Adding the primary key
        $this->forge->addKey('eventid', true);

        // Adding the foreign key to reference 'users' table based on 'username'
        $this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');

        // Creating the events table
        $this->forge->createTable('events');
    }

    public function down()
    {
        // Dropping the events table along with the foreign key relationship
        $this->forge->dropTable('events');
    }
}
