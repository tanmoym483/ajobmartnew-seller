<style>

    


/* Prevent the product form and gallery from expanding beyond their parent */
.layout,
.layout > main,
#productForm,
#productForm .product-step,
#productForm .field {
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;
}

#productForm .product-step {
    overflow: visible;
}

#imagePreview {
    justify-content: start;
}


/* Product image gallery */
#imagePreview {
    display: grid !important;
    grid-template-columns: repeat(5, minmax(0, 172px));
    gap: 24px 16px;
    align-items: start;
    justify-content: start;
    width: 100%;
    max-width: 100%;
    margin-top: 16px;
    overflow: visible;
    box-sizing: border-box;
}

/* Each image card */
#imagePreview > .image-item,
#imagePreview > .image-add-tile {
    position: relative;
    width: 100%;
    min-width: 0;
    max-width: 172px;
    margin: 0;
    box-sizing: border-box;
}

#imagePreview > .image-item {
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

/* Image thumbnail */
#imagePreview > .image-item > img {
    display: block;
    width: 100%;
    height: 172px;
    padding: 8px;
    object-fit: contain;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    background: #fff;
    box-sizing: border-box;
}

/* Remove button */
#imagePreview .remove-image {
    position: absolute;
    top: -9px;
    right: -9px;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    border: 0;
    border-radius: 50%;
    background: #e93343;
    color: #fff;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
}

/* Primary image selection */
#imagePreview .primary-image-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    margin-top: 10px;
    text-align: center;
}

#imagePreview .primary-image-option input[type="radio"] {
    width: 18px;
    height: 18px;
    margin: 0;
    cursor: pointer;
}

#imagePreview .primary-image-option span {
    color: #ef3340;
    font-size: 14px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

/* Filename */
#imagePreview .image-filename {
    display: block;
    width: 100%;
    min-width: 0;
    margin-top: 10px;
    color: #111827;
    font-size: 14px;
    line-height: 1.5;
    text-align: center;
    overflow-wrap: anywhere;
    word-break: break-word;
}

/* Add image tile */
#imagePreview > .image-add-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    aspect-ratio: 1 / 1;
    height: auto;
    padding: 12px;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    background: #fff;
    color: #475569;
    font-size: 16px;
    cursor: pointer;
}

#imagePreview .image-icon-wrap {
    position: relative;
    display: block;
    width: 80%;
    max-width: 100px;
    aspect-ratio: 88 / 70;
    height: auto;
}

#imagePreview .image-icon-wrap svg {
    display: block;
    width: 100%;
    height: 100%;
}

#imagePreview .image-plus {
    position: absolute;
    right: -7px;
    bottom: -7px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: 2px solid #fff;
    border-radius: 50%;
    background: #2563eb;
    color: #fff;
    font-size: 24px;
    line-height: 1;
}

/* Tablet */
@media (max-width: 1100px) {
    #imagePreview {
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 24px 16px;
    }

    #imagePreview > .image-item,
    #imagePreview > .image-add-tile {
        max-width: none;
    }

    #imagePreview > .image-item > img {
        height: auto;
        aspect-ratio: 1 / 1;
    }
}

/* Mobile */
@media (max-width: 767px) {
    #imagePreview {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px 12px;
    }

    #imagePreview > .image-item > img {
        height: auto;
        aspect-ratio: 1 / 1;
        padding: 5px;
    }

    #imagePreview .image-filename {
        font-size: 12px;
    }

    #imagePreview .remove-image {
        width: 26px;
        height: 26px;
        font-size: 19px;
    }
}

/* Small mobile */
@media (max-width: 420px) {
    #imagePreview {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 14px;
    }
}




/* ===== FIX PRODUCT IMAGE GALLERY OVERLAP ===== */

#productForm #imagePreview {
    display: grid !important;
    grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
    column-gap: 16px !important;
    row-gap: 28px !important;
    align-items: start !important;
    justify-content: start !important;

    width: 100% !important;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;

    margin: 16px 0 28px !important;
    padding: 0 !important;

    overflow: visible !important;
    clear: both !important;
    box-sizing: border-box !important;
}

/* Each image and add-image tile */
#productForm #imagePreview > .image-item,
#productForm #imagePreview > .image-add-tile {
    position: relative !important;
    display: flex;
    flex-direction: column;
    align-items: stretch;

    float: none !important;
    flex: none !important;

    width: 100% !important;
    min-width: 0 !important;
    max-width: none !important;
    height: auto !important;
    min-height: 0 !important;

    margin: 0 !important;
    padding: 0;
    box-sizing: border-box !important;
}

/* Image thumbnail */
#productForm #imagePreview > .image-item > img {
    display: block !important;
    position: static !important;

    width: 100% !important;
    height: 172px !important;
    min-height: 172px !important;
    max-height: 172px !important;

    object-fit: contain !important;
    padding: 8px !important;

    border: 1px solid #dee2e6 !important;
    border-radius: 12px !important;
    background: #fff !important;

    box-sizing: border-box !important;
}

/* Delete button */
#productForm #imagePreview .remove-image {
    position: absolute !important;
    top: -10px !important;
    right: -8px !important;
    z-index: 10 !important;

    width: 30px !important;
    height: 30px !important;
    min-width: 30px !important;
    min-height: 30px !important;

    margin: 0 !important;
    padding: 0 !important;
    border-radius: 50% !important;
}

/* Primary selector */
#productForm #imagePreview .primary-image-option {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;

    position: static !important;
    width: 100% !important;
    height: auto !important;

    margin: 10px 0 0 !important;
    padding: 0 !important;
    text-align: center !important;
}

/* Filename */
#productForm #imagePreview .image-filename {
    display: block !important;
    position: static !important;

    width: 100% !important;
    height: auto !important;
    min-width: 0 !important;

    margin: 12px 0 0 !important;
    padding: 0 !important;

    text-align: center !important;
    white-space: normal !important;
    overflow-wrap: anywhere !important;
    word-break: break-word !important;
}

/* Add-image tile */
#productForm #imagePreview > .image-add-tile {
    aspect-ratio: 1 / 1 !important;
    min-height: 172px !important;
    padding: 12px !important;
    align-items: center !important;
    justify-content: center !important;
    border: 1px dashed #cbd5e1 !important;
    border-radius: 12px !important;
}

/* Keep Product Preview below the complete gallery */
#productForm .product-step[data-step="4"] > .mt-4 {
    display: flow-root !important;
    clear: both !important;
    position: relative !important;
    width: 100% !important;
    height: auto !important;
    margin-top: 28px !important;
}

/* Tablet */
@media (max-width: 1000px) {
    #productForm #imagePreview {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    }
}

/* Mobile */
@media (max-width: 650px) {
    #productForm #imagePreview {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 26px 12px !important;
    }

    #productForm #imagePreview > .image-item > img {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        aspect-ratio: 1 / 1;
    }
}

@media (max-width: 400px) {
    #productForm #imagePreview {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}


 
 
#productForm #imageGallery {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 22px 16px;
    align-items: start;
    width: 100%;
    min-width: 0;
    margin-top: 16px;
}

#productForm #imagePreview {
    display: contents !important;
}

#productForm #imageGallery .image-item,
#productForm #imageGallery .image-add-tile {
    position: relative;
    width: 100%;
    min-width: 0;
    max-width: none;
    box-sizing: border-box;
}

#productForm #imageGallery .image-item {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 8px;
}

#productForm #imageGallery .image-thumb {
    width: 100%;
    aspect-ratio: 1 / 1;
    height: auto;
    padding: 7px;
    object-fit: contain;
    background: #fff;
    border: 1px solid #dbe2ea;
    border-radius: 12px;
    box-sizing: border-box;
}

#productForm #imageGallery .image-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px;
    margin-top: 4px;
}

#productForm #imageGallery .image-action-btn {
    min-width: 0;
    padding: 7px 4px;
    border: 1px solid #dbe2ea;
    border-radius: 7px;
    background: #fff;
    color: #334155;
    font-size: 12px;
    cursor: pointer;
}

