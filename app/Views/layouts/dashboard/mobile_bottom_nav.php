<!-- MOBILE BOTTOM NAVIGATION -->
<nav class="aj-bottom-nav" aria-label="Seller mobile navigation">

    <a href="<?= site_url('seller/dashboard') ?>"
       class="active">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <a href="<?= site_url('seller/products') ?>">
        <i class="fa-solid fa-box"></i>
        <span>Products</span>
    </a>

    <a href="<?= site_url('seller/orders') ?>">
        <i class="fa-solid fa-bag-shopping"></i>
        <span>Orders</span>
    </a>

    <a href="<?= site_url('seller/payments') ?>">
        <i class="fa-solid fa-wallet"></i>
        <span>Payments</span>
    </a>

    <button type="button"
            id="ajBottomMore"
            aria-label="Open seller menu"
            aria-expanded="false">
        <i class="fa-solid fa-bars"></i>
        <span>More</span>
    </button>

</nav>
