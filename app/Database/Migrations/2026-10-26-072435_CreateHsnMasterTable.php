<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHsnMasterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'hsn_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 8,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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

        $this->forge->addKey('id', true);
        $this->forge->addKey('hsn_code');
        $this->forge->addKey('is_active');

        $this->forge->createTable('ajobmart_hsn_master', true);
    }

    public function down()
    {
        $this->forge->dropTable('ajobmart_hsn_master', true);
    }
}