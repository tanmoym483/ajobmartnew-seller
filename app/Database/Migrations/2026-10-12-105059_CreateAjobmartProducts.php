<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAjobmartProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'seller_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'brand' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'sku' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'product_condition' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'new',
            ],
            'category_attributes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'mrp' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'selling_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'stock_quantity' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'low_stock' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 5,
            ],
            'shipping_weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
            'shipping_days' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'shipping_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'platform',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'draft',
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
        $this->forge->addKey('seller_id');
        $this->forge->addKey('category');
        $this->forge->addKey('status');
        $this->forge->createTable('ajobmart_products', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'image_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'is_primary' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->createTable('ajobmart_product_images', true);
    }

    public function down()
    {
        $this->forge->dropTable('ajobmart_product_images', true);
        $this->forge->dropTable('ajobmart_products', true);
    }
}
