<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseLinks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'topic' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_links');
    }

    public function down()
    {
        $this->forge->dropTable('course_links');
    }
}
