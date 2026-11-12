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
        'category_id',
        'subcategory_id',
        'product_type_id',
        'category',
        'product_name',
        'brand',
        'sub_brand',
        'pack_of',
        'min_order_quantity',
        'sku',
        'description',
        'product_condition',
        'category_attributes',
        'package_length',
        'package_width',
        'package_height',
        'mrp',
        'selling_price',
        'listing_price',
        'shipping_allowance',
        'stock_quantity',
        'low_stock',
        'shipping_weight',
        'shipping_days',
        'shipping_type',
        'status',
        'approval_status',
        'country_of_origin',
        'hsn_code',
        'gst_value',
        'manufacturer_name',
        'packer_name',
        'model_number_general',
        'key_features',
    ];


    public function getSellerInventory(int $sellerId): array
    {
        return $this->db->table('ajobmart_products p')
            ->select('
                p.id,
                p.seller_id,
                p.category,
                p.product_name,
                p.brand,
                p.sku,
                p.product_condition,
                p.mrp,
                p.selling_price,
                p.stock_quantity,
                p.low_stock,
                p.status,
                p.created_at
            ')
            ->select(
                '(SELECT pi.image_path
                  FROM ajobmart_product_images pi
                  WHERE pi.product_id = p.id
                  ORDER BY pi.is_primary DESC,
                           pi.sort_order ASC,
                           pi.id ASC
                  LIMIT 1) AS image_path',
                false
            )
            ->where('p.seller_id', $sellerId)
            ->orderBy('p.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Calculate inventory totals for one seller.
     */
    public function getInventoryStats(int $sellerId): array
    {
        $result = $this->db->table('ajobmart_products p')
            ->select('COUNT(*) AS total_products', false)
            ->select(
                'COALESCE(SUM(GREATEST(p.stock_quantity, 0)), 0) AS total_stock',
                false
            )
            ->select(
                'COALESCE(SUM(
                    CASE
                        WHEN p.stock_quantity > 0
                         AND p.stock_quantity <= GREATEST(p.low_stock, 0)
                        THEN 1 ELSE 0
                    END
                ), 0) AS low_stock_products',
                false
            )
            ->select(
                'COALESCE(SUM(
                    CASE
                        WHEN p.stock_quantity <= 0
                        THEN 1 ELSE 0
                    END
                ), 0) AS out_of_stock_products',
                false
            )
            ->where('p.seller_id', $sellerId)
            ->get()
            ->getRowArray();

        return $result ?? [
            'total_products'       => 0,
            'total_stock'          => 0,
            'low_stock_products'   => 0,
            'out_of_stock_products'=> 0,
        ];
    }
}