#productForm #imageGallery .image-action-btn:hover {
    background: #f1f5f9;
}

#productForm #imageGallery .image-action-btn.danger {
    color: #dc3545;
    border-color: #f3c2c7;
}

#productForm #imageGallery .image-item.is-primary-image {
    outline: 2px solid #198754;
    outline-offset: 3px;
    border-radius: 12px;
}

#productForm #imageGallery .primary-badge {
    display: inline-block;
    align-self: center;
    padding: 4px 9px;
    border-radius: 20px;
    background: #198754;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
}

#productForm #imageGallery .image-filename {
    overflow-wrap: anywhere;
    word-break: break-word;
    text-align: center;
    font-size: 12px;
    color: #475569;
}

#productForm #imageGallery .image-add-tile {
    min-height: 120px;
    aspect-ratio: 1 / 1;
    padding: 12px;
    border: 1px dashed #94a3b8;
    border-radius: 12px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
}

@media (max-width: 1000px) {
    #productForm #imageGallery {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 650px) {
    #productForm #imageGallery {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px 12px;
    }
}

@media (max-width: 400px) {
    #productForm #imageGallery {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}



</style>

<div class="page">

    <header class="page-header">
        <div>
            <h1>Add New Product</h1>
            <p>Create a product listing for your Ajobmart store.</p>
        </div>
        <!-- <button type="button" class="btn btn-light"
                onclick="window.location.href='../dashboard'">
            ← Back to Dashboard
        </button> -->
    </header>

    <div class="layout">

        <!-- LEFT STEP NAVIGATION -->
        <aside class="card steps">
            <div class="step active"
                data-step-indicator="1"
                role="button"
                tabindex="0"
                aria-label="Go to Category step">
                <div class="step-number">1</div>
                <div>
                    <div class="step-title">Category</div>
                    <div class="step-description">Choose product type</div>
                </div>
            </div>

            <div class="step" data-step-indicator="2">
                <div class="step-number">2</div>
                <div>
                    <div class="step-title">Basic Details</div>
                    <div class="step-description">Product information</div>
                </div>
            </div>

            <div class="step" data-step-indicator="3">
                <div class="step-number">3</div>
                <div>
                    <div class="step-title">Price & Stock</div>
                    <div class="step-description">Price and inventory</div>
                </div>
            </div>

            <div class="step" data-step-indicator="4">
                <div class="step-number">4</div>
                <div>
                    <div class="step-title">Images & Review</div>
                    <div class="step-description">Preview listing</div>
                </div>
            </div>
        </aside>

        <!-- PRODUCT FORM -->
        <main>
            <form id="productForm" enctype="multipart/form-data">

            <input type="hidden" name="product_id" id="product_id" value="">
            <input type="hidden" name="save_mode" id="save_mode" value="draft">
                <!-- STEP 1 -->
                <section class="card product-step" data-step="1">
                    <h2 class="section-title">Choose a Category</h2>
                    <p class="section-subtitle">
                        Select the category that best matches your product.
                    </p>

                    <div class="category-grid">
                        <?php
                        $categoryIcons = [
                            'electronics' => '📱',
                            'fashion'     => '👕',
                            'grocery'     => '🛒',
                            'home'        => '🏠',
                            'beauty'      => '🧴',
                            'computers'   => '💻',
                            'sports'      => '🏋️',
                            'furniture'   => '🛋️',
                            'automotive'  => '🚗',
                            'books'       => '📚',
                            'pets'        => '🐾',
                            'toys'        => '🧸',
                            'garden'      => '🌱',
                            'jewelry'     => '💍',
                            'watches'     => '⌚',
                            'arts_crafts' => '🎨',
                            'baby_kids'   => '👶',
                            'health'      => '💊',
                            'audio'       => '🎧',
                            'tools'       => '🛠️',
                            'other'       => '📦',
                        ];
                        ?>

                        <?php foreach ($categories as $category): ?>
                            <label class="category-option">
                                <input
                                    type="radio"
                                    id="category_<?= (int) $category['id'] ?>"
                                    name="category"
                                    value="<?= (int) $category['id'] ?>"
                                    data-slug="<?= esc($category['slug']) ?>"
                                    required
                                >

                                <div class="category-box">
                                    <span class="category-icon">
                                        <?= $categoryIcons[$category['slug']] ?? '📦' ?>
                                    </span>

                                    <span class="category-name">
                                        <?= esc($category['name']) ?>
                                    </span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>


                    <div class="form-footer">
                        <span></span>
                        <button type="button" class="btn btn-primary"
                                onclick="nextStep()">Continue →</button>
                    </div>
                </section>

                <!-- STEP 2 -->
                <section class="card product-step hidden" data-step="2">
                    <h2 class="section-title">Basic Product Details</h2>
                    <p class="section-subtitle">
                        Add the name, description and category-specific information.
                    </p>

                    <div class="form-grid">

                    <div class="field full mt-4" id="subcategoryWrapper" hidden>
                        <label for="subcategory_id">
                            Select Subcategory <span>*</span>
                        </label>

                        <select
                            id="subcategory_id"
                            name="subcategory_id"
                            disabled
                        >
                            <option value="">Select a subcategory</option>
                        </select>

                        <div class="help" id="subcategoryMessage">
                            Choose a category first.
                        </div>
                    </div>
                    
                    
                    <div class="field full" id="productTypeWrapper" hidden>
                        <label for="product_type_id">
                            Select Product Type <span>*</span>
                        </label>

                        <select
                            id="product_type_id"
                            name="product_type_id"
                            disabled
                        >
                            <option value="">Select a subcategory first</option>
                        </select>

                        <div class="help" id="productTypeMessage">
                            Choose a subcategory to load product types.
                        </div>
                    </div>


                    
                    <div class="field">
                        <label for="sku">Seller SKU <span>*</span></label>

                        <input
                            type="text"
                            id="sku"
                            name="sku"
                            placeholder="e.g. AJ-SKU-001"
                            required
                            pattern="[^\s]+"
                            maxlength="100"
                            autocomplete="off"
                            oninput="this.value = this.value.replace(/\s/g, '')"
                        >

                        <div class="help">Your unique product identification code.</div>

                        <small id="skuValidationMessage"
                            style="display:block;margin-top:6px;"
                            aria-live="polite"></small>
                    </div>


                        <div class="field">
                            <label for="product_name">Product Name <span>*</span></label>
                            <input id="product_name" name="product_name"
                                   required maxlength="200"
                                   placeholder="e.g. Samsung Galaxy Smartphone">
                        </div>

                        <div class="field">
                            <label for="brand">Brand <span>*</span></label>
                            <input id="brand" name="brand"
                                   placeholder="Enter brand name" required>
                        </div>

                        <!-- Sub-brand -->
                        <div class="field">
                            <label for="sub_brand">Sub-brand</label>
                            <input
                                type="text"
                                id="sub_brand"
                                name="sub_brand"
                                placeholder="e.g. Redmi">
                        </div>

                        <!-- Pack of -->
                        <div class="field">
                            <label for="pack_of">Pack of</label>
                            <input
                                type="number"
                                id="pack_of"
                                name="pack_of"
                                min="1"
                                value="1"
                                required>
                        </div>

                        <!-- Minimum order quantity -->
                        <div class="field">
                            <label for="min_order_quantity">
                                Minimum Order Quantity
                            </label>
                            <input
                                type="number"
                                id="min_order_quantity"
                                name="min_order_quantity"
                                min="1"
                                value="1"
                                required>
                        </div>


                        

                        <div class="field full">
                            <label for="description">Product Description <span>*</span></label>
                            <textarea id="description" name="description"
                                      required minlength="10" maxlength="5000"
                                      placeholder="Describe your product, its features and benefits..."></textarea>
                        </div>

                        <div class="field">
                            <label for="condition">Product Condition <span>*</span></label>
                            <select id="condition" name="condition" required>
                                <option value="new">New</option>
                                <option value="refurbished">Refurbished</option>
                                <option value="used">Used</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="product_status">Listing Status <span>*</span></label>
                            <select id="product_status" name="product_status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="help">
                                Active products can be listed for sale after any required approval.
                                Inactive products should remain unpublished.
                            </div>
                        </div>

                        <!-- ELECTRONICS FIELDS -->
                        <!-- DYNAMIC CATEGORY ATTRIBUTES -->
                        <div class="field full" id="dynamicAttributesWrapper">
                            <div class="notice">
                                Category-specific product specifications
                            </div>

                            <div class="form-grid" id="dynamicAttributes">
                                <p class="help">
                                    Select a category to load its attributes.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Country of origin -->
                        <div class="field">
                            <label for="country_of_origin">Country of Origin</label>
                            <select id="country_of_origin" name="country_of_origin">
                                <option value="">Select country</option>
                                <option value="India">India</option>
                                <option value="China">China</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- HSN code -->
                        <div class="field position-relative">
                            <label for="hsn_code">HSN Code <span>*</span></label>

                            <input type="text"
                                id="hsn_code"
                                name="hsn_code"
                                maxlength="8"
                                placeholder="HSN code"
                                autocomplete="off"
                                required>

                            <div id="ajHsnResults"
                                class="list-group position-absolute w-100 shadow-sm"
                                style="display:none; z-index:1050;">
                            </div>
                        </div>

                        <div class="field">
                            <label for="gstvalue">Gst Vlue (Get From HSN)<span>*</span></label>
                            <input type="number"
                                id="gst_value"
                                name="gst_value"
                                maxlength="3"
                                placeholder="Enter Gst Value" required>
                        </div>

                        <!-- Manufacturer -->
                        <div class="field">
                            <label for="manufacturer_name">Manufacturer / Importer</label>
                            <input type="text"
                                id="manufacturer_name"
                                name="manufacturer_name"
                                maxlength="200"
                                placeholder="Enter manufacturer name">
                        </div>

                        <div class="field">
                            <label for="packer_name">Packer / Packing</label>
                            <input type="text"
                                id="packer_name"
                                name="packer_name"
                                maxlength="200"
                                placeholder="Enter Packer name">
                        </div>


                        <!-- Key features -->
                        <div class="field full">
                            <label for="key_features">Key Features</label>
                            <textarea id="key_features"
                                    name="key_features"
                                    maxlength="3000"
                                    placeholder="Enter the main product features"></textarea>
                            <div class="help">
                                Enter one feature per line.
                            </div>
                        </div>


                    </div>

                    <div class="form-footer">
                        <button type="button" class="btn btn-light"
                                onclick="prevStep()">← Back</button>

                        <div class="footer-right">
                            <button type="button" class="btn btn-light"
                                    onclick="saveProductDraft()">
                                Save as Draft
                            </button>

                            <button type="button" class="btn btn-primary"
                                    onclick="nextStep()">
                                Continue →
                            </button>
                        </div>
                    </div>
                </section>

                <!-- STEP 3 -->
                <section class="card product-step hidden" data-step="3">
                    <h2 class="section-title">Pricing & Inventory</h2>
                    <p class="section-subtitle">
                        Enter selling price, available quantity and delivery details.
                    </p>

                    <div class="form-grid">
                        <div class="field">
                            <label for="mrp">MRP (₹) <span>*</span></label>
                            <input type="number" id="mrp" name="mrp"
                                   min="0.01" step="0.01" required>
                        </div>

                        <!-- <div class="field">
                            <label for="selling_price">Selling Price (₹) <span>*</span></label>
                            <input type="number" id="selling_price"
                                   name="selling_price" min="0.01"
                                   step="0.01" required>
                        </div> -->

                        <div class="field">
                            <label for="stock_quantity">Stock Quantity <span>*</span></label>
                            <input type="number" id="stock_quantity"
                                   name="stock_quantity" min="0" step="1" required>
                        </div>

                        <div class="field">
                            <label for="low_stock">Low Stock Alert</label>
                            <input type="number" id="low_stock" name="low_stock"
                                   min="0" value="5" readonly>
                        </div>

                        <div class="field">
                            <label for="length">Length (cm)</label>
                            <input type="number"
                                id="length"
                                name="length"
                                min="0"
                                step="0.01"
                                placeholder="e.g. 30">
                        </div>

                        <div class="field">
                            <label for="width">Width (cm)</label>
                            <input type="number"
                                id="width"
                                name="width"
                                min="0"
                                step="0.01"
                                placeholder="e.g. 20">
                        </div>

                        <div class="field">
                            <label for="height">Height (cm)</label>
                            <input type="number"
                                id="height"
                                name="height"
                                min="0"
                                step="0.01"
                                placeholder="e.g. 15">
                        </div>

                        <div class="field">
                            <label for="shipping_weight">Shipping Weight (kg)</label>
                            <input type="number"
                                id="shipping_weight"
                                name="shipping_weight"
                                min="0"
                                step="0.001"
                                placeholder="e.g. 1.5">
                        </div>

                        <div class="field">
                            <label for="selling_price">
                                Seller's Base Selling Price (₹) *
                            </label>
                            <input type="number"
                                id="selling_price"
                                name="selling_price"
                                min="0.01"
                                step="0.01"
                                required>
                        </div>

                        <div class="field">
                            <label for="shipping_allowance">
                                Estimated Shipping Allowance (₹)
                            </label>
                            <input type="number"
                                id="shipping_allowance"
                                name="shipping_allowance"
                                readonly>

                            <small id="shippingAllowanceMessage" class="text-muted">
                                Enter product dimensions and weight to calculate shipping.
                            </small>
                        </div>

                        <div class="field full">
                            <label for="final_listing_price">
                                Final Listing Price (₹)
                            </label>
                            <input type="number"
                                id="final_listing_price"
                                name="final_listing_price"
                                readonly>
                            <div class="help">
                                Automatically calculated from your base price and shipping allowance.
                            </div>
                        </div>

                        <div class="field">
                            <label for="shipping_days">Dispatch Time</label>
                            <select id="shipping_days" name="shipping_days">
                                <option value="1">Within 1 day</option>
                                <option value="2">Within 2 days</option>
                                <option value="3">Within 3 days</option>
                                <option value="5">Within 5 days</option>
                                <option value="7">Within 7 days</option>
                            </select>
                        </div>

                        <div class="field full">
                            <label for="shipping_type">Shipping Method</label>
                            <select id="shipping_type" name="shipping_type">
                                <option value="platform">Platform Shipping</option>
                                <option value="seller">Seller Managed Shipping</option>
                            </select>
                            <div class="help">
                                Actual shipping eligibility and fees must be calculated
                                using your Ajobmart shipping rules.
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="btn btn-light"
                                onclick="prevStep()">← Back</button>

                        <div class="footer-right">
                            <button type="button" class="btn btn-light"
                                    onclick="saveProductDraft()">
                                Save as Draft
                            </button>

                            <button type="button" class="btn btn-primary"
                                    onclick="nextStep()">
                                Continue →
                            </button>
                        </div>
                    </div>
                </section>

                <!-- STEP 4 -->
                <section class="card product-step hidden" data-step="4">
                    <h2 class="section-title">Product Images & Review</h2>
                    <p class="section-subtitle">
                        Upload clear product photos and verify the information.
                    </p>

                    
                    
                    
                    <div class="field mb-4">
                        <label>Product Images <span>*</span></label>

                        <p class="help">
                            Upload up to 8 images. JPG, PNG or WebP, maximum 5 MB each.
                            Images will be converted to WebP when saved.
                        </p>

                        <div id="imageGallery" class="image-gallery">
                            <div id="imagePreview" class="image-preview"></div>

                            <button type="button" id="addImagesBtn" class="image-add-tile">
                                <span class="image-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 100 80" aria-hidden="true">
                                        <rect x="8" y="5" width="84" height="68" rx="8"
                                            fill="#c9f2ff"/>
                                        <circle cx="29" cy="25" r="9" fill="#ffbd59"
                                                stroke="#111" stroke-width="4"/>
                                        <path d="M10 60 L31 39 L48 56 L61 42 L90 69"
                                            fill="#20b981" stroke="#111" stroke-width="4"
                                            stroke-linejoin="round"/>
                                    </svg>
                                    <span class="image-plus">+</span>
                                </span>
                                <span>Add Image</span>
                            </button>
                        </div>

                        <input type="file"
                            id="product_images"
                            name="product_images[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            hidden>

                        <input type="hidden"
                            name="primary_image_index"
                            id="primary_image_index"
                            value="-1">
                    </div>




                    <div class="mt-4">
                        <hr style="border:0;border-top:1px solid var(--border);margin:28px 0">

                        <h3>Product Preview</h3>
                        <p>Review your listing before submitting it.</p>
                    </div>
                    
                    <table class="preview-table">
                        <tbody id="productReview"></tbody>
                    </table>

                    <!-- <div class="field full" style="margin-top:24px;">
                        <h3>Uploaded Images</h3>
                        <p class="help">Verify the images before saving your product.</p>
                        <div id="reviewImages" class="image-preview"></div>
                    </div> -->


                    <div class="notice" style="margin-top:20px">
                        Submitting for approval should send the listing to the
                        Ajobmart admin review process. Saving as a draft should
                        keep the product unpublished.
                    </div>

                    <div class="form-footer">
                        <button type="button" class="btn btn-light"
                                onclick="prevStep()">← Back</button>

                        <div class="footer-right">
                            <button type="button" class="btn btn-light"
                                    onclick="saveProductDraft()">
                                Save as Draft
                            </button>

                            <button type="submit" class="btn btn-primary"
                                    id="submitProduct">
                                Save & Approve
                            </button>
                        </div>
                    </div>
                </section>

            </form>
        </main>
    </div>
</div>

<?= $this->section('scripts') ?>

<script>
const form = document.getElementById('productForm');
const steps = [...document.querySelectorAll('.product-step')];
const indicators = [...document.querySelectorAll('[data-step-indicator]')];

let currentStep = 1;
let imageFiles = [];

// const categoryNames = {
//     electronics: 'Electronics',
//     fashion: 'Fashion',
//     grocery: 'Grocery',
//     home: 'Home & Kitchen',
//     beauty: 'Beauty & Personal Care',
//     other: 'Other Products'
// };

function selectedCategory() {
    return form.querySelector('[name="category"]:checked')?.value || '';
}

const subcategorySelect = document.getElementById('subcategory_id');
const subcategoryWrapper = document.getElementById('subcategoryWrapper');
const subcategoryMessage = document.getElementById('subcategoryMessage');

let subcategoryRequestId = 0;


function loadSubcategories(categoryId) {
    const requestId = ++subcategoryRequestId;

    subcategorySelect.replaceChildren(
        new Option('Select a subcategory', '')
    );

    subcategorySelect.disabled = true;
    subcategorySelect.required = false;
    subcategoryWrapper.hidden = !categoryId;
    subcategoryMessage.textContent = 'Loading subcategories...';

    document.getElementById('dynamicAttributes').replaceChildren();

    if (!categoryId) {
        subcategoryMessage.textContent = 'Choose a category first.';
        return Promise.resolve([]);
    }

    return $.ajax({
        url: "<?= site_url('seller/products/subcategories') ?>/"
            + encodeURIComponent(categoryId),
        type: 'GET',
        dataType: 'json'
    }).then(function (response) {
        if (requestId !== subcategoryRequestId) return [];

        if (response.status !== 'success') {
            throw new Error(
                response.message || 'Unable to load subcategories.'
            );
        }

        const subcategories = response.subcategories || [];

        if (subcategories.length === 0) {
            subcategoryWrapper.hidden = true;
            subcategorySelect.required = false;
            subcategoryMessage.textContent =
                'No subcategories available.';

            return [];
        }

        subcategories.forEach(function (subcategory) {
            subcategorySelect.add(
                new Option(subcategory.name, subcategory.id)
            );
        });

        subcategorySelect.disabled = false;
        subcategorySelect.required = true;
        subcategoryMessage.textContent =
            'Select a subcategory to load its attributes.';

        return subcategories;
    }).catch(function (error) {
        if (requestId === subcategoryRequestId) {
            subcategoryMessage.textContent =
                error.responseJSON?.message ||
                error.message ||
                'Failed to load subcategories.';
        }

        throw error;
    });
}


form.querySelectorAll('[name="category"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
        loadSubcategories(this.value);
    });
});

