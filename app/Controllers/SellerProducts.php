<?php

namespace App\Controllers;
use RuntimeException;
use Throwable;

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
 * Display seller product list page.
 */
public function index()
{
    if (!$this->session->get('seller_id')) {
            return redirect()->to(site_url('seller'));
        }

    return $this->view('seller/products/index', [
        'pageTitle' => 'My Products',
    ]);
}

/**
 * Fetch the logged-in seller's products and primary images.
 */
public function listData()
{
    if (!$this->session->get('seller_id')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status'  => false,
                'message' => 'Please log in to continue.',
            ]);
    }

    $sellerId = (int) $this->session->get('seller_id');

    $sql = "
        SELECT
            p.id,
            p.seller_id,
            p.category_id,
            p.category,
            p.product_name,
            p.brand,
            p.sub_brand,
            p.sku,
            p.mrp,
            p.selling_price,
            p.listing_price,
            p.stock_quantity,
            p.low_stock,
            p.min_order_quantity,
            p.pack_of,
            p.product_condition,
            p.status,
            p.approval_status,
            p.created_at,
            (
                SELECT pi.image_path
                FROM ajobmart_product_images pi
                WHERE pi.product_id = p.id
                ORDER BY
                    pi.is_primary DESC,
                    pi.sort_order ASC,
                    pi.id ASC
                LIMIT 1
            ) AS image_path
        FROM ajobmart_products p
        WHERE p.seller_id = ?
        ORDER BY p.created_at DESC, p.id DESC
    ";

    $products = $this->db
        ->query($sql, [$sellerId])
        ->getResultArray();

    // The URL must point to the publicly accessible shared uploads folder.
    $sharedUploadUrl = 'C:/xampp/htdocs/ajobmart-shared';

    foreach ($products as &$product) {
        $path = trim((string) ($product['image_path'] ?? ''));

        if ($path !== '' && preg_match('~^https?://~i', $path)) {
            $product['image_url'] = $path;
        } elseif ($path !== '') {
            $product['image_url'] = $sharedUploadUrl
                . '/'
                . ltrim(str_replace('\\', '/', $path), '/');
        } else {
            $product['image_url'] = '';
        }

        $product['stock_quantity'] = (int) $product['stock_quantity'];
        $product['low_stock'] = (int) $product['low_stock'];
    }
    unset($product);

    return $this->response->setJSON([
        'status'   => true,
        'products' => $products,
        'count'    => count($products),
    ]);
}
    /**
     * Add Product Page
     */
    public function add()
    {
        if (!$this->session->get('seller_id')) {
            return redirect()->to(site_url('seller'));
        }

        $categories = $this->db->table('ajobmart_categories')
        ->select('id, name, slug')
        ->where('status', 'active')
        ->orderBy('sort_order', 'ASC')
        ->get()
        ->getResultArray();

        return $this->view('seller/products/add', [
            'title' => 'Add New Product',
            'categories' => $categories
        ]);
    }

    
