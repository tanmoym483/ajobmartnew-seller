<?php

namespace App\Models;

use CodeIgniter\Model;

class AjobmartProductImageModel extends Model
{
    protected $table         = 'ajobmart_product_images';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'product_id',
        'image_name',
        'image_path',
        'is_primary',
        'sort_order',
        'created_at',
    ];
}