subcategorySelect.addEventListener('change', function () {
    loadProductTypes(this.value);
    loadCategoryAttributes(selectedCategory(), this.value);
});

function showStep(number) {
    currentStep = number;

    steps.forEach(section => {
        section.classList.toggle(
            'hidden',
            Number(section.dataset.step) !== number
        );
    });

    indicators.forEach(indicator => {
        const n = Number(indicator.dataset.stepIndicator);
        indicator.classList.toggle('active', n === number);
        indicator.classList.toggle('done', n < number);

        const circle = indicator.querySelector('.step-number');
        circle.textContent = n < number ? '✓' : n;
    });

    if (number === 4) buildReview();

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep(number) {
    const section = document.querySelector(
        `.product-step[data-step="${number}"]`
    );

    // Category selection
    if (number === 1) {
        if (!selectedCategory()) {
            alert('Please select a product category.');
            return false;
        }
        return true;
    }

    // Only validate controls in the current step and visible category fields.
    const fields = [...section.querySelectorAll('input, select, textarea')]
        .filter(el => {
            if (el.disabled) return false;
            if (el.closest('.category-fields.hidden')) return false;
            return true;
        });

    for (const field of fields) {
        if (!field.checkValidity()) {
            field.reportValidity();
            field.focus();
            return false;
        }
    }

    if (number === 3) {
        const mrp = Number(document.getElementById('mrp').value);
        const price = Number(document.getElementById('selling_price').value);
        const listprice = Number(document.getElementById('final_listing_price').value);

        if (listprice > mrp) {
            alert('Final Listing price should not be higher than MRP.');
            document.getElementById('final_listing_price').focus();
            return false;
        }
    }

    return true;
}

async function nextStep() {
    if (!validateStep(currentStep)) {
        return;
    }

    // Save current progress before navigating forward.
    // const saved = await saveProductDraft(true);

    if (currentStep < 4) {
        showStep(currentStep + 1);
    }
}



function prevStep() {
    if (currentStep > 1) showStep(currentStep - 1);
}


/**
 * Navigate to a clicked step.
 * Every preceding step must pass validation first.
 */
function navigateToStep(targetStep) {
    targetStep = Number(targetStep);

    if (targetStep < 1 || targetStep > 4) {
        return;
    }

    // Going backward or staying on the current step
    // does not require validating later steps.
    if (targetStep <= currentStep) {
        showStep(targetStep);
        return;
    }

    // Validate each preceding step in sequence.
    for (let stepNumber = 1; stepNumber < targetStep; stepNumber++) {

        // Reveal the section before browser validation,
        // so invalid fields are visible and focusable.
        showStep(stepNumber);

        if (!validateStep(stepNumber)) {
            // Keep the seller on the first incomplete step.
            showStep(stepNumber);
            return;
        }
    }

    // All preceding steps are valid.
    showStep(targetStep);
}

// Click navigation
indicators.forEach(function (indicator) {
    indicator.addEventListener('click', function () {
        navigateToStep(this.dataset.stepIndicator);
    });

    // Keyboard accessibility: Enter or Space
    indicator.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            navigateToStep(this.dataset.stepIndicator);
        }
    });
});
 

