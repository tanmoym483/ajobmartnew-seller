<?php

namespace App\Models;

use CodeIgniter\Model;

class HsnMasterModel extends Model
{
    protected $table            = 'ajobmart_hsn_master';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'hsn_code',
        'description',
        'is_active',
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}