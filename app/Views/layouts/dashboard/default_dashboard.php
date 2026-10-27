<?php
$session = session();

if (!$session->has('seller_id')) {
    return redirect()->to('/login');
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ajobmart – Seller Dashboard</title>

<link rel="icon" type="image/png"
      href="<?= base_url('public/assets/favicon/android-chrome-512x512.png') . '?v=2'; ?>">

      <!-- <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    > -->

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet"
    >
      
<link href="<?= base_url('public/assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- <link href="<?= base_url('public/assets/css/all.min.css') ?>"
        rel="stylesheet"
    > -->

<link rel="stylesheet" href="<?= base_url('public/assets/css/dashboardstylesheet.css')?>">

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>
<body>



<div class="aj-dashboard">

        <?= view('layouts/dashboard/sidebar') ?>

    <main class="aj-dashboard-main mb-4">

        <?= view('layouts/dashboard/header') ?>

        <?= $content ?>

    </main>
</div>

<?= view('layouts/dashboard/mobile_bottom_nav') ?>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page-specific scripts defined by child views -->
<?= $this->renderSection('scripts') ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('ajSidebar');
    const overlay = document.getElementById('ajSidebarOverlay');
    const topMenu = document.getElementById('ajMobileMenu');
    const bottomMore = document.getElementById('ajBottomMore');

    function closeSidebar() {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('show');
        bottomMore?.setAttribute('aria-expanded', 'false');
    }

    function toggleSidebar() {
        if (sidebar?.classList.contains('open')) {
            closeSidebar();
        } else {
            sidebar?.classList.add('open');
            overlay?.classList.add('show');
            bottomMore?.setAttribute('aria-expanded', 'true');
        }
    }

    topMenu?.addEventListener('click', toggleSidebar);
    bottomMore?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeSidebar();
    });
});
</script>