// Change fields automatically when the category changes.
form.querySelectorAll('[name="category"]').forEach(radio => {
    radio.addEventListener('change', () => {
        const category = selectedCategory();

        document.querySelectorAll('.category-fields').forEach(group => {
            const active = group.dataset.category === category;
            group.classList.toggle('hidden', !active);

            // Hidden category fields must not be validated or submitted.
            group.querySelectorAll('input, select, textarea').forEach(field => {
                field.disabled = !active;
            });
        });
    });
});





const imageInput = document.getElementById('product_images');
const imagePreview = document.getElementById('imagePreview');
const addImagesBtn = document.getElementById('addImagesBtn');
const primaryImageInput = document.getElementById('primary_image_index');

// let imageFiles = [];

// Existing server-side images, supplied when editing a draft.
// Each item: { id, url, image_name, is_primary }
let existingImages = [];

// Primary selection:
// { type: 'existing', id: databaseImageId }
// or { type: 'new', index: imageFilesIndex }
let selectedPrimary = null;

// Image IDs marked for removal from the database.
let removedImageIds = [];

// Index in imageFiles to replace with the next chosen file.
let replaceImageIndex = null;

function totalGalleryImages() {
    return existingImages.length + imageFiles.length;
}

function getPrimaryIndexForUpload() {
    if (
        selectedPrimary &&
        selectedPrimary.type === 'new'
    ) {
        return selectedPrimary.index;
    }

    return -1;
}