public function getCategoryAttributes($categoryId = null)
{
    $categoryId = (int) $categoryId;

    if ($categoryId <= 0) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Please select a valid category.'
            ]);
    }

    $db = $this->db;

    // Validate category
    $category = $db->table('ajobmart_categories')
        ->select('id, name')
        ->where('id', $categoryId)
        ->where('status', 'active')
        ->get()
        ->getRowArray();

    if (!$category) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Category not found.'
            ]);
    }

    // Read selected subcategory from GET parameters
    $subcategoryId = (int) $this->request->getGet('subcategory_id');

    // Start building the attributes query
    $builder = $db->table('ajobmart_category_attributes')
        ->select(
            'id, category_id, subcategory_id, attribute_name, label, ' .
            'input_type, is_required, options_json, sort_order'
        )
        ->where('category_id', $categoryId)
        ->where('status', 'active');

    if ($subcategoryId > 0) {
        // Ensure the subcategory belongs to the selected category
        $subcategory = $db->table('ajobmart_subcategories')
            ->select('id, category_id, name')
            ->where('id', $subcategoryId)
            ->where('category_id', $categoryId)
            ->where('status', 1)
            ->get()
            ->getRowArray();

        if (!$subcategory) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Subcategory not found.'
                ]);
        }

        // Include general category attributes and selected subcategory attributes
        $builder->groupStart()
            ->where('subcategory_id', null)
            ->orWhere('subcategory_id', $subcategoryId)
            ->groupEnd();
    } else {
        // No subcategory selected: only general category attributes
        $builder->where('subcategory_id', null);
    }

    $attributes = $builder
        ->orderBy('sort_order', 'ASC')
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();

    return $this->response->setJSON([
        'status'       => 'success',
        'category'     => $category,
        'subcategory'  => $subcategory ?? null,
        'attributes'   => $attributes
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

        $saveMode = (string) $this->request->getPost('save_mode');

        if (!in_array($saveMode, ['draft', 'approved'], true)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => 'Invalid product save action.',
            ]);
        }

        $productId = (int) ($this->request->getPost('product_id') ?: 0);

        if ($saveMode === 'draft') {
            return $this->saveDraft();
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

            // $categories = [
            //     'electronics', 'fashion', 'grocery',
            //     'home', 'beauty', 'other',
            // ];

        // echo '<pre>'; print_r($categories); exit;


            
            $categoryId = (int) $this->request->getPost('category');
            $subcategoryId = $this->request->getPost('subcategory_id');

            $subcategoryId = ($subcategoryId !== null && $subcategoryId !== '')
                ? (int) $subcategoryId
                : null;

            if ($subcategoryId !== null) {
                $valid = $this->db
                    ->table('ajobmart_subcategories')
                    ->where('id', $subcategoryId)
                    ->where('category_id', $categoryId)
                    ->where('status', 1)
                    ->countAllResults();

                if (!$valid) {
                    return $this->response->setStatusCode(422)->setJSON([
                        'status'  => 'error',
                        'message' => 'Please select a valid subcategory.',
                    ]);
                }
            }

            // Add these fields to your existing product data array.
            // Keep the rest of your current save logic unchanged.
            // $productData['category_id'] = $categoryId;
            // $productData['subcategory_id'] = $subcategoryId;

            $categoryRow = $db->table('ajobmart_categories')
                ->select('id, name, slug')
                ->where('id', $categoryId)
                ->where('status', 'active')
                ->get()
                ->getRowArray();

            if (!$categoryRow) {
                throw new RuntimeException('Please select a valid category.');
            }

            $categoryId = (int) $categoryRow['id'];
            $category = $categoryRow['slug'];

            $productTypeId = (int) $this->request->getPost('product_type_id');

            $productType = $this->db
                ->table('ajobmart_product_types')
                ->where('id', $productTypeId)
                ->where('subcategory_id', $subcategoryId)
                ->where('status', 1)
                ->get()
                ->getRowArray();

            if (!$productType) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Please select a valid product type for the selected subcategory.',
                ]);
            }

            
            $sku = trim((string) $this->request->getPost('sku'));

            if ($sku === '' || preg_match('/\s/', $sku)) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Enter a valid SKU without spaces.',
                ]);
            }

            $skuQuery = $db->table('ajobmart_products')
                ->where('seller_id', $sellerId)
                ->where('sku', $sku);

            if ($productId > 0) {
                $skuQuery->where('id !=', $productId);
            }

            if ($skuQuery->countAllResults() > 0) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'This SKU is already used by another product.',
                    'errors'  => [
                        'sku' => 'Please enter a different SKU.',
                    ],
                ]);
            }


            $hsnCode = trim(
                (string) $this->request->getPost('hsn_code')
            );

            if (
                $hsnCode !== '' &&
                ! preg_match('/^\d{4}(?:\d{2})?(?:\d{2})?$/', $hsnCode)
            ) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Enter a valid 4, 6 or 8 digit HSN code.');
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
                'product_status' => 'required|in_list[active,inactive]',
            ];

            

            if (!$this->validate($rules)) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Please correct the product details.',
                    'errors'  => $this->validator->getErrors(),
                ]);
            }

            $name = trim((string) $this->request->getPost('product_name'));
            $subBrand = trim((string) $this->request->getPost('sub_brand'));

            $packOf = (int) ($this->request->getPost('pack_of') ?: 1);

            $minOrderQuantity = (int) (
                $this->request->getPost('min_order_quantity') ?: 1
            );

            if ($packOf < 1 || $minOrderQuantity < 1) {
                throw new \RuntimeException(
                    'Pack of and minimum order quantity must be at least 1.'
                );
            }
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

            

            // Category-specific fields are stored as JSON.
            
            $postedAttributes = $this->request->getPost('attributes') ?? [];

            if (!is_array($postedAttributes)) {
                throw new RuntimeException('Invalid category attribute data.');
            }

            $categoryAttributeRows = $db->table('ajobmart_category_attributes')
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->orderBy('sort_order', 'ASC')
                ->get()
                ->getResultArray();

            $allowedAttributes = [];
            $attributes = [];          // For ajobmart_products.category_attributes
            $attributeValuesToSave = []; // For ajobmart_product_attribute_values

            foreach ($categoryAttributeRows as $attribute) {
                $attributeId = (int) $attribute['id'];
                $allowedAttributes[$attributeId] = $attribute;
            }

            // Reject submitted IDs that don't belong to this category.
            foreach ($postedAttributes as $submittedId => $submittedValue) {
                if (!ctype_digit((string) $submittedId)
                    || !isset($allowedAttributes[(int) $submittedId])) {
                    throw new RuntimeException(
                        'An invalid attribute was submitted for this category.'
                    );
                }

                if (!is_scalar($submittedValue) && $submittedValue !== null) {
                    throw new RuntimeException('Invalid category attribute value.');
                }
            }

            foreach ($categoryAttributeRows as $attribute) {
                $attributeId = (int) $attribute['id'];
                $attributeName = $attribute['attribute_name'];
                $label = $attribute['label'] ?: $attributeName;

                $rawValue = $postedAttributes[$attributeId] ?? '';
                $value = is_scalar($rawValue) ? trim((string) $rawValue) : '';

                // Check required attributes on the server.
                if ((int) $attribute['is_required'] === 1 && $value === '') {
                    throw new RuntimeException($label . ' is required.');
                }

                // Empty optional attributes are not stored.
                if ($value === '') {
                    continue;
                }

                // Validate dropdown values against the database options.
                if (strtolower($attribute['input_type']) === 'select') {
                    $options = json_decode(
                        $attribute['options_json'] ?? '[]',
                        true
                    );

                    if (!is_array($options)
                        || !in_array($value, $options, true)) {
                        throw new RuntimeException(
                            'Please select a valid option for ' . $label . '.'
                        );
                    }
                }

                // Validate date fields when the attribute is a date.
                if (strtolower($attribute['input_type']) === 'date') {
                    $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $value);

                    if (!$date || $date->format('Y-m-d') !== $value) {
                        throw new RuntimeException(
                            'Please enter a valid date for ' . $label . '.'
                        );
                    }
                }

                // Legacy JSON format, keyed by attribute name.
                $attributes[$attributeName] = $value;

                // Normalized table format, keyed by attribute ID.
                $attributeValuesToSave[] = [
                    'attribute_id'    => $attributeId,
                    'attribute_value' => $value,
                ];
            }

            
