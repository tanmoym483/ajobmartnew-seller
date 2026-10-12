

<style>
:root {
    --primary: #6c4cff;
    --primary-light: #f1edff;
    --border: #e5e7eb;
    --text: #202438;
    --muted: #747b8d;
    --bg: #f6f7fb;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
}

.page { max-width: 1250px; margin: auto; padding: 28px 20px; }

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 24px;
}

h1 { font-size: 27px; margin: 0 0 8px; }
p { color: var(--muted); line-height: 1.6; }

.btn {
    border: 0;
    border-radius: 8px;
    padding: 12px 18px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
}

.btn-primary { background: var(--primary); color: white; }
.btn-light { background: white; border: 1px solid var(--border); color: var(--text); }
.btn:disabled { opacity: .45; cursor: not-allowed; }

.layout {
    display: grid;
    grid-template-columns: 245px minmax(0, 1fr);
    gap: 22px;
    align-items: start;
}

.card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 13px;
    padding: 25px;
    margin-bottom: 20px;
}

.steps { position: sticky; top: 20px; }

.step {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 10px;
    color: var(--muted);
    border-radius: 9px;
    margin-bottom: 7px;
}

.step.active { background: var(--primary-light); color: var(--primary); }
.step.done { color: #16834a; }

.step-number {
    width: 30px;
    height: 30px;
    flex-shrink: 0;
    border-radius: 50%;
    border: 1px solid var(--border);
    display: grid;
    place-items: center;
    font-size: 13px;
    font-weight: bold;
    background: white;
}

.step.active .step-number {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.step-title { font-weight: 700; font-size: 14px; }
.step-description { font-size: 12px; margin-top: 5px; }

.section-title { font-size: 19px; margin: 0 0 8px; }
.section-subtitle { font-size: 13px; margin: 0 0 24px; }

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.field { min-width: 0; }
.field.full { grid-column: 1 / -1; }

label {
    display: block;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 9px;
}

label span { color: #dc3545; }

input, select, textarea {
    width: 100%;
    padding: 12px 13px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    color: var(--text);
    font: inherit;
    font-size: 14px;
    outline: none;
}

input:focus, select:focus, textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px #6c4cff16;
}

textarea { min-height: 110px; resize: vertical; }

.help { font-size: 12px; color: var(--muted); margin-top: 7px; }

.category-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 13px;
}

.category-option { position: relative; }

.category-option input {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
}

.category-box {
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 17px 10px;
    text-align: center;
    cursor: pointer;
    height: 100%;
}

.category-box:hover,
.category-option input:checked + .category-box {
    border-color: var(--primary);
    background: var(--primary-light);
}

.category-icon { font-size: 28px; display: block; margin-bottom: 10px; }
.category-name { font-size: 13px; font-weight: 700; }

.upload-box {
    border: 2px dashed #d5d1e8;
    border-radius: 11px;
    padding: 28px 15px;
    text-align: center;
    background: #fcfbff;
}

.upload-box input { max-width: 100%; margin-top: 12px; }

.image-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 18px;
}

.image-item {
    position: relative;
    width: 95px;
    height: 95px;
}

.image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid var(--border);
    border-radius: 8px;
}

.remove-image {
    position: absolute;
    right: -7px;
    top: -7px;
    background: #dc3545;
    color: white;
    border: 0;
    border-radius: 50%;
    width: 23px;
    height: 23px;
    cursor: pointer;
}

.form-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    border-top: 1px solid var(--border);
    margin-top: 25px;
    padding-top: 22px;
}

.footer-right { display: flex; gap: 10px; }