function updatePrimaryHiddenInput() {
    primaryImageInput.value = String(getPrimaryIndexForUpload());
}

function selectPrimary(type, value) {
    selectedPrimary = type === 'existing'
        ? { type: 'existing', id: Number(value) }
        : { type: 'new', index: Number(value) };

    updatePrimaryHiddenInput();
    renderImages();
}

function createImageAction(text, action, index, type, danger = false) {
    const button = document.createElement('button');

    button.type = 'button';
    button.className = 'image-action-btn' +
        (danger ? ' danger' : '');

    button.textContent = text;
    button.addEventListener('click', function () {
        handleImageAction(action, index, type);
    });

    return button;
}

function handleImageAction(action, index, type) {
    if (action === 'primary') {
        if (type === 'existing') {
            selectPrimary('existing', existingImages[index].id);
        } else {
            selectPrimary('new', index);
        }

        return;
    }

    if (action === 'replace') {
        replaceImageIndex = index;
        imageInput.click();
        return;
    }

    if (action === 'remove') {
        if (type === 'existing') {
            const removed = existingImages.splice(index, 1)[0];

            if (removed) {
                removedImageIds.push(Number(removed.id));
            }

            if (
                selectedPrimary &&
                selectedPrimary.type === 'existing' &&
                Number(selectedPrimary.id) === Number(removed?.id)
            ) {
                selectedPrimary = null;
            }
        } else {
            imageFiles.splice(index, 1);

            if (
                selectedPrimary &&
                selectedPrimary.type === 'new'
            ) {
                if (selectedPrimary.index === index) {
                    selectedPrimary = null;
                } else if (selectedPrimary.index > index) {
                    selectedPrimary.index--;
                }
            }
        }

        ensurePrimaryImage();
        renderImages();
    }
}

function ensurePrimaryImage() {
    if (
        selectedPrimary &&
        selectedPrimary.type === 'existing' &&
        existingImages.some(
            image => Number(image.id) === Number(selectedPrimary.id)
        )
    ) {
        return;
    }

    if (
        selectedPrimary &&
        selectedPrimary.type === 'new' &&
        imageFiles[selectedPrimary.index]
    ) {
        return;
    }

    if (existingImages.length > 0) {
        const primary = existingImages.find(
            image => Number(image.is_primary) === 1
        );

        selectedPrimary = primary
            ? { type: 'existing', id: Number(primary.id) }
            : { type: 'existing', id: Number(existingImages[0].id) };
    } else if (imageFiles.length > 0) {
        selectedPrimary = { type: 'new', index: 0 };
    } else {
        selectedPrimary = null;
    }

    updatePrimaryHiddenInput();
}

function renderImages() {
    imagePreview.replaceChildren();

    existingImages.forEach((image, index) => {
        const card = document.createElement('div');
        card.className = 'image-item';

        const isPrimary = selectedPrimary?.type === 'existing' &&
            Number(selectedPrimary.id) === Number(image.id);

        if (isPrimary) {
            card.classList.add('is-primary-image');
        }

        const img = document.createElement('img');
        img.className = 'image-thumb';
        img.src = image.url;
        img.alt = image.image_name || 'Product image';

        card.appendChild(img);

        if (isPrimary) {
            const badge = document.createElement('span');
            badge.className = 'primary-badge';
            badge.textContent = 'Primary image';
            card.appendChild(badge);
        }

        const filename = document.createElement('small');
        filename.className = 'image-filename';
        filename.textContent = image.image_name || 'Saved image';

        card.appendChild(filename);

        const actions = document.createElement('div');
        actions.className = 'image-actions';

        actions.append(
            createImageAction(
                isPrimary ? '★ Primary' : 'Set Primary',
                'primary', index, 'existing'
            ),
            createImageAction(
                'Replace',
                'replace', index, 'existing'
            ),
            createImageAction(
                'Remove',
                'remove', index, 'existing', true
            )
        );

        card.appendChild(actions);
        imagePreview.appendChild(card);
    });

    imageFiles.forEach((file, index) => {
        const card = document.createElement('div');
        card.className = 'image-item';

        const isPrimary = selectedPrimary?.type === 'new' &&
            selectedPrimary.index === index;

        if (isPrimary) {
            card.classList.add('is-primary-image');
        }

        const img = document.createElement('img');
        img.className = 'image-thumb';

        const objectUrl = URL.createObjectURL(file);
        img.src = objectUrl;
        img.alt = file.name;

        img.onload = () => URL.revokeObjectURL(objectUrl);
        img.onerror = () => URL.revokeObjectURL(objectUrl);

        card.appendChild(img);

        if (isPrimary) {
            const badge = document.createElement('span');
            badge.className = 'primary-badge';
            badge.textContent = 'Primary image';
            card.appendChild(badge);
        }

        const filename = document.createElement('small');
        filename.className = 'image-filename';
        filename.textContent = file.name;

        card.appendChild(filename);

        const actions = document.createElement('div');
        actions.className = 'image-actions';

        actions.append(
            createImageAction(
                isPrimary ? '★ Primary' : 'Set Primary',
                'primary', index, 'new'
            ),
            createImageAction(
                'Replace',
                'replace', index, 'new'
            ),
            createImageAction(
                'Remove',
                'remove', index, 'new', true
            )
        );

        card.appendChild(actions);
        imagePreview.appendChild(card);
    });

    addImagesBtn.hidden = totalGalleryImages() >= 8;

    updatePrimaryHiddenInput();
}

addImagesBtn.addEventListener('click', function () {
    if (totalGalleryImages() >= 8) {
        Swal.fire('Image limit', 'A product can have a maximum of 8 images.', 'warning');
        return;
    }

    replaceImageIndex = null;
    imageInput.click();
});

imageInput.addEventListener('change', function () {
    const files = Array.from(this.files || []);

    // Permit choosing the same file again.
    this.value = '';

    if (!files.length) {
        replaceImageIndex = null;
        return;
    }

    const invalid = files.find(file =>
        !['image/jpeg', 'image/png', 'image/webp'].includes(file.type) ||
        file.size > 5 * 1024 * 1024
    );

    if (invalid) {
        replaceImageIndex = null;

        Swal.fire(
            'Invalid image',
            'Use JPG, PNG or WebP images no larger than 5 MB each.',
            'warning'
        );

        return;
    }

    if (replaceImageIndex !== null) {
        const index = replaceImageIndex;
        replaceImageIndex = null;

        // Replacing an existing saved image means mark the old image
        // for deletion and add the replacement as a new upload.
        if (existingImages[index]) {
            const old = existingImages.splice(index, 1)[0];
            removedImageIds.push(Number(old.id));
            imageFiles.push(files[0]);

            if (
                selectedPrimary?.type === 'existing' &&
                Number(selectedPrimary.id) === Number(old.id)
            ) {
                selectedPrimary = {
                    type: 'new',
                    index: imageFiles.length - 1
                };
            }
        } else if (imageFiles[index] !== undefined) {
            imageFiles[index] = files[0];
        }

        ensurePrimaryImage();
        renderImages();
        return;
    }

    if (totalGalleryImages() + files.length > 8) {
        Swal.fire(
            'Image limit',
            'A product can have a maximum of 8 images in total.',
            'warning'
        );

        return;
    }

    const startIndex = imageFiles.length;
    imageFiles.push(...files);

    if (!selectedPrimary && imageFiles.length > 0 && existingImages.length === 0) {
        selectedPrimary = { type: 'new', index: startIndex };
    }

    renderImages();
});

