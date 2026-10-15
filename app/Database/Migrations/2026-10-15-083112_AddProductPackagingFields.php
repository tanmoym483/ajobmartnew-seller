<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductPackagingFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ajobmart_products', [
            'sub_brand' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'brand',
            ],
            'pack_of' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 1,
                'null'       => false,
                'after'      => 'sub_brand',
            ],
            'min_order_quantity' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 1,
                'null'       => false,
                'after'      => 'pack_of',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ajobmart_products', [
            'sub_brand',
            'pack_of',
            'min_order_quantity',
        ]);
    }
}
