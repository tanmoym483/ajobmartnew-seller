<?php
$sellerName = session()->get('seller_name') ?? 'Seller';
$sellerStatus = session()->get('seller_status') ?? 'pending';

$totalSales = $totalSales ?? 0;
$totalOrders = $totalOrders ?? 0;
$totalProducts = $totalProducts ?? 0;
$pendingOrders = $pendingOrders ?? 0;
$recentOrders = $recentOrders ?? [];
?>

<header class="aj-topbar">

            <div class="d-flex align-items-center gap-3">
                <button class="aj-mobile-menu"
                        type="button"
                        id="ajMobileMenu"
                        aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="aj-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search"
                           placeholder="Search dashboard..."
                           aria-label="Search dashboard">
                </div>
            </div>

            <div class="aj-profile">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold">
                        <?= esc($sellerName) ?>
                    </div>
                    <small class="text-muted">Seller account</small>
                </div>

                <div class="aj-avatar">
                    <?= esc(strtoupper(substr($sellerName, 0, 1))) ?>
                </div>
            </div>

        </header>