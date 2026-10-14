<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToAjobmartProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ajobmart_products', [
            'listing_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
                'null'       => false,
                'after'      => 'selling_price',
            ],

            'shipping_allowance' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
                'after'      => 'listing_price',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ajobmart_products', [
            'listing_price',
            'shipping_allowance',
        ]);
    }
}
