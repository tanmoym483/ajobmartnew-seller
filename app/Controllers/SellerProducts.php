<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AjobmartProductModel;
use App\Models\AjobmartProductImageModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;

class SellerProducts extends BaseController
{
    protected AjobmartProductModel $productModel;
    protected AjobmartProductImageModel $imageModel;
    protected $layout = 'layouts/dashboard/default_dashboard';

    public function __construct()
    {
        $this->productModel = new AjobmartProductModel();
        $this->imageModel   = new AjobmartProductImageModel();
    }

    /**
     * Add Product Page
     */
    public function add()
    {
        if (!$this->session->get('seller_id')) {
            return redirect()->to(site_url('seller'));
        }

        return $this->view('seller/products/add', [
            'title' => 'Add New Product'
        ]);
    }

    /**
     * Save Product
     */
    public function store(): ResponseInterface
    {
        // Reuse the database connection from BaseController.
        $db = $this->db;

        $sellerId = $this->session->get('seller_id');

        // echo '<pre>'; print_r($sellerId); exit;

        if (!$sellerId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Please log in to your seller account.'
                ]);
        }

        $savedFiles = [];
        $transactionStarted = false;

        try {
            // Never accept seller_id from POST data.
            // $sellerId = session()->get('seller_id');

            // if (!$sellerId) {
            //     return $this->response->setStatusCode(401)->setJSON([
            //         'status'  => 'error',
            //         'message' => 'Please log in to your seller account.',
            //     ]);
            // }

            $categories = [
                'electronics', 'fashion', 'grocery',
                'home', 'beauty', 'other',
            ];

        // echo '<pre>'; print_r($categories); exit;


            $category = (string) $this->request->getPost('category');

            if (!in_array($category, $categories, true)) {
                throw new RuntimeException('Please select a valid category.');
            }

            $rules = [
                'product_name'   => 'required|min_length[2]|max_length[200]',
                'description'    => 'required|min_length[10]|max_length[5000]',
                'condition'      => 'required|in_list[new,refurbished,used]',
                'mrp'            => 'required|decimal|greater_than[0]',
                'selling_price'  => 'required|decimal|greater_than[0]',
                'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
                'low_stock'      => 'permit_empty|integer|greater_than_equal_to[0]',
                'shipping_days'  => 'required|integer|in_list[1,2,3,5,7]',
                'shipping_type'  => 'required|in_list[platform,seller]',
                'product_status' => 'required|in_list[draft,pending]',
            ];

            

            if (!$this->validate($rules)) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Please correct the product details.',
                    'errors'  => $this->validator->getErrors(),
                ]);
            }

            $name = trim((string) $this->request->getPost('product_name'));
            $description = trim(
                (string) $this->request->getPost('description')
            );

            $mrp = (float) $this->request->getPost('mrp');
            $price = (float) $this->request->getPost('selling_price');
            $listprice = (float) $this->request->getPost('final_listing_price');


            if ($listprice > $mrp) {
                throw new RuntimeException(
                    'Selling price cannot be higher than MRP.'
                );
            }

            if ($mrp > 9999999999.99 || $price > 9999999999.99) {
                throw new RuntimeException('The entered price is too large.');
            }

            $images = $this->request->getFileMultiple('product_images');


            if (empty($images)) {
                throw new RuntimeException(
                    'Please upload at least one product image.'
                );
            }

            $images = array_values(array_filter(
                $images,
                static fn ($file) => $file instanceof UploadedFile
                    && $file->getError() !== UPLOAD_ERR_NO_FILE
            ));


            if (count($images) < 1 || count($images) > 8) {
                throw new RuntimeException(
                    'Upload between 1 and 8 product images.'
                );
            }

            // Category-specific fields are stored as JSON.
            $attributeFields = [
                'electronics' => [
                    'model_number', 'warranty', 'color', 'storage',
                ],
                'fashion' => [
                    'gender', 'size', 'fashion_color', 'fabric',
                ],
                'grocery' => [
                    'net_weight', 'expiry_date', 'manufacturer', 'food_type',
                ],
                'home' => [
                    'material', 'dimensions', 'item_weight', 'home_type',
                ],
                'beauty' => [
                    'skin_type', 'beauty_quantity',
                    'ingredients', 'beauty_expiry',
                ],
                'other' => ['other_specs'],
            ];

            $attributes = [];

            foreach ($attributeFields[$category] as $field) {
                $value = $this->request->getPost($field);

                if (is_string($value) && trim($value) !== '') {
                    $attributes[$field] = trim($value);
                }
            }

            foreach (['expiry_date', 'beauty_expiry'] as $dateField) {
                if (!isset($attributes[$dateField])) {
                    continue;
                }

                $date = \DateTimeImmutable::createFromFormat(
                    '!Y-m-d',
                    $attributes[$dateField]
                );

                if (!$date || $date->format('Y-m-d') !== $attributes[$dateField]) {
                    throw new RuntimeException('Please enter a valid expiry date.');
                }
            }

            // Validate the seller belongs to the existing sellers table.
            $sellerExists = $db->table('sellers')
                ->where('id', $sellerId)
                ->countAllResults();


            if (!$sellerExists) {
                throw new RuntimeException('Your seller account was not found.');
            }

            // Shared image folder:
            // C:\xampp\htdocs\ajobmart-shared\uploads\products\YYYY\MM\

            // Absolute physical directory used to save images.
            
            $projectRoot = dirname(rtrim(FCPATH, '\\/'));

            $sharedRoot = dirname($projectRoot)
                . DIRECTORY_SEPARATOR
                . 'ajobmart-shared';

            $year  = date('Y');
            $month = date('m');

            $absoluteDir = $sharedRoot
                . DIRECTORY_SEPARATOR . 'uploads'
                . DIRECTORY_SEPARATOR . 'products'
                . DIRECTORY_SEPARATOR . $year
                . DIRECTORY_SEPARATOR . $month
                . DIRECTORY_SEPARATOR;

            $relativeDir = 'uploads/products/' . $year . '/' . $month;

            if (!is_dir($absoluteDir)) {
                if (!mkdir($absoluteDir, 0755, true) && !is_dir($absoluteDir)) {
                    throw new \RuntimeException(
                        'Unable to create directory: ' . $absoluteDir
                    );
                }
            }

            // Temporary debugging: check the exact destination.
            log_message('debug', 'Product image directory: ' . $absoluteDir);


            $convertedImages = [];

            foreach ($images as $index => $file) {

                if (!$file->isValid()) {
                    throw new \RuntimeException(
                        'An uploaded image is invalid.'
                    );
                }

                if ($file->getSize() > 5 * 1024 * 1024) {
                    throw new \RuntimeException(
                        'Each image must be no larger than 5 MB.'
                    );
                }

                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ];

                if (!in_array($file->getMimeType(), $allowedMimeTypes, true)) {
                    throw new \RuntimeException(
                        'Only JPG, PNG and WebP images are supported.'
                    );
                }

                $source = file_get_contents($file->getTempName());

                if ($source === false) {
                    throw new \RuntimeException(
                        'Unable to read an uploaded image.'
                    );
                }

                $imageInfo = @getimagesizefromstring($source);

                if ($imageInfo === false) {
                    throw new \RuntimeException(
                        'An uploaded file is not a valid image.'
                    );
                }

                $width = (int) $imageInfo[0];
                $height = (int) $imageInfo[1];

                if (
                    $width < 1 ||
                    $height < 1 ||
                    $width > 10000 ||
                    $height > 10000 ||
                    ($width * $height) > 25000000
                ) {
                    throw new \RuntimeException(
                        'An image has unsupported dimensions.'
                    );
                }

                $image = @imagecreatefromstring($source);
                unset($source);

                if ($image === false) {
                    throw new \RuntimeException(
                        'Unable to decode image. Check PHP GD support.'
                    );
                }

                // Preserve transparency where supported.
                imagepalettetotruecolor($image);
                imagealphablending($image, false);
                imagesavealpha($image, true);

                // Generate a unique WebP filename.
                $filename = bin2hex(random_bytes(16)) . '.webp';

                // Absolute destination on disk.
                $destination = $absoluteDir . $filename;

                if (!imagewebp($image, $destination, 85)) {
                    imagedestroy($image);

                    throw new \RuntimeException(
                        'WebP conversion failed. Check PHP GD WebP support.'
                    );
                }

                imagedestroy($image);

                // Keep track of files so your existing rollback can delete them.
                $savedFiles[] = $destination;

                // Store only the relative path in the database.
                $convertedImages[] = [
                    'image_name' => $filename,
                    'image_path' => $relativeDir . '/' . $filename,
                    'is_primary' => $index === 0 ? 1 : 0,
                    'sort_order' => $index,
                ];
            }


            $db->transBegin();
            $transactionStarted = true;

            // $productModel = new AjobmartProductModel();
            // $imageModel = new AjobmartProductImageModel();

            $productId = $this->productModel->insert([
                'seller_id'          => $sellerId,
                'category'           => $category,
                'product_name'       => $name,
                'brand'              => trim((string) $this->request->getPost('brand')),
                'sku'                => trim((string) $this->request->getPost('sku')),
                'description'        => $description,
                'product_condition'  => $this->request->getPost('condition'),
                'category_attributes' => json_encode(
                    $attributes,
                    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                ),
                'package_length'     => $this->request->getPost('length') !== ''
                    ? (float) $this->request->getPost('length') : null,
                'package_width'      => $this->request->getPost('width') !== ''
                    ? (float) $this->request->getPost('width') : null,
                'package_height'     => $this->request->getPost('height') !== ''
                    ? (float) $this->request->getPost('height') : null,
                'mrp'                => $mrp,
                'selling_price'      => $price,
                'listing_price'      => $listprice,
                'stock_quantity'     => (int) $this->request->getPost('stock_quantity'),
                'low_stock'          => (int) ($this->request->getPost('low_stock') ?: 5),
                'shipping_weight'    => $this->request->getPost('shipping_weight') !== ''
                    ? (float) $this->request->getPost('shipping_weight')
                    : null,
                'shipping_days'      => (int) $this->request->getPost('shipping_days'),
                'shipping_type'      => $this->request->getPost('shipping_type'),
                'status'             => $this->request->getPost('product_status'),
                'country_of_origin'  => $this->request->getPost('country_of_origin'),
                'hsn_code'           => $this->request->getPost('hsn_code'),
                'manufacturer_name'  => $this->request->getPost('manufacturer_name'),
                'model_number_general' => $this->request->getPost('model_number_general'),
                'key_features'       => $this->request->getPost('key_features')
            ], true);

            if (!$productId) {
                throw new RuntimeException('Unable to save product details.');
            }

            foreach ($convertedImages as $imageData) {
                $imageData['product_id'] = $productId;
                $imageData['created_at'] = date('Y-m-d H:i:s');

                
                $imageId = $this->imageModel->insert($imageData);

                if ($imageId === false) {
                    log_message('error', 'Product image insert failed: {errors}', [
                        'errors' => json_encode($this->imageModel->errors()),
                    ]);

                    throw new \RuntimeException(
                        'Image database insert failed: '
                        . json_encode($this->imageModel->errors())
                    );
                }

            }

            if (!$db->transStatus()) {
                throw new RuntimeException('Database transaction failed.');
            }

            $db->transCommit();
            $transactionStarted = false;

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Product saved successfully.',
                'product_id' => $productId,
                'redirect'   => site_url('seller/dashboard'),
            ]);

        } catch (Throwable $e) {
            if ($transactionStarted) {
                $db->transRollback();
            }

            // Remove image files if the database operation fails.
            foreach ($savedFiles as $path) {
                if (is_file($path)) {
                    @unlink($path);
                }
            }

            log_message('error', 'Seller product save failed: {error}', [
                'error' => $e->getMessage(),
            ]);

                return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Insert your existing product-saving logic here.'
            ]);
        }
    }


    public function inventory()
    {
        $sellerId = $this->session->get('seller_id');

        if ($sellerId <= 0) {
            return redirect()->to('/seller/login');
        }

        $data = [
            'pageTitle' => 'Inventory Management',
            'products'  => $this->productModel
                                ->getSellerInventory($sellerId),
            'stats'     => $this->productModel
                                ->getInventoryStats($sellerId),
        ];

        // Use the layout-loading method already used by your project.
        return $this->view('seller/inventory/index', $data);
    }


    public function shippingAllowance()
{
    $db = $this->db;

    $actualWeightKg = (float) $this->request->getPost('shipping_weight');
    $length = (float) $this->request->getPost('length');
    $width  = (float) $this->request->getPost('width');
    $height = (float) $this->request->getPost('height');

    if (
        $actualWeightKg <= 0 ||
        $length <= 0 ||
        $width <= 0 ||
        $height <= 0
    ) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Enter valid product dimensions and weight.'
        ]);
    }

    // Actual weight in grams
    $actualWeightGrams = $actualWeightKg * 1000;

    // Example volumetric-weight divisor.
    // Confirm the divisor and rounding rules for your courier service.
    $volumetricWeightKg = ($length * $width * $height) / 6000;

    $volumetricWeightGrams = $volumetricWeightKg * 1000;

    // Chargeable weight is the higher of actual and volumetric weight.
    $chargeableWeightGrams = (int) ceil(
        max($actualWeightGrams, $volumetricWeightGrams)
    );

    // Fetch active shipping rates.
    $rates = $db->table('ajobmart_shipping_rates')
        ->where('is_active', 1)
        ->orderBy('min_weight_grams', 'ASC')
        ->get()
        ->getResultArray();

    if (empty($rates)) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'No active shipping rates found.'
        ]);
    }

    $allowance = null;

    if ($chargeableWeightGrams <= 5000) {
        // Find the matching weight slab for each zone.
        foreach ($rates as $rate) {
            $minWeight = (int) $rate['min_weight_grams'];
            $maxWeight = $rate['max_weight_grams'] !== null
                ? (int) $rate['max_weight_grams']
                : PHP_INT_MAX;

            if (
                $chargeableWeightGrams >= $minWeight &&
                $chargeableWeightGrams <= $maxWeight
            ) {
                $charge = (float) $rate['base_charge'];

                // Use the highest matching zone rate.
                $allowance = $allowance === null
                    ? $charge
                    : max($allowance, $charge);
            }
        }
    } else {
        // For weights over 5 kg, use the 4–5 kg slab as the base.
        foreach ($rates as $rate) {
            if (
                (int) $rate['min_weight_grams'] === 4001 &&
                (int) $rate['max_weight_grams'] === 5000
            ) {
                $extraKg = (int) ceil(
                    ($chargeableWeightGrams - 5000) / 1000
                );

                $charge = (float) $rate['base_charge']
                    + ($extraKg * (float) $rate['additional_kg_charge']);

                $allowance = $allowance === null
                    ? $charge
                    : max($allowance, $charge);
            }
        }
    }

    if ($allowance === null) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'No matching shipping rate was found.'
        ]);
    }

    return $this->response->setJSON([
        'status' => true,
        'actual_weight_kg' => round($actualWeightKg, 3),
        'volumetric_weight_kg' => round($volumetricWeightKg, 3),
        'chargeable_weight_grams' => $chargeableWeightGrams,
        'shipping_allowance' => round($allowance, 2)
    ]);
}
}