<script>
(function ($) {
    'use strict';

    const listUrl = <?= json_encode(
        site_url('seller/products/list-data'),
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    ) ?>;

    let allProducts = [];
    let loading = false;
    let request = null;

    function escapeHtml(value) {
        return String(value == null ? '' : value).replace(
            /[&<>"']/g,
            function (char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[char];
            }
        );
    }

    function money(value) {
        const amount = Number(value);
        return Number.isFinite(amount)
            ? '₹' + amount.toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
            : '—';
    }

    function statusBadge(status) {
        const value = String(status || 'unknown').toLowerCase();
        const known = [
            'draft', 'pending', 'approved',
            'active', 'rejected', 'inactive'
        ];
        const cls = known.includes(value) ? value : 'other';

        return '<span class="aj-status-badge aj-status-' + cls +
            '">' + escapeHtml(value.replace(/_/g, ' ')) + '</span>';
    }

    function stockBadge(product) {
        const qty = Number(product.stock_quantity || 0);
        const threshold = Number(product.low_stock || 0);

        if (qty <= 0) {
            return '<span class="aj-stock-badge aj-stock-out">Out of stock</span>';
        }

        if (threshold > 0 && qty <= threshold) {
            return '<span class="aj-stock-badge aj-stock-low">' +
                qty + ' · Low stock</span>';
        }

        return '<span class="aj-stock-badge aj-stock-ok">' +
            qty + ' · In stock</span>';
    }

    

function imageMarkup(product) {
    let path = String(
        product.image_path || ''
    ).trim();

    if (!path) {
        return '<div class="aj-product-image d-flex align-items-center ' +
            'justify-content-center">' +
            '<i class="fas fa-box text-muted"></i></div>';
    }

        const base = <?= json_encode(
            site_url('shared-images'),
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        ) ?>;

        path = base + '/' + path.split('/').map(encodeURIComponent).join('/');

    return '<img class="aj-product-image" src="' +
        escapeHtml(path) +
        '" alt="' + escapeHtml(product.product_name || 'Product') +
        '" loading="lazy" onerror="this.onerror=null;this.style.display=\'none\';">';
}



    function renderStats(products) {
        $('#ajTotalProducts').text(products.length);

        $('#ajLowStock').text(products.filter(function (p) {
            const qty = Number(p.stock_quantity || 0);
            const threshold = Number(p.low_stock || 0);
            return qty > 0 && threshold > 0 && qty <= threshold;
        }).length);

        $('#ajOutOfStock').text(products.filter(function (p) {
            return Number(p.stock_quantity || 0) <= 0;
        }).length);
    }

    function renderCategoryOptions(products) {
        const selected = $('#ajCategoryFilter').val() || '';
        const categories = [...new Set(products.map(function (p) {
            return String(p.category || '').trim();
        }).filter(Boolean))].sort();

        let html = '<option value="">All Categories</option>';

        categories.forEach(function (category) {
            html += '<option value="' + escapeHtml(category) + '">' +
                escapeHtml(category) + '</option>';
        });

        $('#ajCategoryFilter').html(html);

        if (categories.includes(selected)) {
            $('#ajCategoryFilter').val(selected);
        }
    }

    
const editProductUrl = <?= json_encode(site_url('seller/products/add')) ?>;

function renderProducts() {
    const search = String($('#ajProductSearch').val() || '').toLowerCase().trim();
    const status = String($('#ajStatusFilter').val() || '').toLowerCase();
    const category = String($('#ajCategoryFilter').val() || '').toLowerCase();

    const products = allProducts.filter(function (p) {
        const searchable = [
            p.product_name, p.sku, p.brand, p.sub_brand, p.category
        ].join(' ').toLowerCase();

        const approvalStatus = String(p.approval_status || '').toLowerCase();
        const productStatus = String(p.status || '').toLowerCase();

        // Draft/pending/approved come from approval_status.
        // Active/inactive come from the product status field.
        const matchesStatus = !status ||
            (['draft', 'pending', 'approved', 'rejected'].includes(status)
                ? approvalStatus === status
                : productStatus === status);

        return (!search || searchable.includes(search)) &&
            matchesStatus &&
            (!category || String(p.category || '').toLowerCase() === category);
    });

    $('#ajProductCount').text(
        'Showing ' + products.length + ' of ' + allProducts.length + ' products'
    );

    if (!products.length) {
        $('#ajProductTableBody').empty();
        $('#ajProductEmpty').prop('hidden', false);
        return;
    }

    $('#ajProductEmpty').prop('hidden', true);

    let html = '';

    products.forEach(function (p) {
        const name = p.product_name || 'Unnamed product';
        const brand = [p.brand, p.sub_brand].filter(Boolean).join(' · ');
        const mrp = Number(p.mrp || 0);
        const selling = Number(p.selling_price || 0);
        const listing = Number(p.listing_price || 0);
        const price = selling > 0 ? selling : (listing > 0 ? listing : mrp);

        const isDraft =
            String(p.approval_status || '').toLowerCase() === 'draft';

        let actions = '—';

        if (isDraft && Number(p.id) > 0) {
            const editUrl = editProductUrl +
                '?product_id=' + encodeURIComponent(p.id);

            actions =
                '<a href="' + escapeHtml(editUrl) + '"' +
                ' class="btn btn-sm btn-outline-primary">' +
                '<i class="fas fa-edit"></i> Edit Draft' +
                '</a>';
        }

        html += '<tr>' +
            '<td><div class="aj-product-item">' +
                imageMarkup(p) +
                '<div><div class="aj-product-name">' +
                    escapeHtml(name) + '</div>' +
                    '<div class="aj-product-sub">' +
                        escapeHtml(brand || p.category || '') + '</div>' +
                    '<div class="aj-product-sub">ID: ' +
                        escapeHtml(p.id) + '</div></div>' +
            '</div></td>' +
            '<td>' + escapeHtml(p.sku || '—') + '</td>' +
            '<td>' + escapeHtml(p.category || '—') + '</td>' +
            '<td><div class="aj-price-main">' + money(price) + '</div>' +
                (mrp > price
                    ? '<div class="aj-price-old">' + money(mrp) + '</div>'
                    : '') +
            '</td>' +
            '<td>' + stockBadge(p) + '</td>' +
            '<td>' + statusBadge(p.status) + '</td>' +
            '<td>' + escapeHtml(p.created_at || '—') + '</td>' +
            '<td>' + actions + '</td>' +
        '</tr>';
    });

    $('#ajProductTableBody').html(html);
}


    function loadProducts(manual) {
        if (loading) {
            if (manual && request) {
                request.abort();
            } else {
                return;
            }
        }

        loading = true;
        $('#ajProductError').prop('hidden', true);

        if (manual) {
            $('#ajRefreshProducts').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Refreshing');
        }

        request = $.ajax({
            url: listUrl,
            type: 'GET',
            dataType: 'json',
            cache: false
        }).done(function (response) {
            if (!response || response.status !== true ||
                !Array.isArray(response.products)) {
                $('#ajProductError').text(
                    response && response.message
                        ? response.message
                        : 'Unexpected server response.'
                ).prop('hidden', false);
                return;
            }

            allProducts = response.products;

            console.log(allProducts);

            renderStats(allProducts);
            renderCategoryOptions(allProducts);
            renderProducts();

            $('#ajLastUpdated').text(
                'Last updated: ' + new Date().toLocaleTimeString()
            );
        }).fail(function (xhr, status) {
            if (status === 'abort') {
                return;
            }

            const message = xhr.status === 401
                ? 'Your seller session has expired. Please log in again.'
                : 'Unable to load products. Check your connection and try again.';

            $('#ajProductError').text(message).prop('hidden', false);
        }).always(function () {
            loading = false;
            request = null;
            $('#ajRefreshProducts').prop('disabled', false)
                .html('<i class="fas fa-sync-alt"></i> Refresh');
        });
    }

    $(function () {
        $('#ajProductSearch, #ajStatusFilter, #ajCategoryFilter')
            .on('input change', renderProducts);

        $('#ajRefreshProducts').on('click', function () {
            loadProducts(true);
        });

        loadProducts(false);

        // Refresh product data without reloading the whole page.
        window.setInterval(function () {
            if (!document.hidden) {
                loadProducts(false);
            }
        }, 10000);
    });

})(jQuery); 



async function saveProductDraft(showMessage = false) {
    const form = document.getElementById('productForm');
    const formData = new FormData(form);
    appendImageChanges(formData);

    // Validate only visible and enabled fields.
    const fields = [
        ...form.querySelectorAll('input, select, textarea')
    ];

    for (const field of fields) {
        // Skip disabled fields and hidden inputs.
        if (field.disabled || field.type === 'hidden') {
            continue;
        }

        // Skip fields inside hidden steps.
        const hiddenStep = field.closest('.product-step.hidden');
        if (hiddenStep) {
            continue;
        }

        // Skip fields inside hidden category-specific sections.
        const hiddenCategoryField = field.closest('.category-fields.hidden');
        if (hiddenCategoryField) {
            continue;
        }

        // Validate only fields currently visible on screen.
        if (field.getClientRects().length === 0) {
            continue;
        }

        if (!field.checkValidity()) {
            field.reportValidity();
            field.focus();
            return false;
        }
    }

    formData.set('save_mode', 'draft');

    try {
        const response = await $.ajax({
            url: "<?= site_url('seller/products/store') ?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        });

        if (response.status === 'success') {
            // Reuse the same product ID for subsequent draft updates.

            

            if (response.product_id) {
                $('#product_id').val(response.product_id);
            }

            if (showMessage) {
                console.log('Product draft saved successfully.');
            }

            Swal.fire(
                'Draft saved',
                response.message || 'Your product draft was saved successfully.',
                'success'
            );

            const url = new URL(window.location.href);
            url.searchParams.set('product_id', response.product_id);

            window.history.replaceState({}, '', url);

            return true;
        }

        Swal.fire(
            'Draft not saved',
            response.message || 'Unable to save your product draft.',
            'error'
        );

        return false;

    } catch (error) {
        console.error('Draft save error:', error);

        const message =
            error.responseJSON?.message ||
            'Unable to save your draft. Please try again.';

        Swal.fire('Error', message, 'error');
        return false;
    }
}


function restoreSelectValue(selectElement, savedValue) {
    if (!selectElement || savedValue == null) {
        return false;
    }

    const value = String(savedValue).trim();

    // Find an option whose value exactly matches the saved value.
    const optionExists = Array.from(selectElement.options).some(
        option => option.value === value
    );

    if (!optionExists) {
        console.warn(
            'Saved select option not found:',
            selectElement.id,
            value
        );
        return false;
    }

    selectElement.value = value;

    // Confirm the value was selected successfully.
    return selectElement.value === value;
}

let existingProductImages = [];

function renderExistingProductImages(images) {
    existingImages = (images || []).map(function (image) {
        return {
            id: Number(image.id),
            url: image.url || '',
            image_name: image.image_name || 'Product image',
            is_primary: Number(image.is_primary) === 1
        };
    }).filter(function (image) {
        return image.url !== '';
    });

    const primaryImage = existingImages.find(
        image => image.is_primary
    );

    selectedPrimary = primaryImage
        ? { type: 'existing', id: primaryImage.id }
        : (
            existingImages.length
                ? { type: 'existing', id: existingImages[0].id }
                : null
        );

    removedImageIds = [];
    imageFiles = [];

    ensurePrimaryImage();
    renderImages();
}

async function restoreSavedDraft() {
    const params = new URLSearchParams(window.location.search);
    const productId = params.get('product_id');

    if (!productId) {
        return;
    }

    const form = document.querySelector('form');

    if (!form) {
        console.error('Product form was not found.');
        return;
    }

    // --------------------------------------------------
    // Helper: normalize saved values.
    // Supports arrays and comma-separated saved values.
    // --------------------------------------------------
    function normalizeValues(savedValue) {
        if (savedValue == null) {
            return [];
        }

        if (Array.isArray(savedValue)) {
            return savedValue.map(String);
        }

        if (typeof savedValue === 'object') {
            return Object.values(savedValue).map(String);
        }

        const value = String(savedValue);

        if (value === '') {
            return [''];
        }

        return value.split(',').map(value => value.trim());
    }

    // --------------------------------------------------
    // Helper: notify dependent code and selection widgets.
    // --------------------------------------------------
    function refreshField(field) {
        if (
            window.jQuery &&
            $(field).hasClass('select2-hidden-accessible')
        ) {
            $(field).trigger('change');
        } else {
            field.dispatchEvent(
                new Event('change', { bubbles: true })
            );
        }
    }

    // --------------------------------------------------
    // Helper: find all fields by ID or name.
    // Handles names such as color, color[], and repeated
    // checkbox/radio names.
    // --------------------------------------------------
    function findFields(fieldName) {
        const names = new Set([
            fieldName,
            fieldName + '[]'
        ]);

        return Array.from(form.elements).filter(function (field) {
            return field.id === fieldName || names.has(field.name);
        });
    }

    // --------------------------------------------------
    // Helper: set values for input, select, checkbox,
    // radio, multi-select, and textarea fields.
    // --------------------------------------------------
    function setFieldValue(field, savedValue) {
        if (!field || savedValue == null) {
            return;
        }

        const values = normalizeValues(savedValue);
        const selectedValues = new Set(values);

        if (field.type === 'checkbox' || field.type === 'radio') {
            field.checked = selectedValues.has(String(field.value));
            refreshField(field);
            return;
        }

        if (field.tagName === 'SELECT') {
            if (field.multiple) {
                Array.from(field.options).forEach(function (option) {
                    option.selected = selectedValues.has(
                        String(option.value)
                    );
                });
            } else {
                const saved = values[0] ?? '';
                const optionExists = Array.from(field.options).some(
                    option => String(option.value) === String(saved)
                );

                // Never assign a value that has no matching option.
                field.value = optionExists ? String(saved) : '';
            }

            refreshField(field);
            return;
        }

        field.value = values[0] ?? '';
        refreshField(field);
    }

    // --------------------------------------------------
    // Helper: restore a named field, including groups.
    // --------------------------------------------------
    function restoreField(fieldName, savedValue) {
        if (savedValue == null) {
            return;
        }

        const fields = findFields(fieldName);

        if (fields.length === 0) {
            return;
        }

        const firstField = fields[0];

        if (
            firstField.type === 'checkbox' ||
            firstField.type === 'radio'
        ) {
            fields.forEach(function (field) {
                setFieldValue(field, savedValue);
            });

            return;
        }

        // Use the first matching field for ordinary controls.
        setFieldValue(firstField, savedValue);
    }

    // --------------------------------------------------
    // Helper: restore saved dynamic attributes after
    // createAttributeField() has created the controls.
    //
    // Supports:
    // data-attribute-name="Color"
    // input/select/textarea, checkbox, radio, multiselect.
    // --------------------------------------------------




    function restoreDynamicAttributes(attributes) {
        const container = document.getElementById('dynamicAttributes');

        const fields = container.querySelectorAll(
            'input, select, textarea'
        );

        fields.forEach(function (field) {
            const attributeName = field.dataset.attributeName;

            if (
                !attributeName ||
                !Object.prototype.hasOwnProperty.call(
                    attributes,
                    attributeName
                )
            ) {
                return;
            }

            const savedValue = attributes[attributeName];

            if (savedValue == null) {
                return;
            }

            if (
                field.type === 'checkbox' ||
                field.type === 'radio'
            ) {
                const values = new Set(normalizeValues(savedValue));

                field.checked = values.has(String(field.value));
                refreshField(field);

                return;
            }

            setFieldValue(field, savedValue);
        });
    }

    try {
        // ==============================================
        // STEP 1: Fetch the saved product from the server.
        // ==============================================
        const response = await $.ajax({
            url: "<?= site_url('seller/products/draft') ?>/"
                + encodeURIComponent(productId),
            type: 'GET',
            dataType: 'json'
        });

        if (response.status !== 'success') {
            throw new Error(
                response.message || 'Unable to load product.'
            );
        }

        const product = response.product || {};
        const attributes = response.attributes || {};
        

        const savedImages = response.images || [];

        // console.log(savedImages);

        if (typeof renderExistingProductImages === 'function') {
            renderExistingProductImages(savedImages);
        }

        // ==============================================
        // STEP 2: Restore the hidden product ID.
        // ==============================================
        const productIdField = document.getElementById('product_id');

        if (productIdField) {
            productIdField.value = product.id ?? productId;
        }

        // ==============================================
        // STEP 3: Map database columns to form field names.
        // ==============================================
        const fieldMap = {
            product_name: 'product_name',
            brand: 'brand',
            sub_brand: 'sub_brand',
            sku: 'sku',
            description: 'description',
            product_condition: 'condition',
            mrp: 'mrp',
            selling_price: 'selling_price',
            listing_price: 'final_listing_price',
            shipping_allowance: 'shipping_allowance',
            stock_quantity: 'stock_quantity',
            low_stock: 'low_stock',
            shipping_weight: 'shipping_weight',
            shipping_days: 'shipping_days',
            shipping_type: 'shipping_type',
            package_length: 'length',
            package_width: 'width',
            package_height: 'height',
            country_of_origin: 'country_of_origin',
            hsn_code: 'hsn_code',
            gst_value: 'gst_value',
            manufacturer_name: 'manufacturer_name',
            packer_name: 'packer_name',
            key_features: 'key_features',
            pack_of: 'pack_of',
            min_order_quantity: 'min_order_quantity'
        };

        // ==============================================
        // STEP 4: Restore normal fields.
        // ==============================================
        Object.entries(fieldMap).forEach(function ([column, fieldName]) {
            if (product[column] != null) {
                restoreField(fieldName, product[column]);
            }
        });

        // ==============================================
        // STEP 5: Restore category and dependent dropdowns.
        // Wait for each AJAX call to complete before
        // assigning the saved selected value.
        // ==============================================
        const categoryId = product.category_id;
        const categorySlug = product.category_slug;
        const subcategoryId = product.subcategory_id;
        const productTypeId = product.product_type_id;

        if (categoryId != null) {
            // Restore the saved category selection.
            const categoryFields = findFields('category');

            const matchingCategory = categoryFields.find(function (field) {
                const matchesId =
                    categoryId != null &&
                    String(field.value) === String(categoryId);

                const matchesSlug =
                    categorySlug &&
                    field.dataset.slug === categorySlug;

                return matchesId || matchesSlug;
            });

            if (matchingCategory) {
                matchingCategory.checked = true;

                // Update the category-specific fields directly.
                const selectedId = String(matchingCategory.value);

                document.querySelectorAll('.category-fields').forEach(group => {
                    const active = group.dataset.category === selectedId;

                    group.classList.toggle('hidden', !active);

                    group.querySelectorAll('input, select, textarea').forEach(field => {
                        field.disabled = !active;
                    });
                });
            }

            // Load subcategory options first.
            const subcategoriesLoaded =
                await loadSubcategories(categoryId);

            if (!subcategoriesLoaded) {
                throw new Error(
                    'Unable to restore the saved subcategory options.'
                );
            }

            // Select the saved subcategory only after options exist.
            if (subcategoryId != null) {
                const subcategoryExists = Array.from(
                    subcategorySelect.options
                ).some(option =>
                    String(option.value) === String(subcategoryId)
                );

                if (subcategoryExists) {
                    subcategorySelect.value = String(subcategoryId);
                    refreshField(subcategorySelect);
                }

                // Load product types for the saved subcategory.
                const productTypesLoaded =
                    await loadProductTypes(subcategoryId);

                if (!productTypesLoaded) {
                    throw new Error(
                        'Unable to restore the saved product type options.'
                    );
                }

                if (productTypeId != null) {
                    const productTypeExists = Array.from(
                        productTypeSelect.options
                    ).some(option =>
                        String(option.value) === String(productTypeId)
                    );

                    if (productTypeExists) {
                        productTypeSelect.value = String(productTypeId);
                        refreshField(productTypeSelect);
                    }
                }

                // Generate the dynamic attributes for this selection.
                const attributesLoaded =
                    await loadCategoryAttributes(
                        categoryId,
                        subcategoryId
                    );

                if (!attributesLoaded) {
                    throw new Error(
                        'Unable to restore the saved category attributes.'
                    );
                }
            } else {
                const attributesLoaded =
                    await loadCategoryAttributes(categoryId, '');

                if (!attributesLoaded) {
                    throw new Error(
                        'Unable to load category attributes.'
                    );
                }
            }

            // ==========================================
            // STEP 6: Restore dynamic attributes AFTER
            // all their fields have been generated.
            // ==========================================
            restoreDynamicAttributes(attributes);
        }

        // ==============================================
        // STEP 7: Restore any other product fields
        // returned by the API, including additional
        // saved select fields with matching field names.
        // ==============================================
        const excludedKeys = new Set([
            'id',
            'category',
            'category_id',
            'category_slug',
            'subcategory_id',
            'product_type_id',
            'attributes',
            'status'
        ]);

        Object.entries(product).forEach(function ([key, value]) {
            if (
                value == null ||
                excludedKeys.has(key) ||
                Object.prototype.hasOwnProperty.call(fieldMap, key)
            ) {
                return;
            }

            restoreField(key, value);
        });

        // ==============================================
        // STEP 8: Restore listing status.
        // ==============================================
        const statusField = document.getElementById('product_status');

        if (statusField && product.status != null) {
            setFieldValue(statusField, product.status);
        }

        // ==============================================
        // STEP 9: Refresh select widgets and calculations.
        // ==============================================
        if (window.jQuery) {
            $('.select2-hidden-accessible').each(function () {
                $(this).trigger('change');
            });
        }

        if (typeof calculateListingPrice === 'function') {
            calculateListingPrice();
        }

        if (typeof buildReview === 'function') {
            buildReview();
        }

        console.log('Product draft restored successfully:', product.id);

    } catch (error) {
        console.error('Draft restoration failed:', error);

        Swal.fire(
            'Unable to Load Product',
            error.responseJSON?.message ||
                error.message ||
                'Please try again.',
            'error'
        );
    }
}

$(document).ready(function () {
    restoreSavedDraft();
});


</script>


</body>
</html>
