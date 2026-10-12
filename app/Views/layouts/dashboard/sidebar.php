
<!-- SIDEBAR -->
    <aside class="aj-sidebar" id="ajSidebar">

        <div class="aj-brand">Ajob<span>mart</span></div>

        <div class="aj-sidebar-label">Main menu</div>

        <a href="<?= site_url('seller/dashboard') ?>"
           class="aj-nav-link active">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <a href="<?= site_url('seller/products') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-box"></i> My Products
        </a>

        <a href="<?= site_url('seller/orders') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-cart-shopping"></i> Orders
        </a>

        <a href="<?= site_url('seller/inventory') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-warehouse"></i> Inventory
        </a>

        <div class="aj-sidebar-label">Business</div>

        <a href="<?= site_url('seller/sales') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-chart-line"></i> Sales Reports
        </a>

        <a href="<?= site_url('seller/payments') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-wallet"></i> Payments
        </a>

        <a href="<?= site_url('seller/profile') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-store"></i> Store Profile
        </a>

        <a href="<?= site_url('seller/settings') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-gear"></i> Settings
        </a>

        <div class="aj-sidebar-label">Account</div>

        <a href="<?= site_url('seller/logout') ?>"
           class="aj-nav-link">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>

    </aside>

    <div class="aj-sidebar-overlay" id="ajSidebarOverlay"></div>