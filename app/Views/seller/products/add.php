

<div class="page">

    <header class="page-header">
        <div>
            <h1>Add New Product</h1>
            <p>Create a product listing for your Ajobmart store.</p>
        </div>
        <button type="button" class="btn btn-light"
                onclick="window.location.href='../dashboard'">
            ← Back to Dashboard
        </button>
    </header>

    <div class="layout">

        <!-- LEFT STEP NAVIGATION -->
        <aside class="card steps">
            <div class="step active" data-step-indicator="1">
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

                        <div class="field full">
                            <label for="product_name">Product Name <span>*</span></label>
                            <input id="product_name" name="product_name"
                                   required maxlength="200"
                                   placeholder="e.g. Samsung Galaxy Smartphone">
                        </div>

                        <div class="field">
                            <label for="brand">Brand</label>
                            <input id="brand" name="brand"
                                   placeholder="Enter brand name">
                        </div>

                        <!-- Sub-brand -->
                        <div class="field">
                            <label for="sub_brand">Sub-brand</label>
                            <input
                                type="text"
                                class="form-control"
                                id="sub_brand"
                                name="sub_brand"
                                placeholder="e.g. Redmi">
                        </div>

                        <!-- Pack of -->
                        <div class="field">
                            <label for="pack_of">Pack of</label>
                            <input
                                type="number"
                                class="form-control"
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
                                class="form-control"
                                id="min_order_quantity"
                                name="min_order_quantity"
                                min="1"
                                value="1"
                                required>
                        </div>


                        <div class="field">
                            <label for="sku">Seller SKU</label>
                            <input id="sku" name="sku"
                                   placeholder="e.g. AJ-SKU-001">
                            <div class="help">Your own product identification code.</div>
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
                            <label for="product_status">Listing Status</label>
                            <select id="product_status" name="product_status">
                                <option value="draft">Save as Draft</option>
                                <option value="pending">Submit for Approval</option>
                            </select>
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
                        <div class="field">
                            <label for="hsn_code">HSN Code</label>
                            <input type="text"
                                id="hsn_code"
                                name="hsn_code"
                                maxlength="20"
                                placeholder="Enter applicable HSN code">
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

                        <!-- Model number -->
                        <!-- <div class="field">
                            <label for="model_number_general">Model Number</label>
                            <input type="text"
                                id="model_number_general"
                                name="model_number_general"
                                maxlength="100"
                                placeholder="Enter model number">
                        </div> -->

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
                            <button type="button" class="btn btn-primary"
                                    onclick="nextStep()">Continue →</button>
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
                                   min="0" value="5">
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
                        <button type="button" class="btn btn-primary"
                                onclick="nextStep()">Continue →</button>
                    </div>
                </section>

                <!-- STEP 4 -->
                <section class="card product-step hidden" data-step="4">
                    <h2 class="section-title">Product Images & Review</h2>
                    <p class="section-subtitle">
                        Upload clear product photos and verify the information.
                    </p>

                    <div class="field">
                        <label for="product_images">Product Images <span>*</span></label>
                        <div class="upload-box">
                            <div style="font-size:32px">📸</div>
                            <strong>Upload product images</strong>
                            <p>Choose up to 8 JPG, PNG or WebP images.</p>
                            <input type="file" id="product_images"
                                   name="product_images[]" accept="image/jpeg,image/png,image/webp"
                                   multiple required>
                        </div>
                        <div class="help">
                            Use your own product photos. Maximum 5 MB per image.
                        </div>
                        <div class="image-preview" id="imagePreview"></div>
                    </div>

                    <hr style="border:0;border-top:1px solid var(--border);margin:28px 0">

                    <h3>Product Preview</h3>
                    <p>Review your listing before submitting it.</p>

                    
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
                        <button type="submit" class="btn btn-primary"
                                id="submitProduct">Save Product</button>
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

function nextStep() {
    if (!validateStep(currentStep)) return;
    if (currentStep < 4) showStep(currentStep + 1);
}

function prevStep() {
    if (currentStep > 1) showStep(currentStep - 1);
}

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

// Show selected images and support removing individual files.
document.getElementById('product_images').addEventListener('change', event => {
    const selected = [...event.target.files];

    if (selected.length > 8) {
        alert('You can upload a maximum of 8 images.');
        event.target.value = '';
        imageFiles = [];
        renderImages();
        return;
    }

    const invalid = selected.find(file =>
        !['image/jpeg', 'image/png', 'image/webp'].includes(file.type) ||
        file.size > 5 * 1024 * 1024
    );

    if (invalid) {
        alert('Each image must be JPG, PNG or WebP and no larger than 5 MB.');
        event.target.value = '';
        imageFiles = [];
        renderImages();
        return;
    }

    imageFiles = selected;
    renderImages();
});