$images = $this->request->getFileMultiple('product_images') ?? [];

$images = array_values(array_filter(
    $images,
    static fn ($file) =>
        $file instanceof \CodeIgniter\HTTP\Files\UploadedFile
        && $file->getError() !== UPLOAD_ERR_NO_FILE
));

// Existing images submitted by the form.
$removedImageIds = $this->request->getPost('removed_image_ids') ?? [];

if (!is_array($removedImageIds)) {
    $removedImageIds = [];
}

// Count existing images that will remain after removals.
// Only count images belonging to this product and seller.
$existingImageCount = 0;

if ($productId > 0) {
    $productExists = $db->table('ajobmart_products')
        ->where('id', $productId)
        ->where('seller_id', $sellerId)
        ->countAllResults();

    if (!$productExists) {
        return $this->response->setStatusCode(404)->setJSON([
            'status'  => 'error',
            'message' => 'Product not found or you do not have permission to edit it.',
        ]);
    }

    $existingImagesQuery = $db->table('ajobmart_product_images')
        ->where('product_id', $productId);

    if (!empty($removedImageIds)) {
        $removedImageIds = array_values(array_unique(array_filter(
            array_map('intval', $removedImageIds),
            static fn ($id) => $id > 0
        )));

        if (!empty($removedImageIds)) {
            $existingImagesQuery->whereNotIn('id', $removedImageIds);
        }
    }

    $existingImageCount = $existingImagesQuery->countAllResults();
}

$totalImageCount = $existingImageCount + count($images);