.notice {
    padding: 14px;
    background: #fff8e7;
    color: #785c12;
    border-radius: 8px;
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.preview-table { width: 100%; border-collapse: collapse; }
.preview-table td {
    padding: 13px 8px;
    border-bottom: 1px solid var(--border);
    font-size: 14px;
    overflow-wrap: anywhere;
}
.preview-table td:first-child { color: var(--muted); width: 36%; }

.hidden { display: none !important; }

@media (max-width: 850px) {
    .layout { grid-template-columns: 1fr; }
    .steps {
        position: static;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 5px;
    }
    .step { padding: 10px 5px; flex-direction: column; }
    .step-description { display: none; }
    .category-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 520px) {
    .page { padding: 18px 12px; }
    .page-header { align-items: flex-start; flex-direction: column; }
    h1 { font-size: 23px; }
    .card { padding: 17px; }
    .form-grid { grid-template-columns: 1fr; }
    .field.full { grid-column: auto; }
    .steps { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    .step-title { font-size: 11px; }
    .category-grid { gap: 9px; }
    .form-footer { flex-wrap: wrap; }
}
</style>

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
                        <label class="category-option">
                            <input type="radio" name="category"
                                   value="electronics" required>
                            <div class="category-box">
                                <span class="category-icon">📱</span>
                                <span class="category-name">Electronics</span>
                            </div>
                        </label>

                        <label class="category-option">
                            <input type="radio" name="category" value="fashion">
                            <div class="category-box">
                                <span class="category-icon">👕</span>
                                <span class="category-name">Fashion</span>
                            </div>
                        </label>

                        <label class="category-option">
                            <input type="radio" name="category" value="grocery">
                            <div class="category-box">
                                <span class="category-icon">🛒</span>
                                <span class="category-name">Grocery</span>
                            </div>
                        </label>

                        <label class="category-option">
                            <input type="radio" name="category" value="home">
                            <div class="category-box">
                                <span class="category-icon">🏠</span>
                                <span class="category-name">Home & Kitchen</span>
                            </div>
                        </label>

                        <label class="category-option">
                            <input type="radio" name="category" value="beauty">
                            <div class="category-box">
                                <span class="category-icon">🧴</span>
                                <span class="category-name">Beauty & Care</span>
                            </div>
                        </label>

                        <label class="category-option">
                            <input type="radio" name="category" value="other">
                            <div class="category-box">
                                <span class="category-icon">📦</span>
                                <span class="category-name">Other Products</span>
                            </div>
                        </label>
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
                        <div class="field full category-fields hidden"
                             data-category="electronics">
                            <div class="notice">Electronics specifications</div>
                            <div class="form-grid">
                                <div class="field">
                                    <label for="model_number">Model Number</label>
                                    <input id="model_number" name="model_number">
                                </div>
                                <div class="field">
                                    <label for="warranty">Warranty</label>
                                    <select id="warranty" name="warranty">
                                        <option value="">Select warranty</option>
                                        <option value="no_warranty">No Warranty</option>
                                        <option value="6_months">6 Months</option>
                                        <option value="1_year">1 Year</option>
                                        <option value="2_years">2 Years</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="color">Color</label>
                                    <input id="color" name="color">
                                </div>
                                <div class="field">
                                    <label for="storage">Storage / Capacity</label>
                                    <input id="storage" name="storage"
                                           placeholder="e.g. 128 GB">
                                </div>
                            </div>
                        </div>

                        <!-- FASHION FIELDS -->
                        <div class="field full category-fields hidden"
                             data-category="fashion">
                            <div class="notice">Fashion specifications</div>
                            <div class="form-grid">
                                <div class="field">
                                    <label for="gender">Target Audience</label>
                                    <select id="gender" name="gender">
                                        <option value="">Select</option>
                                        <option value="men">Men</option>
                                        <option value="women">Women</option>
                                        <option value="unisex">Unisex</option>
                                        <option value="kids">Kids</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="size">Size</label>
                                    <input id="size" name="size"
                                           placeholder="e.g. S, M, L, XL">
                                </div>
                                <div class="field">
                                    <label for="fashion_color">Color</label>
                                    <input id="fashion_color" name="fashion_color">
                                </div>
                                <div class="field">
                                    <label for="fabric">Fabric / Material</label>
                                    <input id="fabric" name="fabric">
                                </div>
                            </div>
                        </div>

                        <!-- GROCERY FIELDS -->
                        <div class="field full category-fields hidden"
                             data-category="grocery">
                            <div class="notice">Grocery specifications</div>
                            <div class="form-grid">
                                <div class="field">
                                    <label for="net_weight">Net Weight / Volume</label>
                                    <input id="net_weight" name="net_weight"
                                           placeholder="e.g. 1 kg">
                                </div>
                                <div class="field">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" id="expiry_date"
                                           name="expiry_date">
                                </div>
                                <div class="field">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input id="manufacturer" name="manufacturer">
                                </div>
                                <div class="field">
                                    <label for="food_type">Product Type</label>
                                    <select id="food_type" name="food_type">
                                        <option value="">Select</option>
                                        <option value="vegetarian">Vegetarian</option>
                                        <option value="non_vegetarian">Non-vegetarian</option>
                                        <option value="other">Not applicable</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- HOME FIELDS -->
                        <div class="field full category-fields hidden"
                             data-category="home">
                            <div class="notice">Home & Kitchen specifications</div>
                            <div class="form-grid">
                                <div class="field">
                                    <label for="material">Material</label>
                                    <input id="material" name="material">
                                </div>
                                <div class="field">
                                    <label for="dimensions">Dimensions</label>
                                    <input id="dimensions" name="dimensions"
                                           placeholder="L × W × H">
                                </div>
                                <div class="field">
                                    <label for="item_weight">Item Weight</label>
                                    <input id="item_weight" name="item_weight"
                                           placeholder="e.g. 500 g">
                                </div>
                                <div class="field">
                                    <label for="home_type">Product Type</label>
                                    <input id="home_type" name="home_type">
                                </div>
                            </div>
                        </div>

                        <!-- BEAUTY FIELDS -->
                        <div class="field full category-fields hidden"
                             data-category="beauty">
                            <div class="notice">Beauty & Personal Care specifications</div>
                            <div class="form-grid">
                                <div class="field">
                                    <label for="skin_type">Skin / Hair Type</label>
                                    <input id="skin_type" name="skin_type">
                                </div>
                                <div class="field">
                                    <label for="beauty_quantity">Net Quantity</label>
                                    <input id="beauty_quantity" name="beauty_quantity"
                                           placeholder="e.g. 100 ml">
                                </div>
                                <div class="field">
                                    <label for="ingredients">Key Ingredients</label>
                                    <input id="ingredients" name="ingredients">
                                </div>
                                <div class="field">
                                    <label for="beauty_expiry">Expiry Date</label>
                                    <input type="date" id="beauty_expiry"
                                           name="beauty_expiry">
                                </div>
                            </div>
                        </div>

                        <div class="field full category-fields hidden"
                             data-category="other">
                            <div class="field">
                                <label for="other_specs">Additional Specifications</label>
                                <textarea id="other_specs" name="other_specs"
                                          placeholder="Enter product specifications"></textarea>
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

                        <div class="field">
                            <label for="selling_price">Selling Price (₹) <span>*</span></label>
                            <input type="number" id="selling_price"
                                   name="selling_price" min="0.01"
                                   step="0.01" required>
                        </div>

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
                            <label for="shipping_weight">Shipping Weight (kg)</label>
                            <input type="number" id="shipping_weight"
                                   name="shipping_weight" min="0" step="0.001">
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

<script>
const form = document.getElementById('productForm');
const steps = [...document.querySelectorAll('.product-step')];
const indicators = [...document.querySelectorAll('[data-step-indicator]')];

let currentStep = 1;
let imageFiles = [];

const categoryNames = {
    electronics: 'Electronics',
    fashion: 'Fashion',
    grocery: 'Grocery',
    home: 'Home & Kitchen',
    beauty: 'Beauty & Personal Care',
    other: 'Other Products'
};

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

        if (price > mrp) {
            alert('Selling price should not be higher than MRP.');
            document.getElementById('selling_price').focus();
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

function buildReview() {
    const category = selectedCategory();
    const mrp = Number(getValue('mrp') || 0);
    const price = Number(getValue('selling_price') || 0);
    const discount = mrp > 0 ? Math.max(0, (mrp - price) / mrp * 100) : 0;

    const rows = [
        ['Category', categoryNames[category] || ''],
        ['Product Name', getValue('product_name')],
        ['Brand', getValue('brand')],
        ['Seller SKU', getValue('sku')],
        ['Description', getValue('description')],
        ['Condition', getValue('condition')],
        ['MRP', '₹' + mrp.toFixed(2)],
        ['Selling Price', '₹' + price.toFixed(2)],
        ['Discount', discount.toFixed(1) + '%'],
        ['Available Stock', getValue('stock_quantity')],
        ['Shipping Weight', getValue('shipping_weight') + ' kg'],
        ['Dispatch Time', getValue('shipping_days') + ' day(s)'],
        ['Images', imageFiles.length + ' selected'],
        ['Listing Status',
            getValue('product_status') === 'draft'
                ? 'Draft'
                : 'Submit for Approval']
    ];

    const tbody = document.getElementById('productReview');
    tbody.replaceChildren();

    rows.forEach(([label, value]) => {
        const tr = document.createElement('tr');
        const left = document.createElement('td');
        const right = document.createElement('td');

        left.textContent = label;
        right.textContent = value || '—';

        tr.append(left, right);
        tbody.append(tr);
    });
}

// Recalculate preview as the seller edits the form.
form.addEventListener('input', () => {
    if (currentStep === 4) buildReview();
});

form.addEventListener('change', () => {
    if (currentStep === 4) buildReview();
});

// Frontend demo only: connect this to your CI4 POST route.
form.addEventListener('submit', event => {
    event.preventDefault();

    if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
        const invalidStep = !validateStep(1) ? 1
            : !validateStep(2) ? 2 : 3;
        showStep(invalidStep);
        return;
    }

    if (imageFiles.length === 0) {
        alert('Please upload at least one product image.');
        return;
    }

    alert(
        'Frontend validation successful! Connect this form to your ' +
        'CodeIgniter 4 controller to save the product.'
    );
});

showStep(1);






// $(document).ready(function () {

//     $('#productForm').on('submit', function (e) {
//         e.preventDefault();

//         const form = this;
//         const $button = $('#submitProduct');
//         const originalText = $button.html();

//         // Browser validation
//         if (!form.checkValidity()) {
//             form.reportValidity();
//             return;
//         }

//         // Validate images if the input exists
//         const imageInput = form.querySelector(
//             'input[name="product_images[]"]'
//         );

//         if (imageInput && imageInput.files.length === 0) {
//             Swal.fire({
//                 icon: 'warning',
//                 title: 'Product Images Required',
//                 text: 'Please select at least one product image.'
//             });
//             return;
//         }

//         if (imageInput && imageInput.files.length > 8) {
//             Swal.fire({
//                 icon: 'warning',
//                 title: 'Too Many Images',
//                 text: 'You can upload a maximum of 8 images.'
//             });
//             return;
//         }

//         if (imageInput) {
//             for (const file of imageInput.files) {
//                 if (file.size > 5 * 1024 * 1024) {
//                     Swal.fire({
//                         icon: 'warning',
//                         title: 'Image Too Large',
//                         text: file.name + ' exceeds the 5 MB limit.'
//                     });
//                     return;
//                 }
//             }
//         }

//         $.ajax({
//             url: "<?= site_url('seller/products/store') ?>",
//             type: 'POST',
//             data: new FormData(form),
//             processData: false,
//             contentType: false,
//             dataType: 'json',

//             beforeSend: function () {
//                 $button
//                     .prop('disabled', true)
//                     .html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');
//             },

//             success: function (response) {

//                 if (response.status === 'success') {

//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Product Saved!',
//                         text: response.message ||
//                             'Your product has been saved successfully.',
//                         confirmButtonText: 'OK'
//                     }).then(function () {

//                         if (response.redirect) {
//                             window.location.href = response.redirect;
//                         } else {
//                             form.reset();
//                         }

//                     });

//                 } else {

//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Unable to Save',
//                         text: response.message ||
//                             'Please check the product details and try again.'
//                     });

//                 }
//             },

//             error: function (xhr) {
//                 let message = 'An unexpected error occurred.';

//                 if (xhr.responseJSON) {
//                     message = xhr.responseJSON.message ||
//                         (xhr.responseJSON.errors
//                             ? Object.values(xhr.responseJSON.errors).join('\n')
//                             : message);
//                 }

//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Save Failed',
//                     text: message
//                 });
//             },

//             complete: function () {
//                 $button
//                     .prop('disabled', false)
//                     .html(originalText);
//             }
//         });
//     });

// });

</script>

