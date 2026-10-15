<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAjobmartCategoryTables extends Migration
{
    public function up()
    {
        // 1. Product categories
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
            ],
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('ajobmart_categories', true);

        // 2. Category attribute definitions
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
            'attribute_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'input_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'text',
            ],
            'is_required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'options_json' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
            ],
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->addKey('category_id');
        $this->forge->addUniqueKey([
            'category_id',
            'attribute_name',
        ]);
        $this->forge->createTable(
            'ajobmart_category_attributes',
            true
        );

        // 3. Product attribute values
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'attribute_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'attribute_value' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('product_id');
        $this->forge->addUniqueKey([
            'product_id',
            'attribute_id',
        ]);
        $this->forge->createTable(
            'ajobmart_product_attribute_values',
            true
        );

        // 4. Add category_id to existing products
        $this->forge->addColumn('ajobmart_products', [
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'seller_id'
            ],
        ]);
    }

    public function down()
    {
        // Remove the column added to the existing products table.
        if ($this->db->fieldExists('category_id', 'ajobmart_products')) {
            $this->forge->dropColumn(
                'ajobmart_products',
                'category_id'
            );
        }

        // Drop tables in reverse creation order.
        $this->forge->dropTable(
            'ajobmart_product_attribute_values',
            true
        );

        $this->forge->dropTable(
            'ajobmart_category_attributes',
            true
        );

        $this->forge->dropTable(
            'ajobmart_categories',
            true
        );
    }
}