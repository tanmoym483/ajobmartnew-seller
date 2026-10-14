<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductDetailsToAjobmartProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ajobmart_products', [
            'country_of_origin' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'hsn_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'manufacturer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'model_number_general' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'key_features' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ajobmart_products', [
            'country_of_origin',
            'hsn_code',
            'manufacturer_name',
            'model_number_general',
            'key_features',
        ]);
    }
}
