<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductTypeIdToAjobmartProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ajobmart_products', [
            'product_type_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey(
            'product_type_id',
            false,
            false,
            'idx_products_product_type'
        );
    }

    public function down()
    {
        $this->forge->dropColumn(
            'ajobmart_products',
            'product_type_id'
        );
    }
}
