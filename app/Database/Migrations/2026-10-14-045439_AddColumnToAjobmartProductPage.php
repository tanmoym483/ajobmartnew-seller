<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToAjobmartProductPage extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ajobmart_products', [
            'package_length' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,3',
                'default'    => 0.00,
                'null'       => false,
                'after'      => 'category_attributes',
            ],

            'package_width' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'default'    => 0.00,
                'null'       => false,
                'after'      => 'package_length',
            ],

            'package_height' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'default'    => 0.00,
                'null'       => false,
                'after'      => 'package_width',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ajobmart_products', [
            'package_length',
            'package_width',
            'package_height'
        ]);
    }
}
