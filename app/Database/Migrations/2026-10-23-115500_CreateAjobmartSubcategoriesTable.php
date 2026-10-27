<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAjobmartSubcategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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

        $this->forge->addUniqueKey(
            ['category_id', 'slug'],
            'uq_category_subcategory_slug'
        );

        $this->forge->addKey(
            ['category_id', 'status'],
            false,
            false,
            'idx_subcategory_category_status'
        );

        $this->forge->createTable('ajobmart_subcategories', true);
    }

    public function down()
    {
        $this->forge->dropTable('ajobmart_subcategories', true);
    }
}
