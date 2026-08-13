<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSeoFieldsToProduct extends Migration
{
    public function up()
    {
        $this->forge->addColumn('product', [
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'description',
            ],
            'meta_description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'meta_title',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('product', ['meta_title', 'meta_description']);
    }
}
