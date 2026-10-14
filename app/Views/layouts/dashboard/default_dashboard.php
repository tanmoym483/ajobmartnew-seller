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
<title>Sell on Ajobmart – Seller Home</title>
<link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet"
    >

    <style>
.aj-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f5f7fb;
    color: #17233c;
}

.aj-sidebar {
    width: 250px;
    flex-shrink: 0;
    background: #172554;
    color: white;
    padding: 24px 15px;
    transition: transform .25s ease;
}

.aj-brand {
    font-size: 25px;
    font-weight: 800;
    padding: 0 13px 30px;
}

.aj-brand span {
    color: #ffcf5c;
}

.aj-sidebar-label {
    color: #9eafd2;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 15px 13px 9px;
}

.aj-nav-link {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 13px;
    margin-bottom: 5px;
    border-radius: 9px;
    color: #dbe5fa;
    text-decoration: none;
    font-size: 14px;
    transition: .2s;
}

.aj-nav-link:hover,
.aj-nav-link.active {
    color: #fff;
    background: #2c4a86;
}

.aj-nav-link i {
    width: 20px;
    text-align: center;
}

.aj-dashboard-main {
    flex: 1;
    min-width: 0;
}

.aj-topbar {
    min-height: 76px;
    background: #fff;
    border-bottom: 1px solid #e8edf5;
    padding: 15px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.aj-search {
    max-width: 350px;
    width: 100%;
    position: relative;
}

.aj-search input {
    width: 100%;
    background: #f5f7fb;
    border: 1px solid #e5eaf3;
    border-radius: 9px;
    padding: 11px 15px 11px 40px;
    outline: none;
}

.aj-search i {
    position: absolute;
    top: 14px;
    left: 14px;
    color: #8994aa;
}

.aj-profile {
    display: flex;
    align-items: center;
    gap: 12px;
}

.aj-avatar {
    width: 42px;
    height: 42px;
    background: #e1eaff;
    color: #245dcc;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-weight: 800;
}

.aj-content {
    padding: 30px;
}

.aj-welcome {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 27px;
}

.aj-welcome h1 {
    font-size: 27px;
    font-weight: 800;
    margin: 0 0 8px;
}

.aj-muted {
    color: #7c879b;
    font-size: 14px;
}

.aj-status {
    display: inline-block;
    border-radius: 20px;
    padding: 7px 12px;
    font-size: 12px;
    font-weight: 700;
    background: #fff2cc;
    color: #946200;
    text-transform: capitalize;
}

.aj-status.approved,
.aj-status.active {
    background: #dcfce7;
    color: #166534;
}

.aj-status.rejected,
.aj-status.suspended {
    background: #fee2e2;
    color: #991b1b;
}

.aj-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.aj-stat-card {
    background: #fff;
    border: 1px solid #edf0f6;
    border-radius: 15px;
    padding: 22px;
    box-shadow: 0 4px 15px rgba(20, 40, 80, .025);
}

.aj-stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.aj-stat-icon {
    width: 46px;
    height: 46px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    font-size: 19px;
}

.aj-blue { background: #e7efff; color: #245dcc; }
.aj-green { background: #dcfce7; color: #15803d; }
.aj-purple { background: #f0e7ff; color: #7c3aed; }
.aj-orange { background: #ffedd5; color: #c2410c; }

.aj-stat-value {
    font-size: 27px;
    font-weight: 800;
    margin-top: 7px;
    overflow-wrap: anywhere;
}

.aj-quick-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 27px;
}

.aj-quick-card {
    display: flex;
    align-items: center;
    gap: 13px;
    background: #fff;
    padding: 19px;
    border: 1px solid #edf0f6;
    border-radius: 13px;
    color: #17233c;
    text-decoration: none;
    transition: .2s;
}

.aj-quick-card:hover {
    border-color: #b8cdfb;
    transform: translateY(-2px);
    color: #245dcc;
}

.aj-quick-card i {
    font-size: 21px;
    color: #245dcc;
}

.aj-panel {
    background: #fff;
    border: 1px solid #edf0f6;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 24px;
}

.aj-panel-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 21px 23px;
    border-bottom: 1px solid #edf0f6;
}

.aj-panel-heading h2 {
    font-size: 17px;
    font-weight: 800;
    margin: 0;
}

.aj-view-all {
    color: #245dcc;
    font-size: 13px;
    text-decoration: none;
    font-weight: 700;
}

.aj-table-wrap {
    overflow-x: auto;
}

.aj-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

.aj-table th {
    background: #fafbfe;
    color: #7c879b;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: .5px;
    padding: 15px 22px;
}

.aj-table td {
    padding: 17px 22px;
    border-top: 1px solid #f0f2f7;
    font-size: 13px;
}

.aj-order-status {
    display: inline-block;
    border-radius: 20px;
    padding: 6px 10px;
    font-size: 11px;
    background: #e7efff;
    color: #245dcc;
    text-transform: capitalize;
}

.aj-empty {
    padding: 45px 20px;
    text-align: center;
    color: #8994aa;
}

.aj-empty i {
    font-size: 34px;
    margin-bottom: 12px;
}

.aj-mobile-menu {
    display: none;
    border: 0;
    background: #edf2ff;
    color: #245dcc;
    border-radius: 8px;
    padding: 9px 12px;
}

.aj-sidebar-overlay {
    display: none;
}

@media (max-width: 1100px) {
    .aj-stats-grid,
    .aj-quick-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .aj-content {
        padding: 22px;
    }
}

@media (max-width: 767px) {
    .aj-sidebar {
        position: fixed;
        z-index: 1050;
        inset: 0 auto 0 0;
        width: 260px;
        overflow-y: auto;
        transform: translateX(-100%);
    }

    .aj-sidebar.open {
        transform: translateX(0);
    }

    .aj-sidebar-overlay.show {
        display: block;
        position: fixed;
        inset: 0;
        z-index: 1040;
        background: rgba(15, 23, 42, .5);
    }

    .aj-mobile-menu {
        display: inline-block;
    }

    .aj-topbar {
        padding: 13px 15px;
    }

    .aj-search {
        display: none;
    }

    .aj-content {
        padding: 18px 13px;
    }

    .aj-welcome {
        align-items: flex-start;
        flex-direction: column;
    }

    .aj-welcome h1 {
        font-size: 23px;
    }

    .aj-stats-grid {
        gap: 10px;
    }

    .aj-stat-card {
        padding: 15px;
    }

    .aj-stat-value {
        font-size: 22px;
    }

    .aj-stat-top {
        margin-bottom: 13px;
    }

    .aj-quick-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .aj-quick-card {
        padding: 14px 10px;
        align-items: flex-start;
        flex-direction: column;
    }

    .aj-panel-heading {
        padding: 17px;
    }
}

/* Desktop: fixed sidebar */
.aj-dashboard {
    display: flex;
    min-height: 100vh;
}

.aj-sidebar {
    width: 250px;
    flex: 0 0 250px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

.aj-dashboard-main {
    flex: 1;
    min-width: 0;
}

/* Hidden mobile-only controls on desktop */
.aj-mobile-menu,
.aj-sidebar-overlay,
.aj-bottom-nav {
    display: none;
}

/* Mobile navigation */
@media (max-width: 767px) {
    .aj-sidebar {
        position: fixed;
        z-index: 1050;
        top: 0;
        bottom: 0;
        left: 0;
        width: 270px;
        height: 100dvh;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform .25s ease;
    }

    .aj-sidebar.open {
        transform: translateX(0);
    }

    .aj-sidebar-overlay.show {
        display: block;
        position: fixed;
        inset: 0;
        z-index: 1040;
        background: rgba(15, 23, 42, .55);
    }

    .aj-mobile-menu {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Fixed bottom navigation */
    .aj-bottom-nav {
        position: fixed;
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1030;
        padding: 8px 4px calc(8px + env(safe-area-inset-bottom));
        background: #172554;
        border-top: 1px solid rgba(255,255,255,.12);
    }

    .aj-bottom-nav a,
    .aj-bottom-nav button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-width: 0;
        border: 0;
        background: transparent;
        color: #dbe5fa;
        text-decoration: none;
        font-size: 10px;
        padding: 4px 1px;
    }

    .aj-bottom-nav i {
        font-size: 18px;
    }

    .aj-bottom-nav a.active,
    .aj-bottom-nav button.active {
        color: #ffcf5c;
    }

    /* Prevent page content from being hidden behind bottom nav */
    .aj-content {
        padding: 18px 13px calc(95px + env(safe-area-inset-bottom));
    }

    .aj-topbar {
        padding: 12px 15px;
    }
}

</style>

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

</body>
</html>