function renderImages() {
    const preview = document.getElementById('imagePreview');
    preview.replaceChildren();

    imageFiles.forEach((file, index) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'image-item';

        const img = document.createElement('img');
        const url = URL.createObjectURL(file);
        img.src = url;
        img.alt = file.name;
        img.onload = () => URL.revokeObjectURL(url);

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'remove-image';
        remove.textContent = '×';
        remove.setAttribute('aria-label', 'Remove ' + file.name);

        remove.addEventListener('click', () => {
            imageFiles.splice(index, 1);
            renderImages();
        });

        wrapper.append(img, remove);
        preview.append(wrapper);
    });

    // Sync the displayed files back to the file input.
    const transfer = new DataTransfer();
    imageFiles.forEach(file => transfer.items.add(file));
    document.getElementById('product_images').files = transfer.files;
}

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
        ['Listing Status', getValue('product_status') === 'draft'
            ? 'Save as Draft'
            : 'Submit for Approval', 'product_status'],
        ['Country of Origin', getValue('country_of_origin'), 'country_of_origin'],
        ['HSN Code', getValue('hsn_code'), 'hsn_code'],
        ['Manufacturer / Importer', getValue('manufacturer_name'), 'manufacturer_name'],
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
        ['Images', imageFiles.length + ' selected'],
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
    const button = $('#submitProduct');
    const oldText = button.html();

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    $.ajax({
        url: "<?= site_url('seller/products/store') ?>",
        type: 'POST',
        data: new FormData(form),
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
        const weight  = parseFloat($('#shipping_weight').val()) || 0;
        const length  = parseFloat($('#length').val()) || 0;
        const width   = parseFloat($('#width').val()) || 0;
        const height  = parseFloat($('#height').val()) || 0;

        
        if (weight <= 0 || length <= 0 || width <= 0 || height <= 0) {
            $('#shipping_allowance').val('');
            $('#final_listing_price').val('');

            $('#shippingAllowanceMessage').text(
                'Enter product dimensions and weight to calculate shipping.'
            );
            return;
        }


        if (shippingRequest) {
            shippingRequest.abort();
        }

        $('#shippingAllowanceMessage').text('Calculating shipping...');

        shippingRequest = $.ajax({
            url: "<?= site_url('seller/products/shipping-allowance') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                shipping_weight: weight,
                length: length,
                width: width,
                height: height,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            
            success: function (response) {
                if (response.status) {
                    const allowance = Number(response.shipping_allowance);

                    if (!Number.isFinite(allowance) || allowance < 0) {
                        $('#shipping_allowance').val('');
                        $('#final_listing_price').val('');

                        $('#shippingAllowanceMessage').text(
                            'Invalid shipping allowance received from server.'
                        );
                        return;
                    }

                    $('#shipping_allowance').val(allowance.toFixed(2));

                    // IMPORTANT: Recalculate after receiving the shipping charge.
                    calculateListingPrice();

                    $('#shippingAllowanceMessage').text(
                        'Chargeable weight: ' +
                        response.chargeable_weight_grams +
                        ' g. Shipping allowance calculated automatically.'
                    );
                } else {
                    $('#shipping_allowance').val('');
                    $('#final_listing_price').val('');

                    $('#shippingAllowanceMessage').text(
                        response.message || 'Unable to calculate shipping.'
                    );
                }
            },

            error: function (xhr, status) {
                if (status !== 'abort') {
                    $('#shippingAllowanceMessage').text(
                        'Unable to calculate shipping. Please try again.'
                    );
                }
            }
        });
    }

    $('#shipping_weight, #length, #width, #height')
        .on('input change', calculateShippingAllowance);

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
    control.required = Number(attribute.is_required) === 1;

    wrapper.append(label, control);

    return wrapper;
}

function loadCategoryAttributes(category) {
    const categoryId = category;
    const container = document.getElementById('dynamicAttributes');

    container.replaceChildren();

    if (!categoryId) {
        container.textContent = 'Select a category to load its attributes.';
        return;
    }

    const loading = document.createElement('p');
    loading.className = 'help';
    loading.textContent = 'Loading category attributes...';
    container.appendChild(loading);

    // Keep previous requests from overwriting the newest category.
    const requestId = ++loadCategoryAttributes.requestId;

    $.ajax({
        url: "<?= site_url('seller/products/category-attributes') ?>/"
            + encodeURIComponent(categoryId),
        type: 'GET',
        dataType: 'json',

        success: function (response) {
            if (requestId !== loadCategoryAttributes.requestId) {
                return;
            }

            container.replaceChildren();

            if (response.status !== 'success') {
                container.textContent =
                    response.message || 'Unable to load attributes.';
                return;
            }

            const attributes = response.attributes || [];

            if (attributes.length === 0) {
                container.textContent =
                    'No additional attributes are configured for this category.';
                return;
            }

            attributes.forEach(attribute => {
                container.appendChild(createAttributeField(attribute));
            });
        },

        error: function (xhr) {
            if (requestId !== loadCategoryAttributes.requestId) {
                return;
            }

            container.replaceChildren();

            const message = document.createElement('p');
            message.className = 'text-danger';
            message.textContent =
                xhr.responseJSON?.message ||
                'Failed to load attributes. Please try again.';

            container.appendChild(message);
        }
    });
}

loadCategoryAttributes.requestId = 0;

form.querySelectorAll('[name="category"]').forEach(radio => {
    radio.addEventListener('change', function () {
        loadCategoryAttributes(this.value);
    });
});
</script>

<?= $this->endSection() ?>


