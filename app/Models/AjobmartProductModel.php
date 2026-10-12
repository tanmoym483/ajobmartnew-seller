<?php

namespace App\Models;

use CodeIgniter\Model;

class AjobmartProductModel extends Model
{
    protected $table            = 'ajobmart_products';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'seller_id',
        'category',
        'product_name',
        'brand',
        'sku',
        'description',
        'product_condition',
        'category_attributes',
        'mrp',
        'selling_price',
        'stock_quantity',
        'low_stock',
        'shipping_weight',
        'shipping_days',
        'shipping_type',
        'status',
    ];
}