if ($totalImageCount < 1 || $totalImageCount > 8) {
    throw new \RuntimeException(
        'A product must have between 1 and 8 images in total.'
    );
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

            $sharedRoot = 'C:\\xampp\\htdocs\\ajobmart-shared';


            $year  = date('Y');
            $month = date('m');

            $absoluteDir = $sharedRoot
                . DIRECTORY_SEPARATOR . 'uploads'
                . DIRECTORY_SEPARATOR . 'products'
                . DIRECTORY_SEPARATOR . $year
                . DIRECTORY_SEPARATOR . $month
                . DIRECTORY_SEPARATOR;

            // Relative path stored in the database.
            $relativeDir = 'uploads/products/' . $year . '/' . $month;

            // Create the directory if needed.
            if (!is_dir($absoluteDir)) {
                if (!mkdir($absoluteDir, 0755, true) && !is_dir($absoluteDir)) {
                    throw new RuntimeException(
                        'Cannot create shared upload directory: ' . $absoluteDir
                    );
                }
            }

            if (!is_writable($absoluteDir)) {
                throw new RuntimeException(
                    'Shared upload directory is not writable: ' . $absoluteDir
                );
            }

            log_message('debug', 'Project root: ' . $projectRoot);
            log_message('debug', 'Shared root: ' . $sharedRoot);
            log_message('debug', 'Image destination: ' . $absoluteDir);




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

            
            $productData = [
                'seller_id'            => $sellerId,
                'category_id'          => $categoryId,
                'subcategory_id'       => $subcategoryId,
                'shipping_allowance'   => (float) (
                    $this->request->getPost('shipping_allowance') ?: 0
                ),
                'category'             => $category,
                'product_name'         => $name,
                'brand'                => trim((string) $this->request->getPost('brand')),
                'sub_brand'            => $subBrand !== '' ? $subBrand : null,
                'pack_of'              => $packOf,
                'min_order_quantity'   => $minOrderQuantity,
                'sku'                  => $sku,
                'description'          => $description,
                'product_condition'    => $this->request->getPost('condition'),

                'category_attributes'  => json_encode(
                    $attributes,
                    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                ),

                'package_length'       => $this->request->getPost('length') !== ''
                    ? (float) $this->request->getPost('length') : null,

                'package_width'        => $this->request->getPost('width') !== ''
                    ? (float) $this->request->getPost('width') : null,

                'package_height'       => $this->request->getPost('height') !== ''
                    ? (float) $this->request->getPost('height') : null,

                'mrp'                  => $mrp,
                'selling_price'        => $price,
                'listing_price'        => $listprice,
                'stock_quantity'       => (int) $this->request->getPost('stock_quantity'),
                'low_stock'            => (int) ($this->request->getPost('low_stock') ?: 5),

                'shipping_weight'      => $this->request->getPost('shipping_weight') !== ''
                    ? (float) $this->request->getPost('shipping_weight') : null,

                'shipping_days'        => (int) $this->request->getPost('shipping_days'),
                'shipping_type'        => $this->request->getPost('shipping_type'),
                'status'               => $this->request->getPost('product_status'),

                'approval_status'      => 'pending',
                'country_of_origin'    => $this->request->getPost('country_of_origin'),
                'hsn_code'             => $hsnCode !== '' ? $hsnCode : null,
                'manufacturer_name'    => $this->request->getPost('manufacturer_name'),
                'packer_name'          => $this->request->getPost('packer_name'),
                'model_number_general' => $this->request->getPost('model_number_general'),
                'key_features'         => $this->request->getPost('key_features'),
                'product_type_id'      => $productTypeId,
            ];

            // UPDATE existing product; INSERT a new product.
            if ($productId > 0) {

                $updated = $this->productModel->update(
                    $productId,
                    $productData
                );

                if ($updated === false) {
                    throw new RuntimeException(
                        'Unable to update product details: '
                        . json_encode($this->productModel->errors())
                    );
                }

                log_message('info', 'Seller product updated: ' . $productId);

            } else {

                $newProductId = $this->productModel->insert(
                    $productData,
                    true
                );

                if (!$newProductId) {
                    throw new RuntimeException(
                        'Unable to save product details: '
                        . json_encode($this->productModel->errors())
                    );
                }

                $productId = (int) $newProductId;

                log_message('info', 'Seller product inserted: ' . $productId);
            }


            
            // Remove existing attribute values only for this product.
            if ($productId > 0) {
                $db->table('ajobmart_product_attribute_values')
                    ->where('product_id', $productId)
                    ->delete();
            }

            // Insert the current attribute values.
            if (!empty($attributeValuesToSave)) {
                $now = date('Y-m-d H:i:s');
                $attributeInsertRows = [];

                foreach ($attributeValuesToSave as $attributeValue) {
                    $attributeInsertRows[] = [
                        'product_id'      => (int) $productId,
                        'attribute_id'    => (int) $attributeValue['attribute_id'],
                        'attribute_value' => $attributeValue['attribute_value'],
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                }

                if ($db->table('ajobmart_product_attribute_values')
                    ->insertBatch($attributeInsertRows) === false) {
                    throw new RuntimeException(
                        'Unable to save category-specific product attributes.'
                    );
                }
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
                'message'    => $productId > 0
                    ? 'Product updated successfully.'
                    : 'Product saved successfully.',
                'product_id' => $productId,
                'redirect'   => site_url('seller/dashboard'),
            ]);

        
} catch (\Throwable $e) {
    if ($transactionStarted) {
        $db->transRollback();
    }

    // Remove uploaded files if the database operation fails.
    foreach ($savedFiles as $path) {
        if (is_file($path)) {
            @unlink($path);
        }
    }

    log_message('error', 'Seller product save failed: {error}', [
        'error' => $e->getMessage(),
        'file'  => $e->getFile(),
        'line'  => $e->getLine(),
    ]);

    return $this->response
        ->setStatusCode(500)
        ->setJSON([
            'status'  => 'error',
            'message' => 'Product could not be saved: ' . $e->getMessage(),
        ]);
}

    }


    