// Call this after retrieving a product's images from your controller.
function loadExistingProductImages(images) {
    existingImages = Array.isArray(images)
        ? images.map(image => ({
            id: Number(image.id),
            url: String(image.url || ''),
            image_name: String(image.image_name || ''),
            is_primary: Number(image.is_primary || 0)
        }))
        : [];

    removedImageIds = [];
    imageFiles = [];
    selectedPrimary = null;

    ensurePrimaryImage();
    renderImages();
}

// Provide these values when submitting the form.
function appendImageChanges(formData) {
    formData.delete('product_images[]');
    formData.delete('primary_image_index');
    formData.delete('removed_image_ids[]');
    formData.delete('primary_existing_image_id');

    imageFiles.forEach(file => {
        formData.append('product_images[]', file);
    });

    formData.append(
        'primary_image_index',
        String(getPrimaryIndexForUpload())
    );

    removedImageIds.forEach(id => {
        formData.append('removed_image_ids[]', String(id));
    });

    if (selectedPrimary?.type === 'existing') {
        formData.append(
            'primary_existing_image_id',
            String(selectedPrimary.id)
        );
    }
}

renderImages();




function getValue(id) {
    const element = document.getElementById(id);
    if (!element || element.disabled) return '';
    return element.value.trim();
}


function getReviewValue(element) {
    if (!element || element.disabled) {
        return '';
    }

    if (element.tagName === 'SELECT') {
        return element.selectedIndex >= 0
            ? element.options[element.selectedIndex].text.trim()
            : '';
    }

    return String(element.value || '').trim();
}

function addReviewRow(tbody, label, value) {
    const tr = document.createElement('tr');
    const left = document.createElement('td');
    const right = document.createElement('td');

    left.textContent = label;
    right.textContent = value || '—';

    tr.append(left, right);
    tbody.appendChild(tr);
}

function buildReview() {
    const tbody = document.getElementById('productReview');
    // const reviewImages = document.getElementById('reviewImages');

    tbody.replaceChildren();
    // reviewImages.replaceChildren();

    // Read standard form fields.
    const fields = [
        ['Category', selectedCategoryName(), ''],
        ['Product Name', getValue('product_name'), 'product_name'],
        ['Brand', getValue('brand'), 'brand'],
        ['Seller SKU', getValue('sku'), 'sku'],
        ['Description', getValue('description'), 'description'],
        ['Product Condition', getValue('condition'), 'condition'],
        ['Listing Status', getValue('product_status') === 'active'
        ? 'Active' : 'Inactive','product_status'],
        ['Country of Origin', getValue('country_of_origin'), 'country_of_origin'],
        ['HSN Code', getValue('hsn_code'), 'hsn_code'],
        ['Manufacturer / Importer', getValue('manufacturer_name'), 'manufacturer_name'],
        ['Packer / Packing', getValue('packer_name'), 'packer_name'],

        ['Key Features', getValue('key_features'), 'key_features'],
        ['MRP', '₹' + (Number(getValue('mrp')) || 0).toFixed(2), 'mrp'],
        ['Seller Base Selling Price',
            '₹' + (Number(getValue('selling_price')) || 0).toFixed(2),
            'selling_price'],
        ['Shipping Allowance',
            '₹' + (Number(getValue('shipping_allowance')) || 0).toFixed(2),
            'shipping_allowance'],
        ['Final Listing Price',
            '₹' + (Number(getValue('final_listing_price')) || 0).toFixed(2),
            'final_listing_price'],
        ['Stock Quantity', getValue('stock_quantity'), 'stock_quantity'],
        ['Low Stock Alert', getValue('low_stock'), 'low_stock'],
        ['Length', getValue('length') ? getValue('length') + ' cm' : '', 'length'],
        ['Width', getValue('width') ? getValue('width') + ' cm' : '', 'width'],
        ['Height', getValue('height') ? getValue('height') + ' cm' : '', 'height'],
        ['Images', totalGalleryImages() + ' selected'],
        ['Shipping Weight',
            getValue('shipping_weight')
                ? getValue('shipping_weight') + ' kg' : '',
            'shipping_weight'],
        ['Dispatch Time',
            getValue('shipping_days')
                ? getValue('shipping_days') + ' day(s)' : '',
            'shipping_days'],
        ['Shipping Method', getValue('shipping_type'), 'shipping_type']
    ];

    fields.forEach(([label, value]) => {
        addReviewRow(tbody, label, value);
    });

    // Add all database-driven category attributes.
    const attributeControls = document.querySelectorAll(
        '#dynamicAttributes input, ' +
        '#dynamicAttributes select, ' +
        '#dynamicAttributes textarea'
    );

    attributeControls.forEach(control => {
        if (control.disabled || control.type === 'file') {
            return;
        }

        const labelElement = control.id
            ? document.querySelector(
                '#dynamicAttributes label[for="' + control.id + '"]'
            )
            : null;

        const label = labelElement
            ? labelElement.textContent.trim()
            : control.name;

        const value = getReviewValue(control);

        addReviewRow(tbody, label, value);
    });

    // Calculate the discount from MRP and base selling price.
    const mrp = Number(getValue('mrp')) || 0;
    const basePrice = Number(getValue('selling_price')) || 0;

    const discount = mrp > 0
        ? Math.max(0, ((mrp - basePrice) / mrp) * 100)
        : 0;

    addReviewRow(tbody, 'Discount on Base Price',
        discount.toFixed(2) + '%');

    // Display uploaded image thumbnails and filenames.
    // if (imageFiles.length === 0) {
    //     const message = document.createElement('p');
    //     message.className = 'help';
    //     message.textContent = 'No product images selected.';
    //     // reviewImages.appendChild(message);
    // } else {
    //     imageFiles.forEach(file => {
    //         const wrapper = document.createElement('div');
    //         wrapper.className = 'image-item';

    //         const img = document.createElement('img');
    //         const objectUrl = URL.createObjectURL(file);

    //         img.src = objectUrl;
    //         img.alt = file.name;
    //         img.title = file.name;
    //         img.onload = () => URL.revokeObjectURL(objectUrl);
    //         img.onerror = () => URL.revokeObjectURL(objectUrl);

    //         const filename = document.createElement('div');
    //         filename.className = 'help';
    //         filename.textContent = file.name;

    //         wrapper.append(img, filename);
    //         reviewImages.appendChild(wrapper);
    //     });
    // }
}


// Recalculate preview as the seller edits the form.
form.addEventListener('input', () => {
    if (currentStep === 4) buildReview();
});

form.addEventListener('change', () => {
    if (currentStep === 4) buildReview();
});

// Frontend demo only: connect this to your CI4 POST route.
// form.addEventListener('submit', event => {
//     event.preventDefault();

//     if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
//         const invalidStep = !validateStep(1) ? 1
//             : !validateStep(2) ? 2 : 3;
//         showStep(invalidStep);
//         return;
//     }

//     if (imageFiles.length === 0) {
//         alert('Please upload at least one product image.');
//         return;
//     }

//     alert(
//         'Frontend validation successful! Connect this form to your ' +
//         'CodeIgniter 4 controller to save the product.'
//     );
// });

showStep(1);









