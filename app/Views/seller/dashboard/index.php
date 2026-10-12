
<?php
$sellerName = session()->get('seller_name') ?? 'Seller';
$sellerStatus = session()->get('seller_status') ?? 'pending';

$totalSales = $totalSales ?? 0;
$totalOrders = $totalOrders ?? 0;
$totalProducts = $totalProducts ?? 0;
$pendingOrders = $pendingOrders ?? 0;
$recentOrders = $recentOrders ?? [];
?>





        

        <div class="aj-content">

            <!-- WELCOME -->
            <div class="aj-welcome">
                <div>
                    <h1>Seller Dashboard</h1>
                    <p class="aj-muted mb-0">
                        Here's what's happening with your store today.
                    </p>
                </div>

                <span class="aj-status <?= esc(strtolower((string) $sellerStatus)) ?>">
                    <?= esc(ucfirst((string) $sellerStatus)) ?> account
                </span>
            </div>

            <!-- STATISTICS -->
            <div class="aj-stats-grid">

                <div class="aj-stat-card">
                    <div class="aj-stat-top">
                        <span class="aj-muted">Total Sales</span>
                        <div class="aj-stat-icon aj-blue">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>
                    </div>
                    <div class="aj-stat-value">
                        ₹<?= number_format((float) $totalSales, 2) ?>
                    </div>
                    <div class="aj-muted">Sales summary</div>
                </div>

                <div class="aj-stat-card">
                    <div class="aj-stat-top">
                        <span class="aj-muted">Total Orders</span>
                        <div class="aj-stat-icon aj-green">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                    </div>
                    <div class="aj-stat-value">
                        <?= number_format((int) $totalOrders) ?>
                    </div>
                    <div class="aj-muted">Orders received</div>
                </div>

                <div class="aj-stat-card">
                    <div class="aj-stat-top">
                        <span class="aj-muted">My Products</span>
                        <div class="aj-stat-icon aj-purple">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div class="aj-stat-value">
                        <?= number_format((int) $totalProducts) ?>
                    </div>
                    <div class="aj-muted">Products listed</div>
                </div>

                <div class="aj-stat-card">
                    <div class="aj-stat-top">
                        <span class="aj-muted">Pending Orders</span>
                        <div class="aj-stat-icon aj-orange">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                    <div class="aj-stat-value">
                        <?= number_format((int) $pendingOrders) ?>
                    </div>
                    <div class="aj-muted">Orders to process</div>
                </div>

            </div>

            <!-- QUICK ACTIONS -->
            <h2 class="fs-5 fw-bold mb-3">Quick Actions</h2>

            <div class="aj-quick-grid">

                <a href="<?= site_url('seller/products/add') ?>"
                   class="aj-quick-card">
                    <i class="fa-solid fa-circle-plus"></i>
                    <div>
                        <div class="fw-bold">Add Product</div>
                        <small class="aj-muted">List a new product</small>
                    </div>
                </a>

                <a href="<?= site_url('seller/orders') ?>"
                   class="aj-quick-card">
                    <i class="fa-solid fa-list-check"></i>
                    <div>
                        <div class="fw-bold">Manage Orders</div>
                        <small class="aj-muted">Process orders</small>
                    </div>
                </a>

                <a href="<?= site_url('seller/inventory') ?>"
                   class="aj-quick-card">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <div>
                        <div class="fw-bold">Inventory</div>
                        <small class="aj-muted">Manage stock</small>
                    </div>
                </a>

                <a href="<?= site_url('seller/profile') ?>"
                   class="aj-quick-card">
                    <i class="fa-solid fa-user-gear"></i>
                    <div>
                        <div class="fw-bold">Store Profile</div>
                        <small class="aj-muted">Update your details</small>
                    </div>
                </a>

            </div>

            <!-- RECENT ORDERS -->
            <section class="aj-panel">

                <div class="aj-panel-heading">
                    <h2>Recent Orders</h2>

                    <a href="<?= site_url('seller/orders') ?>"
                       class="aj-view-all">
                        View all orders →
                    </a>
                </div>

                <?php if (! empty($recentOrders)): ?>

                    <div class="aj-table-wrap">
                        <table class="aj-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr>
                                        <td>
                                            #<?= esc($order['order_id'] ?? $order['id'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($order['created_at'] ?? '') ?>
                                        </td>

                                        <td>
                                            ₹<?= number_format((float) ($order['total_amount'] ?? 0), 2) ?>
                                        </td>

                                        <td>
                                            <span class="aj-order-status">
                                                <?= esc(ucfirst((string) ($order['status'] ?? 'Pending'))) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>

                    <div class="aj-empty">
                        <i class="fa-solid fa-receipt d-block"></i>
                        <div class="fw-bold text-dark mb-2">
                            No orders yet
                        </div>
                        <div class="small">
                            Your recent customer orders will appear here.
                        </div>
                    </div>

                <?php endif; ?>

            </section>

            <div class="text-center aj-muted small pb-3">
                Ajobmart Seller Center
            </div>

        </div>