private function saveDraft(): ResponseInterface
{
    $db = $this->db;

    $sellerId = (int) ($this->session->get('seller_id') ?? 0);
    $productId = (int) ($this->request->getPost('product_id') ?? 0);

    $transactionStarted = false;
    $uploadedFiles = [];

    if ($sellerId <= 0) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Please log in to your seller account.',
            ]);
    }

    try {
        // --------------------------------------------------
        // VERIFY SELLER
        // --------------------------------------------------
        $sellerExists = $db->table('sellers')
            ->where('id', $sellerId)
            ->countAllResults();

        if (!$sellerExists) {
            throw new \RuntimeException('Seller account not found.');
        }

        // --------------------------------------------------
        // VALIDATE CATEGORY
        // --------------------------------------------------
        $categoryId = (int) ($this->request->getPost('category') ?? 0);

        if ($categoryId <= 0) {
            throw new \RuntimeException(
                'Please select a category before saving your draft.'
            );
        }

        $categoryRow = $db->table('ajobmart_categories')
            ->select('id, slug')
            ->where('id', $categoryId)
            ->where('status', 'active')
            ->get()
            ->getRowArray();

        if (!$categoryRow) {
            throw new \RuntimeException('Please select a valid category.');
        }

        // --------------------------------------------------
        // FIND EXISTING DRAFT AND VERIFY OWNERSHIP
        // --------------------------------------------------
        $existing = null;

        if ($productId > 0) {
            $existing = $db->table('ajobmart_products')
                ->where('id', $productId)
                ->where('seller_id', $sellerId)
                ->where('approval_status', 'draft')
                ->get()
                ->getRowArray();

            if (!$existing) {
                throw new \RuntimeException(
                    'Draft not found or you do not have permission to edit it.'
                );
            }

            if ((int) $existing['category_id'] !== $categoryId) {
                throw new \RuntimeException(
                    'The category of an existing draft cannot be changed.'
                );
            }
        }

        // --------------------------------------------------
        // PRODUCT FIELD MAPPING
        // --------------------------------------------------
        $fields = [
            'product_name'        => 'product_name',
            'brand'               => 'brand',
            'sub_brand'           => 'sub_brand',
            'sku'                 => 'sku',
            'description'         => 'description',
            'condition'           => 'product_condition',

            'mrp'                 => 'mrp',
            'selling_price'       => 'selling_price',
            'final_listing_price' => 'listing_price',
            'shipping_allowance'  => 'shipping_allowance',

            'stock_quantity'      => 'stock_quantity',
            'low_stock'           => 'low_stock',

            'shipping_weight'     => 'shipping_weight',
            'shipping_days'       => 'shipping_days',
            'shipping_type'       => 'shipping_type',

            'length'              => 'package_length',
            'width'               => 'package_width',
            'height'              => 'package_height',

            'country_of_origin'   => 'country_of_origin',
            'hsn_code'            => 'hsn_code',
            'gst_value'            => 'gst_value',

            'manufacturer_name'   => 'manufacturer_name',
            'packer_name'         => 'packer_name',
            'key_features'        => 'key_features',

            'pack_of'              => 'pack_of',
            'min_order_quantity'  => 'min_order_quantity',

            'subcategory_id'      => 'subcategory_id',
            'product_type_id'     => 'product_type_id',
        ];

        $decimalColumns = [
            'mrp',
            'selling_price',
            'listing_price',
            'shipping_allowance',
            'shipping_weight',
            'package_length',
            'package_width',
            'package_height',
            'gst_value',
        ];

        $integerColumns = [
            'stock_quantity',
            'low_stock',
            'shipping_days',
            'pack_of',
            'min_order_quantity',
            'subcategory_id',
            'product_type_id',
        ];

        // --------------------------------------------------
        // BUILD PRODUCT DATA
        // --------------------------------------------------
        $now = date('Y-m-d H:i:s');

        $data = [
            'seller_id'       => $sellerId,
            'category_id'     => $categoryId,
            'category'        => $categoryRow['slug'],
            'status'          => 'inactive',
            'approval_status' => 'draft',
            'updated_at'      => $now,
        ];

        foreach ($fields as $postKey => $column) {
            $value = $this->request->getPost($postKey);

            // Preserve previously saved values when omitted.
            if ($value === null || $value === '') {
                continue;
            }

            if (!is_scalar($value)) {
                throw new \RuntimeException(
                    'Invalid value submitted for ' . $postKey . '.'
                );
            }

            $value = is_string($value) ? trim($value) : $value;

            if (in_array($column, $decimalColumns, true)) {
                if (!is_numeric($value)) {
                    throw new \RuntimeException(
                        'Invalid numeric value for ' . $postKey . '.'
                    );
                }

                $value = (float) $value;
            } elseif (in_array($column, $integerColumns, true)) {
                if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                    throw new \RuntimeException(
                        'Invalid integer value for ' . $postKey . '.'
                    );
                }

                $value = (int) $value;
            }

            $data[$column] = $value;
        }

        // --------------------------------------------------
        // CATEGORY-SPECIFIC ATTRIBUTES
        // --------------------------------------------------
        $postedAttributes = $this->request->getPost('attributes');

        if ($postedAttributes !== null) {
            if (!is_array($postedAttributes)) {
                throw new \RuntimeException(
                    'Invalid category attributes submitted.'
                );
            }

            $attributeRows = $db->table('ajobmart_category_attributes')
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->get()
                ->getResultArray();

            $allowed = [];

            foreach ($attributeRows as $row) {
                $allowed[(int) $row['id']] = $row;
            }

            $attributes = [];

            foreach ($postedAttributes as $id => $value) {
                if (
                    !ctype_digit((string) $id) ||
                    !isset($allowed[(int) $id])
                ) {
                    throw new \RuntimeException(
                        'Invalid category attribute submitted.'
                    );
                }

                if (!is_scalar($value) && $value !== null) {
                    throw new \RuntimeException(
                        'Invalid category attribute value.'
                    );
                }

                $value = trim((string) ($value ?? ''));

                if ($value !== '') {
                    $attributes[
                        $allowed[(int) $id]['attribute_name']
                    ] = $value;
                }
            }

            $data['category_attributes'] = json_encode(
                $attributes,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            );
        }

        // --------------------------------------------------
        // DEFAULTS FOR NEW DRAFTS
        // --------------------------------------------------
        if (!$existing) {
            $defaults = [
                'product_name'        => 'Untitled draft',
                'description'         => null,
                'product_condition'   => 'new',
                'category_attributes' => '{}',
                'mrp'                 => 0,
                'selling_price'       => 0,
                'listing_price'       => 0,
                'shipping_allowance'  => 0,
                'stock_quantity'      => 0,
                'low_stock'            => 5,
                'pack_of'              => 1,
                'min_order_quantity'  => 1,
                'shipping_days'       => 1,
                'shipping_type'       => 'platform',
                'created_at'          => $now,
            ];

            $data = array_replace($defaults, $data);

            $data['status'] = 'inactive';
            $data['approval_status'] = 'draft';
        }

        // --------------------------------------------------
        // VALIDATE IMAGE UPLOADS
        // --------------------------------------------------
        $files = $this->request->getFileMultiple('product_images') ?? [];

        $files = array_values(array_filter(
            $files,
            static fn($file) =>
                $file !== null &&
                $file->getError() !== UPLOAD_ERR_NO_FILE
        ));

        $primaryImageIndex = $this->request->getPost(
            'primary_image_index'
        );

        $primaryImageIndex = (
            $primaryImageIndex !== null &&
            $primaryImageIndex !== ''
        ) ? (int) $primaryImageIndex : -1;

        $imageTable = $db->table('ajobmart_product_images');

        $existingImageCount = $imageTable
            ->where('product_id', $productId)
            ->countAllResults();

        if (($existingImageCount + count($files)) > 8) {
            throw new \RuntimeException(
                'A product can have a maximum of 8 images in total.'
            );
        }

        if (
            count($files) > 0 &&
            $primaryImageIndex !== -1 &&
            (
                $primaryImageIndex < 0 ||
                $primaryImageIndex >= count($files)
            )
        ) {
            throw new \RuntimeException(
                'Please select a valid primary product image.'
            );
        }

        // --------------------------------------------------
        // SHARED UPLOAD DIRECTORY
        // --------------------------------------------------
        $sharedUploadRoot = trim(
            (string) env('AJOBMART_SHARED_UPLOAD_PATH')
        );

        $sharedUploadRoot = rtrim($sharedUploadRoot, '/\\');

        if (count($files) > 0 && $sharedUploadRoot === '') {
            throw new \RuntimeException(
                'Product image upload path is not configured.'
            );
        }

        $relativeDirectory = 'uploads/products/' . date('Y/m');

        $absoluteDirectory = $sharedUploadRoot !== ''
            ? $sharedUploadRoot . DIRECTORY_SEPARATOR .
                str_replace(
                    '/',
                    DIRECTORY_SEPARATOR,
                    $relativeDirectory
                )
            : '';

        // --------------------------------------------------
        // VALIDATE IMAGE FILES BEFORE STARTING TRANSACTION
        // --------------------------------------------------
        foreach ($files as $file) {
            if (!$file->isValid() || $file->hasMoved()) {
                throw new \RuntimeException(
                    'One of the uploaded images is invalid.'
                );
            }

            if ($file->getSizeByUnit('mb') > 5) {
                throw new \RuntimeException(
                    'Each image must be 5 MB or smaller.'
                );
            }

            $mime = $file->getMimeType();

            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/webp',
            ];

            if (!in_array($mime, $allowedMimeTypes, true)) {
                throw new \RuntimeException(
                    'Only JPG, JPEG, PNG, and WebP images are allowed.'
                );
            }

            $imageInfo = @getimagesize($file->getTempName());

            if ($imageInfo === false) {
                throw new \RuntimeException(
                    'An uploaded file is not a valid image.'
                );
            }

            if (
                $imageInfo[0] < 1 ||
                $imageInfo[1] < 1 ||
                $imageInfo[0] > 10000 ||
                $imageInfo[1] > 10000
            ) {
                throw new \RuntimeException(
                    'Image dimensions must not exceed 10000 × 10000 pixels.'
                );
            }
        }

        if (
            count($files) > 0 &&
            (
                !extension_loaded('gd') ||
                !function_exists('imagewebp')
            )
        ) {
            throw new \RuntimeException(
                'WebP conversion is unavailable. Enable PHP GD with WebP support.'
            );
        }

        // --------------------------------------------------
        // START DATABASE TRANSACTION
        // --------------------------------------------------
        $db->transBegin();
        $transactionStarted = true;

        // --------------------------------------------------
        // INSERT OR UPDATE DRAFT
        // --------------------------------------------------
        if ($existing) {
            $ok = $this->productModel->update($productId, $data);

            if (!$ok) {
                $errors = $this->productModel->errors();

                throw new \RuntimeException(
                    !empty($errors)
                        ? implode(' ', $errors)
                        : 'Unable to update the product draft.'
                );
            }
        } else {
            $newProductId = $this->productModel->insert($data, true);

            if (!$newProductId) {
                $errors = $this->productModel->errors();

                throw new \RuntimeException(
                    !empty($errors)
                        ? implode(' ', $errors)
                        : 'Unable to create the product draft.'
                );
            }

            $productId = (int) $newProductId;
        }

        // --------------------------------------------------
        // VERIFY DRAFT OWNERSHIP BEFORE SAVING IMAGES
        // --------------------------------------------------
        if (count($files) > 0) {
            $ownedDraft = $db->table('ajobmart_products')
                ->where('id', $productId)
                ->where('seller_id', $sellerId)
                ->where('approval_status', 'draft')
                ->countAllResults();

            if (!$ownedDraft) {
                throw new \RuntimeException(
                    'Draft not found or you do not have permission to upload its images.'
                );
            }

            if (
                !is_dir($absoluteDirectory) &&
                !mkdir($absoluteDirectory, 0755, true) &&
                !is_dir($absoluteDirectory)
            ) {
                throw new \RuntimeException(
                    'Unable to create the product image directory.'
                );
            }

            // Check whether a primary image already exists.
            $hasExistingPrimary = $imageTable
                ->where('product_id', $productId)
                ->where('is_primary', 1)
                ->countAllResults() > 0;

            foreach ($files as $index => $file) {
                // All uploaded files are saved as .webp.
                $newName = bin2hex(random_bytes(16)) . '.webp';

                $absolutePath = $absoluteDirectory .
                    DIRECTORY_SEPARATOR . $newName;

                // Convert the original image directly into WebP.
                $converted = $this->convertImageToWebp(
                    $file,
                    $absolutePath,
                    82
                );

                if (!$converted) {
                    throw new \RuntimeException(
                        'Unable to convert one of the uploaded images to WebP.'
                    );
                }

                // Track files so they can be removed if the DB transaction fails.
                $uploadedFiles[] = $absolutePath;

                // Respect the selected primary image.
                // If none is selected, keep the existing primary image.
                // If no primary exists yet, use the first new image.
                $isPrimary = (
                    $primaryImageIndex === $index ||
                    (
                        $primaryImageIndex === -1 &&
                        !$hasExistingPrimary &&
                        $index === 0
                    )
                ) ? 1 : 0;

                if ($isPrimary) {
                    $db->table('ajobmart_product_images')
                        ->where('product_id', $productId)
                        ->update(['is_primary' => 0]);

                    $hasExistingPrimary = true;
                }

                $inserted = $db->table('ajobmart_product_images')->insert([
                    'product_id' => $productId,
                    'image_name' => $newName,
                    'image_path' => $relativeDirectory . '/' . $newName,
                    'is_primary' => $isPrimary,
                    'sort_order' => $existingImageCount + $index,
                    'created_at' => $now,
                ]);

                if (!$inserted) {
                    throw new \RuntimeException(
                        'Unable to save the product image record.'
                    );
                }
            }
        }

        // --------------------------------------------------
        // COMMIT TRANSACTION
        // --------------------------------------------------
        if ($db->transStatus() === false) {
            throw new \RuntimeException(
                'Draft database transaction failed.'
            );
        }

        $db->transCommit();
        $transactionStarted = false;

        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => $existing
                ? 'Product draft and images saved successfully.'
                : 'Product draft and images created successfully.',
            'product_id' => $productId,
        ]);

    } catch (\Throwable $e) {
        if ($transactionStarted) {
            $db->transRollback();
        }

        // Remove newly created WebP files if saving fails.
        foreach ($uploadedFiles as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }

        log_message(
            'error',
            'Product draft save failed: {error}',
            ['error' => $e->getMessage()]
        );

        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
    }
}