$(document).on('submit', '#productForm', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    const button = $('#submitProduct');
    const oldText = button.html();

    if (totalGalleryImages() === 0) {
        Swal.fire(
            'Images Required',
            'Please add at least one product image.',
            'warning'
        );
        showStep(4);
        return;
    }

    ensurePrimaryImage();

    if (!selectedPrimary) {
        Swal.fire(
            'Primary Image Required',
            'Please select a primary image.',
            'warning'
        );
        showStep(4);
        return;
    }

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    appendImageChanges(formData);

    formData.set('save_mode', 'approved');


    $.ajax({
        url: "<?= site_url('seller/products/store') ?>",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        beforeSend: function () {
            button.prop('disabled', true).text('Saving...');
        },

        success: function (response) {
            console.log('Product save response:', response);

            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'Product saved successfully!'
                }).then(function () {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        console.error('Redirect URL is missing.');
                    }
                });
            } else {
                Swal.fire(
                    'Error',
                    response.message || 'Unable to save product.',
                    'error'
                );
            }
        },

        error: function (xhr) {
            console.error('HTTP status:', xhr.status);
            console.error('Response:', xhr.responseText);

            Swal.fire(
                'Error',
                xhr.responseJSON?.message || 'Unable to save product.',
                'error'
            );
        },

        complete: function () {
            button.prop('disabled', false).html(oldText);
        }
    });
});


function calculateListingPrice() {
    const basePrice = parseFloat(
        document.getElementById('selling_price').value
    );

    const shippingAllowance = parseFloat(
        document.getElementById('shipping_allowance').value
    );

    const finalPriceInput = document.getElementById('final_listing_price');

    // Wait until both values are available.
    if (
        !Number.isFinite(basePrice) ||
        basePrice <= 0 ||
        !Number.isFinite(shippingAllowance) ||
        shippingAllowance < 0
    ) {
        finalPriceInput.value = '';
        return;
    }

    const finalPrice = basePrice + shippingAllowance;

    finalPriceInput.value = finalPrice.toFixed(2);

    // Refresh the review if the seller is on step 4.
    if (typeof currentStep !== 'undefined' && currentStep === 4) {
        buildReview();
    }
}

// Recalculate when either value changes.
document.getElementById('selling_price')
    .addEventListener('input', calculateListingPrice);

document.getElementById('shipping_allowance')
    .addEventListener('input', calculateListingPrice);

</script>

<script>
$(document).ready(function () {

    let shippingRequest = null;

    function calculateShippingAllowance() {
        const weightPerUnit = parseFloat($('#shipping_weight').val()) || 0;
        const length = parseFloat($('#length').val()) || 0;
        const width = parseFloat($('#width').val()) || 0;
        const height = parseFloat($('#height').val()) || 0;

        const minOrderQuantity =
            parseInt($('#min_order_quantity').val(), 10) || 1;

        const allowanceInput = $('#shipping_allowance');
        const message = $('#shippingAllowanceMessage');

        if (shippingRequest) {
            shippingRequest.abort();
            shippingRequest = null;
        }

        allowanceInput.val('');
        $('#final_listing_price').val('');

        if (
            weightPerUnit <= 0 ||
            length <= 0 ||
            width <= 0 ||
            height <= 0 ||
            minOrderQuantity < 1
        ) {
            message.text(
                'Enter valid shipping weight, dimensions and minimum order quantity.'
            );
            return;
        }

        // Total actual weight for the minimum order.
        const totalWeight = weightPerUnit * minOrderQuantity;

        message.text('Calculating shipping for ' +
            minOrderQuantity + ' unit(s)...');

        shippingRequest = $.ajax({
            url: "<?= site_url('seller/products/shipping-allowance') ?>",
            type: 'POST',
            dataType: 'json',

            data: {
                // Total weight, not weight of a single unit.
                shipping_weight: totalWeight,

                // Additional information for server-side calculations.
                shipping_weight_per_unit: weightPerUnit,
                min_order_quantity: minOrderQuantity,

                length: length,
                width: width,
                height: height,

                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },

            success: function (response) {
                if (!response.status) {
                    message.text(
                        response.message ||
                        'Unable to calculate shipping.'
                    );
                    return;
                }

                // Expected server response: total shipping charge
                // for the entire minimum-order shipment.
                const totalShipping = Number(
                    response.total_shipping_allowance ??
                    response.shipping_allowance
                );

                if (!Number.isFinite(totalShipping) ||
                    totalShipping < 0) {
                    message.text(
                        'Invalid shipping charge received from server.'
                    );
                    return;
                }

                // Divide the total shipment charge across all units.
                const perUnitAllowance =
                    totalShipping / minOrderQuantity;

                allowanceInput.val(perUnitAllowance.toFixed(2));

                // Recalculate the final per-unit listing price.
                calculateListingPrice();

                message.text(
                    'Total shipment weight: ' +
                    totalWeight.toFixed(3) + ' kg. ' +
                    'Total shipping: ₹' + totalShipping.toFixed(2) +
                    '. Shipping per unit: ₹' +
                    perUnitAllowance.toFixed(2) + '.' +
                    (response.chargeable_weight_grams != null
                        ? ' Chargeable weight: ' +
                          response.chargeable_weight_grams + ' g.'
                        : '')
                );
            },

            error: function (xhr, status) {
                if (status !== 'abort') {
                    message.text(
                        'Unable to calculate shipping. Please try again.'
                    );
                }
            },

            complete: function () {
                shippingRequest = null;
            }
        });
    }

    $(
        '#shipping_weight, #length, #width, #height, ' +
        '#min_order_quantity'
    ).on('input change', calculateShippingAllowance);

});




const categoryNames = {};

// function selectedCategory() {
//     return form.querySelector('[name="category"]:checked')?.value || '';
// }

function selectedCategoryName() {
    const selected = form.querySelector('[name="category"]:checked');

    return selected
        ? selected.closest('.category-option')
            .querySelector('.category-name').textContent.trim()
        : '';
}

function createAttributeField(attribute) {
    const wrapper = document.createElement('div');
    wrapper.className = 'field';

    const label = document.createElement('label');
    label.htmlFor = 'attribute_' + attribute.id;
    label.textContent = attribute.label || attribute.attribute_name;

    if (Number(attribute.is_required) === 1) {
        const required = document.createElement('span');
        required.textContent = ' *';
        label.appendChild(required);
    }

    const fieldName = `attributes[${attribute.id}]`;
    const fieldId = `attribute_${attribute.id}`;

    const type = String(attribute.input_type || 'text').toLowerCase();

    let control;

    if (type === 'select') {
        control = document.createElement('select');

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Select ' +
            (attribute.label || attribute.attribute_name);

        control.appendChild(placeholder);

        let options = [];

        try {
            options = attribute.options_json
                ? JSON.parse(attribute.options_json)
                : [];
        } catch (error) {
            console.error('Invalid options_json:', attribute.id);
        }

        if (Array.isArray(options)) {
            options.forEach(optionValue => {
                const option = document.createElement('option');
                option.value = String(optionValue);
                option.textContent = String(optionValue);
                control.appendChild(option);
            });
        }
    } else if (type === 'textarea') {
        control = document.createElement('textarea');
        control.rows = 3;
    } else {
        control = document.createElement('input');

        const allowedTypes = [
            'text', 'number', 'date', 'email', 'url'
        ];

        control.type = allowedTypes.includes(type) ? type : 'text';

        if (control.type === 'number') {
            control.step = 'any';
        }
    }

    control.id = fieldId;
    control.name = fieldName;
    control.dataset.attributeName = attribute.attribute_name;
    // select.dataset.attributeName = attribute.name;
    control.required = Number(attribute.is_required) === 1;

    wrapper.append(label, control);

    return wrapper;
}

let attributeRequestId = 0;


