<?php

namespace App\Database\Migrations\Alter;

use CodeIgniter\Database\Migration;

class UserInstaCol extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'instagram' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'password'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'instagram');
    }
}