private function convertImageToWebp(
    \CodeIgniter\HTTP\Files\UploadedFile $file,
    string $destination,
    int $quality = 82
): bool {
    if (
        !$file->isValid() ||
        $file->hasMoved() ||
        !function_exists('imagewebp')
    ) {
        return false;
    }

    $tempPath = $file->getTempName();
    $imageInfo = @getimagesize($tempPath);

    if ($imageInfo === false) {
        return false;
    }

    $mime = $imageInfo['mime'] ?? '';

    switch ($mime) {
        case 'image/jpeg':
            $image = @imagecreatefromjpeg($tempPath);
            break;

        case 'image/png':
            $image = @imagecreatefrompng($tempPath);
            break;

        case 'image/webp':
            $image = function_exists('imagecreatefromwebp')
                ? @imagecreatefromwebp($tempPath)
                : false;
            break;

        default:
            return false;
    }

    if (!$image) {
        return false;
    }

    $directory = dirname($destination);

    if (
        !is_dir($directory) &&
        !mkdir($directory, 0755, true) &&
        !is_dir($directory)
    ) {
        imagedestroy($image);
        return false;
    }

    // Preserve transparent backgrounds for PNG and WebP.
    imagepalettetotruecolor($image);
    imagealphablending($image, false);
    imagesavealpha($image, true);

    $quality = max(0, min(100, $quality));

    $saved = imagewebp($image, $destination, $quality);

    imagedestroy($image);

    if (
        !$saved ||
        !is_file($destination) ||
        filesize($destination) <= 0
    ) {
        if (is_file($destination)) {
            @unlink($destination);
        }

        return false;
    }

    return true;
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

public function subcategories($categoryId)
{
    if (!ctype_digit((string) $categoryId) || (int) $categoryId < 1) {
        return $this->response->setStatusCode(400)->setJSON([
            'status'  => 'error',
            'message' => 'Invalid category.',
        ]);
    }

    $subcategories = $this->db
        ->table('ajobmart_subcategories')
        ->select('id, name')
        ->where('category_id', (int) $categoryId)
        ->where('status', 1)
        ->orderBy('sort_order', 'ASC')
        ->orderBy('name', 'ASC')
        ->get()
        ->getResultArray();

    return $this->response->setJSON([
        'status'        => 'success',
        'subcategories' => $subcategories,
    ]);
}

public function productTypes($subcategoryId = null)
{
    if (
        $subcategoryId === null ||
        !ctype_digit((string) $subcategoryId) ||
        (int) $subcategoryId < 1
    ) {
        return $this->response->setStatusCode(400)->setJSON([
            'status'  => 'error',
            'message' => 'Invalid subcategory ID.',
        ]);
    }

    $productTypes = $this->db
        ->table('ajobmart_product_types')
        ->select('id, name')
        ->where('subcategory_id', (int) $subcategoryId)
        ->where('status', 1)
        ->orderBy('sort_order', 'ASC')
        ->orderBy('name', 'ASC')
        ->get()
        ->getResultArray();

    return $this->response->setJSON([
        'status'       => 'success',
        'productTypes' => $productTypes,
    ]);
}

        public function updateStock()
{
    // Return JSON responses for AJAX requests.
    $isAjax = $this->request->isAJAX();

    $productId = (int) $this->request->getPost('product_id');
    $stock = $this->request->getPost('stock_quantity');

    // Support JSON payloads sent by fetch().
    if ($this->request->getHeaderLine('Content-Type')
        && strpos(
            $this->request->getHeaderLine('Content-Type'),
            'application/json'
        ) !== false
    ) {
        $data = $this->request->getJSON(true);

        $productId = (int) ($data['product_id'] ?? 0);
        $stock = $data['stock_quantity'] ?? null;
    }

    $respond = function (bool $success, string $message, int $status = 200) use ($isAjax) {
        if ($isAjax) {
            return $this->response
                ->setStatusCode($status)
                ->setJSON([
                    'success' => $success,
                    'message' => $message,
                ]);
        }

        return redirect()->back()->with(
            $success ? 'success' : 'error',
            $message
        );
    };

    // Validate product ID.
    if ($productId <= 0) {
        return $respond(false, 'Invalid product selected.', 400);
    }

    // Validate stock quantity.
    if (
        $stock === null ||
        $stock === '' ||
        !is_scalar($stock) ||
        !preg_match('/^\d+$/', (string) $stock)
    ) {
        return $respond(false, 'Enter a valid stock quantity.', 400);
    }

    $stock = (int) $stock;

    // Ensure the seller is logged in.
    $sellerId = (int) session()->get('seller_id');

    if ($sellerId <= 0) {
        return $respond(false, 'Please log in again.', 401);
    }

    $db = $this->db;

    // Confirm the product belongs to the logged-in seller.
    $product = $db->table('ajobmart_products')
        ->select('id, stock_quantity')
        ->where('id', $productId)
        ->where('seller_id', $sellerId)
        ->get()
        ->getRowArray();

    if (!$product) {
        return $respond(false, 'Product not found or access denied.', 404);
    }

    // Skip unnecessary database updates.
    if ((int) $product['stock_quantity'] === $stock) {
        return $respond(true, 'Stock is already up to date.');
    }

    // Update ONLY stock quantity.
    $updated = $db->table('ajobmart_products')
        ->where('id', $productId)
        ->where('seller_id', $sellerId)
        ->update([
            'stock_quantity' => $stock,
        ]);

    if (!$updated || $db->affectedRows() < 0) {
        return $respond(false, 'Unable to update stock. Please try again.', 500);
    }

    return $respond(true, 'Stock updated successfully.');
}



public function getDraft(int $id): ResponseInterface
{
    $sellerId = (int) ($this->session->get('seller_id') ?? 0);

    if ($sellerId <= 0) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Please log in.',
            ]);
    }

    $product = $this->db->table('ajobmart_products p')
    ->select('p.*, c.name AS category_name, c.slug AS category_slug')
    ->join(
        'ajobmart_categories c',
        'c.id = p.category_id',
        'left'
    )
    ->where('p.id', $id)
    ->where('p.seller_id', $sellerId)
    ->groupStart()
        ->where('p.status', 'inactive')
        ->orWhere('p.approval_status', 'draft')
    ->groupEnd()
    ->get()
    ->getRowArray();

    if (!$product) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Product not found or cannot be edited.',
            ]);
    }

    $attributes = json_decode(
        $product['category_attributes'] ?? '{}',
        true
    ) ?: [];

    $images = $this->db->table('ajobmart_product_images')
    ->where('product_id', $id)
    ->orderBy('sort_order', 'ASC')
    ->orderBy('id', 'ASC')
    ->get()
    ->getResultArray();

