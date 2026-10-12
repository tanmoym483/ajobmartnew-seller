<?php

namespace App\Controllers;

use App\Models\AjobmartProductModel;
use App\Models\AjobmartProductImageModel;
use CodeIgniter\HTTP\ResponseInterface;

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
            $sellerId = session()->get('seller_id');

            if (!$sellerId) {
                return $this->response->setStatusCode(401)->setJSON([
                    'status'  => 'error',
                    'message' => 'Please log in to your seller account.',
                ]);
            }

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

            if ($price > $mrp) {
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
            $absoluteDir = rtrim(dirname(FCPATH), DIRECTORY_SEPARATOR)
                . DIRECTORY_SEPARATOR
                . 'ajobmart-shared'
                . DIRECTORY_SEPARATOR
                . 'uploads'
                . DIRECTORY_SEPARATOR
                . 'products'
                . DIRECTORY_SEPARATOR
                . date('Y')
                . DIRECTORY_SEPARATOR
                . date('m')
                . DIRECTORY_SEPARATOR;

            // Relative path saved in the database.
            $relativeDir = 'uploads/products/'
                . date('Y')
                . '/'
                . date('m');

            // Create the shared directory if it doesn't exist.
            if (!is_dir($absoluteDir)
                && !mkdir($absoluteDir, 0755, true)
                && !is_dir($absoluteDir)) {
                throw new \RuntimeException(
                    'Unable to create shared product image directory.'
                );
            }

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
                'mrp'                => $mrp,
                'selling_price'      => $price,
                'stock_quantity'     => (int) $this->request->getPost('stock_quantity'),
                'low_stock'          => (int) ($this->request->getPost('low_stock') ?: 5),
                'shipping_weight'    => $this->request->getPost('shipping_weight') !== ''
                    ? (float) $this->request->getPost('shipping_weight')
                    : null,
                'shipping_days'      => (int) $this->request->getPost('shipping_days'),
                'shipping_type'      => $this->request->getPost('shipping_type'),
                'status'             => $this->request->getPost('product_status'),
            ], true);

            if (!$productId) {
                throw new RuntimeException('Unable to save product details.');
            }

            foreach ($convertedImages as $imageData) {
                $imageData['product_id'] = $productId;
                $imageData['created_at'] = date('Y-m-d H:i:s');

                if (!$this->imageModel->insert($imageData)) {
                    throw new RuntimeException('Unable to save product image details.');
                }
            }

            if (!$db->transStatus()) {
                throw new RuntimeException('Database transaction failed.');
            }

            $db->transCommit();
            $transactionStarted = false;

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Product saved successfully. All images converted to WebP.',
                'product_id' => $productId,
                'redirect'   => site_url('seller/products/add'),
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
}
