
    <style>
        body {
            background: #f5f7fb;
            color: #253047;
            font-family: Arial, sans-serif;
        }

        .inventory-card {
            background: #fff;
            border: 1px solid #e9edf4;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
        }

        .stat-number {
            font-size: 27px;
            font-weight: 700;
            margin-top: 8px;
        }

        .inventory-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .inventory-table th {
            background: #f8f9fc;
            font-size: 12px;
            text-transform: uppercase;
            color: #687386;
            padding: 15px;
            white-space: nowrap;
        }

        .inventory-table td {
            padding: 15px;
            vertical-align: middle;
        }

        .product-image {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 8px;
            background: #f0f2f5;
        }

        .stock-input {
            width: 85px;
        }

        .page-title {
            font-weight: 700;
        }

        .search-box {
            max-width: 320px;
        }

        .table-responsive {
            min-height: 150px;
        }
    </style>

<body>


<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Inventory Management</h3>
            <p class="text-secondary mb-0">Manage your Ajobmart product stock.</p>
        </div>

        <a href="<?= site_url('seller/products/add') ?>"
           class="btn btn-primary">
            + Add Product
        </a>
    </div>

    <!-- Inventory summary -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary">Total Products</div>
                    <h3 class="fw-bold mt-2">
                        <?= number_format((int)$stats['total_products']) ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary">Total Stock Units</div>
                    <h3 class="fw-bold mt-2">
                        <?= number_format((int)$stats['total_stock']) ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary">Low Stock Products</div>
                    <h3 class="fw-bold text-warning mt-2">
                        <?= number_format((int)$stats['low_stock_products']) ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary">Out of Stock</div>
                    <h3 class="fw-bold text-danger mt-2">
                        <?= number_format((int)$stats['out_of_stock_products']) ?>
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Search and filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <input type="search"
                           id="inventorySearch"
                           class="form-control"
                           placeholder="Search product, brand or SKU...">
                </div>

                <div class="col-md-3">
                    <select id="stockFilter" class="form-select">
                        <option value="all">All Stock</option>
                        <option value="in">In Stock</option>
                        <option value="low">Low Stock</option>
                        <option value="out">Out of Stock</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="all">All Product Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    <!-- Products table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="p-3">Product</th>
                            <th>SKU</th>
                            <th>MRP</th>
                            <th>Selling Price</th>
                            <th>Available Stock</th>
                            <th>Stock Status</th>
                            <th>Product Status</th>
                        </tr>
                    </thead>

                    <tbody id="inventoryTableBody">

                    <?php if (!empty($products)): ?>

                        <?php foreach ($products as $product): ?>

                            <?php
                                $stock = (int)($product['stock_quantity'] ?? 0);
                                $threshold = max(0, (int)($product['low_stock'] ?? 0));

                                if ($stock <= 0) {
                                    $stockType = 'out';
                                    $stockLabel = 'Out of Stock';
                                    $stockClass = 'danger';
                                } elseif ($stock <= $threshold) {
                                    $stockType = 'low';
                                    $stockLabel = 'Low Stock';
                                    $stockClass = 'warning';
                                } else {
                                    $stockType = 'in';
                                    $stockLabel = 'In Stock';
                                    $stockClass = 'success';
                                }

                                $name = $product['product_name'] ?? '';
                                $brand = $product['brand'] ?? '';
                                $sku = $product['sku'] ?? '';
                                $status = strtolower((string)($product['status'] ?? ''));
                                $imagePath = $product['image_path'] ?? '';
                            ?>

                            <tr class="inventory-row"
                                data-search="<?= esc(strtolower($name . ' ' . $brand . ' ' . $sku)) ?>"
                                data-stock="<?= esc($stockType) ?>"
                                data-status="<?= esc($status) ?>">

                                <td class="p-3">
                                    <div class="d-flex align-items-center gap-3">

                                        <?php
                                            // $imagePath = trim((string)($product['image_path'] ?? ''));

                                            $imageUrl = '';

                                            if ($imagePath !== '') {
                                                $imageUrl = site_url(
                                                    'shared-images/' . ltrim($imagePath, '/')
                                                );
                                            }
                                            ?>

                                            <?php if ($imageUrl !== ''): ?>
                                                <img
                                                    src="<?= esc($imageUrl) ?>"
                                                    alt="<?= esc($product['product_name']) ?>"
                                                    width="60"
                                                    height="60"
                                                    style="object-fit:cover;border-radius:8px;"
                                                    onerror="this.style.display='none';">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width:60px;height:60px;">
                                                    📦
                                                </div>
                                            <?php endif; ?>

                                        <div>
                                            <div class="fw-semibold">
                                                <?= esc($name) ?>
                                            </div>

                                            <small class="text-secondary">
                                                <?= esc($brand ?: 'No brand') ?>
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td><?= esc($sku ?: '-') ?></td>

                                <td>
                                    ₹<?= number_format((float)$product['mrp'], 2) ?>
                                </td>

                                <td class="fw-semibold">
                                    ₹<?= number_format((float)$product['selling_price'], 2) ?>
                                </td>

                                <td>
                                    <span class="fw-bold">
                                        <?= number_format($stock) ?>
                                    </span>
                                    <small class="text-secondary d-block">
                                        Alert at <?= $threshold ?>
                                    </small>
                                </td>

                                <td>
                                    <span class="badge text-bg-<?= $stockClass ?>">
                                        <?= esc($stockLabel) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge text-bg-secondary">
                                        <?= esc(ucfirst($status ?: 'unknown')) ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <h5>No products available</h5>
                                <p class="text-secondary mb-0">
                                    Your saved products will appear here.
                                </p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <div id="inventoryNoResults"
                 class="text-center text-secondary py-4 d-none">
                No matching products found.
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('inventorySearch');
    const stockFilter = document.getElementById('stockFilter');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('.inventory-row');
    const noResults = document.getElementById('inventoryNoResults');

    function filterInventory() {
        const keyword = search.value.trim().toLowerCase();
        const stock = stockFilter.value;
        const status = statusFilter.value;
        let visible = 0;

        rows.forEach(function (row) {
            const matchesSearch =
                (row.dataset.search || '').includes(keyword);

            const matchesStock =
                stock === 'all' || row.dataset.stock === stock;

            const matchesStatus =
                status === 'all' || row.dataset.status === status;

            const show =
                matchesSearch && matchesStock && matchesStatus;

            row.classList.toggle('d-none', !show);

            if (show) visible++;
        });

        noResults.classList.toggle(
            'd-none',
            visible > 0 || rows.length === 0
        );
    }

    search.addEventListener('input', filterInventory);
    stockFilter.addEventListener('change', filterInventory);
    statusFilter.addEventListener('change', filterInventory);

});
</script>



