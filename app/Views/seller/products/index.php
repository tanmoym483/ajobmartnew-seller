
<div class="aj-product-page">

    <div class="aj-product-header">
        <div>
            <h2>My Products</h2>
            <p>Manage and monitor your Ajobmart product listings.</p>
        </div>

        <div class="aj-product-actions">
            <button type="button" id="ajRefreshProducts"
                    class="btn btn-outline-primary">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>

            <a href="<?= site_url('seller/products/add') ?>"
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Listing
            </a>
        </div>
    </div>

    <div class="aj-product-stats">
        <div class="aj-stat-card">
            <span>Total Products</span>
            <strong id="ajTotalProducts">0</strong>
        </div>
        <div class="aj-stat-card">
            <span>Low Stock</span>
            <strong id="ajLowStock">0</strong>
        </div>
        <div class="aj-stat-card">
            <span>Out of Stock</span>
            <strong id="ajOutOfStock">0</strong>
        </div>
    </div>

    <div class="aj-product-panel">

        <div class="aj-product-toolbar">
            <input type="search"
                   id="ajProductSearch"
                   class="form-control"
                   placeholder="Search product, SKU or brand...">

            <select id="ajStatusFilter" class="form-control">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="active">Active</option>
                <option value="rejected">Rejected</option>
                <option value="inactive">Inactive</option>
            </select>

            <select id="ajCategoryFilter" class="form-control">
                <option value="">All Categories</option>
            </select>
        </div>

        <div class="aj-product-info">
            <span id="ajProductCount">Loading products...</span>
            <small id="ajLastUpdated">Waiting for data</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover aj-product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="ajProductTableBody">
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-spinner fa-spin"></i>
                            Loading products...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="ajProductEmpty" class="aj-empty-state" hidden>
            <i class="fas fa-box-open"></i>
            <h5>No products found</h5>
            <p>Try another search or add your first product.</p>
        </div>

        <div id="ajProductError" class="alert alert-danger m-3" hidden>
            Unable to load products.
        </div>

    </div>
</div>