function loadCategoryAttributes(categoryId, subcategoryId = '') {
    const container = document.getElementById('dynamicAttributes');
    const requestId = ++attributeRequestId;

    container.replaceChildren();

    if (!categoryId) {
        container.textContent = 'Select a category first.';
        return Promise.resolve([]);
    }

    const loading = document.createElement('p');
    loading.className = 'help';
    loading.textContent = 'Loading product attributes...';
    container.appendChild(loading);

    return $.ajax({
        url: "<?= site_url('seller/products/category-attributes') ?>/"
            + encodeURIComponent(categoryId),
        type: 'GET',
        data: {
            subcategory_id: subcategoryId
        },
        dataType: 'json'
    }).then(function (response) {
        if (requestId !== attributeRequestId) return [];

        container.replaceChildren();

        if (response.status !== 'success') {
            throw new Error(
                response.message || 'Unable to load attributes.'
            );
        }

        const attributes = response.attributes || [];

        if (attributes.length === 0) {
            container.textContent =
                'No additional attributes are configured for this selection.';

            return [];
        }

        attributes.forEach(function (attribute) {
            container.appendChild(createAttributeField(attribute));
        });

        // Resolve only after all attribute fields have been created.
        return attributes;
    }).catch(function (error) {
        if (requestId === attributeRequestId) {
            container.replaceChildren();

            const message = document.createElement('p');
            message.className = 'text-danger';
            message.textContent =
                error.responseJSON?.message ||
                error.message ||
                'Failed to load attributes. Please try again.';

            container.appendChild(message);
        }

        throw error;
    });
}
 

loadCategoryAttributes.requestId = 0;

form.querySelectorAll('[name="category"]').forEach(radio => {
    radio.addEventListener('change', function () {
        loadCategoryAttributes(this.value);
    });
});



const productTypeSelect = document.getElementById('product_type_id');
const productTypeWrapper = document.getElementById('productTypeWrapper');
const productTypeMessage = document.getElementById('productTypeMessage');

let productTypeRequestId = 0;


function loadProductTypes(subcategoryId) {
    const requestId = ++productTypeRequestId;

    productTypeSelect.replaceChildren(
        new Option('Loading product types...', '')
    );

    productTypeSelect.disabled = true;
    productTypeSelect.required = false;
    productTypeWrapper.hidden = !subcategoryId;

    if (!subcategoryId) {
        productTypeMessage.textContent =
            'Choose a subcategory to load product types.';

        return Promise.resolve([]);
    }

    productTypeMessage.textContent = 'Loading product types...';

    return $.ajax({
        url: "<?= site_url('seller/products/product-types') ?>/"
            + encodeURIComponent(subcategoryId),
        type: 'GET',
        dataType: 'json'
    }).then(function (response) {
        if (requestId !== productTypeRequestId) return [];

        productTypeSelect.replaceChildren(
            new Option('Select product type', '')
        );

        if (response.status !== 'success') {
            throw new Error(
                response.message || 'Unable to load product types.'
            );
        }

        const productTypes = response.productTypes || [];

        if (productTypes.length === 0) {
            productTypeWrapper.hidden = true;
            productTypeSelect.required = false;
            productTypeSelect.disabled = true;
            productTypeMessage.textContent =
                'No product types are configured for this subcategory.';

            return [];
        }

        productTypes.forEach(function (type) {
            productTypeSelect.add(
                new Option(type.name, type.id)
            );
        });

        productTypeWrapper.hidden = false;
        productTypeSelect.disabled = false;
        productTypeSelect.required = true;
        productTypeMessage.textContent =
            'Select the product type for this subcategory.';

        return productTypes;
    }).catch(function (error) {
        if (requestId === productTypeRequestId) {
            productTypeSelect.disabled = true;
            productTypeSelect.required = false;
            productTypeMessage.textContent =
                error.responseJSON?.message ||
                error.message ||
                'Failed to load product types.';
        }

        throw error;
    });
}


</script>

<script>
$(function () {
    const $input = $('#hsn_code');
    const $results = $('#ajHsnResults');
    let request = null;

    $input.on('input', function () {
        const term = $.trim(this.value);

        $results.empty().hide();

        if (term.length < 3) {
            return;
        }

        if (request) {
            request.abort();
        }

        request = $.ajax({
            url: <?= json_encode(
                site_url('seller/hsn/search')
            ) ?>,
            type: 'GET',
            dataType: 'json',
            data: { q: term },

            success: function (response) {
                $results.empty();

                if (!response.status ||
                    !response.results ||
                    response.results.length === 0) {
                    return;
                }

                response.results.forEach(function (item) {
                    const $option = $('<button>', {
                        type: 'button',
                        class: 'list-group-item list-group-item-action'
                    });

                    $option.append(
                        $('<strong>').text(item.hsn_code)
                    );

                    $option.append(
                        $('<div>')
                            .addClass('small text-muted')
                            .text(item.description)
                    );

                    $option.on('click', function () {
                        $input.val(item.hsn_code);
                        $results.empty().hide();
                    });

                    $results.append($option);
                });

                $results.show();
            },

            error: function (xhr, status) {
                if (status !== 'abort') {
                    $results.empty().hide();
                }
            }
        });
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest(
            '#hsn_code, #ajHsnResults'
        ).length) {
            $results.hide();
        }
    });
});


$(function () {
    const $sku = $('#sku');
    const $message = $('#skuValidationMessage');
    const $submit = $('#submitProduct');

    let skuRequest = null;
    let skuTimer = null;
    let skuCheckId = 0;

    function setSkuMessage(message, color) {
        $message.text(message).css('color', color);
    }

    function checkSkuAvailability() {
        const sku = $.trim($sku.val());
        const productId = $('#product_id').val() || '';

        const requestId = ++skuCheckId;

        if (skuRequest) {
            skuRequest.abort();
            skuRequest = null;
        }

        clearTimeout(skuTimer);

        // Reset validation when SKU is empty.
        if (!sku) {
            $sku[0].setCustomValidity('');
            setSkuMessage('', '');
            return;
        }

        // Respect the existing no-spaces rule.
        if (/\s/.test(sku)) {
            $sku[0].setCustomValidity(
                'Spaces are not allowed in SKU.'
            );
            setSkuMessage('Spaces are not allowed.', '#dc3545');
            return;
        }

        $sku[0].setCustomValidity('');
        setSkuMessage('Checking SKU availability...', '#64748b');

        skuTimer = setTimeout(function () {
            skuRequest = $.ajax({
                url: <?= json_encode(site_url('seller/products/check-sku')) ?>,
                type: 'GET',
                dataType: 'json',
                data: {
                    sku: sku,
                    product_id: productId
                },

                success: function (response) {
                    if (requestId !== skuCheckId) return;

                    if (response.available) {
                        $sku[0].setCustomValidity('');
                        setSkuMessage(
                            'SKU is available.',
                            '#198754'
                        );
                    } else {
                        $sku[0].setCustomValidity(
                            response.message ||
                            'This SKU is already in use.'
                        );

                        setSkuMessage(
                            response.message ||
                            'This SKU is already in use.',
                            '#dc3545'
                        );
                    }
                },

                error: function (xhr, status) {
                    if (
                        status === 'abort' ||
                        requestId !== skuCheckId
                    ) {
                        return;
                    }

                    // Fail closed: do not allow saving until
                    // availability has been confirmed.
                    $sku[0].setCustomValidity(
                        'Unable to verify SKU. Please try again.'
                    );

                    setSkuMessage(
                        'Unable to verify SKU. Please try again.',
                        '#dc3545'
                    );
                },

                complete: function () {
                    if (requestId === skuCheckId) {
                        skuRequest = null;
                    }
                }
            });
        }, 350);
    }

    $sku.on('input', checkSkuAvailability);

    // Prevent submission if the availability request is still pending.
    $('#productForm').on('submit.skuValidation', function (event) {
        const validityMessage = $sku[0].validationMessage;

        if (
            !$sku[0].checkValidity() ||
            validityMessage === 'Unable to verify SKU. Please try again.'
        ) {
            event.preventDefault();
            $sku[0].reportValidity();
        }

        if (
            $message.text() === 'Checking SKU availability...'
        ) {
            event.preventDefault();
            setSkuMessage(
                'Please wait while we check the SKU.',
                '#dc3545'
            );
        }
    });
});

</script>

<?= $this->endSection() ?>