foreach ($images as &$image) {
    $path = str_replace(
        '\\',
        '/',
        trim((string) ($image['image_path'] ?? ''))
    );

    // Remove a leading slash.
    $path = ltrim($path, '/');

    // If the database stores a full filesystem path, remove the
    // shared upload directory prefix.
    $sharedPath = str_replace(
        '\\',
        '/',
        rtrim(getenv('AJOBMART_SHARED_UPLOAD_PATH') ?: '', '/')
    );

    if ($sharedPath !== '' && stripos($path, $sharedPath . '/') === 0) {
        $path = substr($path, strlen($sharedPath) + 1);
    }

    // Generate a browser-accessible URL through the CI4 route.
    $image['url'] = site_url('shared-images/' . $path);
}
unset($image);

    return $this->response->setJSON([
        'status'     => 'success',
        'product'    => $product,
        'attributes' => $attributes,
        'images'     => $images,
    ]);
}



public function checkSku(): ResponseInterface
{
    $sellerId = $this->session->get('seller_id');

    if (!$sellerId) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'available' => false,
                'message'   => 'Please log in to your seller account.',
            ]);
    }

    $sku = trim((string) $this->request->getGet('sku'));
    $productId = (int) ($this->request->getGet('product_id') ?: 0);

    if ($sku === '' || preg_match('/\s/', $sku)) {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'available' => false,
                'message'   => 'Enter a valid SKU without spaces.',
            ]);
    }

    $builder = $this->db->table('ajobmart_products')
        ->where('seller_id', $sellerId)
        ->where('sku', $sku);

    if ($productId > 0) {
        $builder->where('id !=', $productId);
    }

    $exists = $builder->countAllResults() > 0;

    return $this->response->setJSON([
        'available' => !$exists,
        'message'   => $exists
            ? 'This SKU is already used by another product.'
            : 'SKU is available.',
    ]);
}


}
