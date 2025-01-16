<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ref_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ref_by_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'wallet' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'bonus' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'paid' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'plan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'plan_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'inactive'
            ],
            'lb_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'dashboard' => [
                'type' => 'ENUM',
                'constraint' => ['new', 'old'],
                'default' => 'new'
            ],
            'lead_access' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'landing_page' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'withdraw_access' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'referral_access' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'mlm_access' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
