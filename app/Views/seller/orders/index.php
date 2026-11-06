<?php
$baseOrderUrl = site_url('seller/orders');
?>

<style>
    .aj-order-page {
        --aj-order-border: #e5e7eb;
        --aj-order-muted: #6b7280;
    }

    .aj-order-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        white-space: nowrap;
        padding: 4px 2px 12px;
        scrollbar-width: thin;
    }

    .aj-order-tab {
        flex: 0 0 auto;
        border: 1px solid var(--aj-order-border);
        background: #fff;
        color: #374151;
        border-radius: 8px;
        padding: 10px 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .aj-order-tab.active {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .aj-order-tab .badge {
        margin-left: 5px;
        background: rgba(0,0,0,.12);
        color: inherit;
    }

    .aj-order-tab.active .badge {
        background: rgba(255,255,255,.22);
    }

    .aj-order-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: end;
    }

    .aj-order-filter .form-group {
        margin-bottom: 0;
        min-width: 150px;
    }

    .aj-order-table th,
    .aj-order-table td {
        vertical-align: middle !important;
    }

    .aj-order-table th {
        white-space: nowrap;
    }

    .aj-order-muted {
        color: var(--aj-order-muted);
        font-size: 12px;
    }

    .aj-order-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        min-width: 150px;
    }

    .aj-order-actions .btn {
        white-space: nowrap;
    }

    .aj-order-payment {
        font-size: 12px;
        line-height: 1.6;
    }

    .aj-order-empty {
        padding: 35px 10px !important;
        text-align: center;
        color: #6b7280;
    }

    @media (max-width: 767px) {
        .aj-order-filter .form-group {
            flex: 1 1 140px;
        }

        .aj-order-filter button {
            flex: 1 1 100%;
        }

        .aj-order-table {
            min-width: 1050px;
        }
    }
</style>

<div class="container-fluid py-3 aj-order-page">

    <!-- Page heading -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">My Orders</h4>
            <small class="text-muted">
                Manage orders containing your products
            </small>
        </div>

        <button type="button"
                class="btn btn-outline-primary btn-sm"
                id="refreshOrders">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <!-- Date and search filters -->
    <div class="card mb-3">
        <div class="card-body">

            <div class="aj-order-filter">

                <div class="form-group">
                    <label for="orderFromDate">From date</label>
                    <input type="date"
                           class="form-control"
                           id="orderFromDate">
                </div>

                <div class="form-group">
                    <label for="orderToDate">To date</label>
                    <input type="date"
                           class="form-control"
                           id="orderToDate">
                </div>

                <div class="form-group">
                    <label for="orderSearch">Search</label>
                    <input type="search"
                           class="form-control"
                           id="orderSearch"
                           placeholder="Order number / customer">
                </div>

                <button type="button"
                        class="btn btn-primary"
                        id="applyOrderFilters">
                    <i class="fas fa-filter"></i> Apply
                </button>

                <button type="button"
                        class="btn btn-outline-secondary"
                        id="clearOrderFilters">
                    Clear
                </button>

            </div>

            <small class="text-muted d-block mt-2">
                Date filtering is based on the order creation date.
            </small>

        </div>
    </div>

    <!-- Section tabs -->
    <div class="aj-order-tabs" id="ajOrderTabs">

        <button type="button"
                class="aj-order-tab active"
                data-section="pending">
            Pending
            <span class="badge" id="countPending">0</span>
        </button>

        <button type="button"
                class="aj-order-tab"
                data-section="rd">
            Ready to Dispatch
            <span class="badge" id="countRd">0</span>
        </button>

        <button type="button"
                class="aj-order-tab"
                data-section="shipped">
            Shipped
            <span class="badge" id="countShipped">0</span>
        </button>

        <button type="button"
                class="aj-order-tab"
                data-section="delivered">
            Delivered
            <span class="badge" id="countDelivered">0</span>
        </button>

    </div>

    <!-- Orders table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong id="currentSectionTitle">Pending Orders</strong>
            <small class="text-muted" id="orderResultCount">0 orders</small>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0 aj-order-table">

                    <thead class="thead-light">
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>Your Amount</th>
                            <th>Payment</th>
                            <th>Order Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="ordersTableBody">
                        <tr>
                            <td colspan="9" class="aj-order-empty">
                                <i class="fas fa-spinner fa-spin"></i>
                                Loading orders...
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>


<!-- Mark shipped modal -->
<div class="modal fade"
     id="markShippedModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <form id="markShippedForm">

                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title">Mark Order as Shipped</h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                           name="order_id"
                           id="shippedOrderId">

                    <div class="alert alert-info">
                        Enter the courier and tracking details before
                        marking this order as shipped.
                    </div>

                    <div class="form-group">
                        <label>Courier Name <span class="text-danger">*</span></label>

                        <input type="text"
                               name="courier_name"
                               id="courierName"
                               class="form-control"
                               placeholder="e.g. India Post"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Tracking Number <span class="text-danger">*</span></label>

                        <input type="text"
                               name="tracking_number"
                               id="trackingNumber"
                               class="form-control"
                               placeholder="Enter tracking number"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Tracking URL (optional)</label>

                        <input type="url"
                               name="tracking_url"
                               id="trackingUrl"
                               class="form-control"
                               placeholder="https://...">
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="confirmShippedButton">
                        <i class="fas fa-truck"></i>
                        Confirm Shipment
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
(function () {
    'use strict';

    const urls = {
        list: <?= json_encode(site_url('seller/orders/list-data')) ?>,
        generateLabel: <?= json_encode(site_url('seller/orders/generate-label')) ?>,
        viewLabel: <?= json_encode(site_url('seller/orders/label')) ?>,
        markShipped: <?= json_encode(site_url('seller/orders/mark-shipped')) ?>,
        markDelivered: <?= json_encode(site_url('seller/orders/mark-delivered')) ?>
    };

    const tbody = document.getElementById('ordersTableBody');

    const searchInput = document.getElementById('orderSearch');
    const fromDate = document.getElementById('orderFromDate');
    const toDate = document.getElementById('orderToDate');

    const refreshButton = document.getElementById('refreshOrders');

    const shippedForm = document.getElementById('markShippedForm');
    const shippedButton = document.getElementById('confirmShippedButton');

    let currentSection = 'pending';
    let currentOrders = [];
    let requestController = null;

    const sectionTitles = {
        pending: 'Pending Orders',
        rd: 'Ready to Dispatch Orders',
        shipped: 'Shipped Orders',
        delivered: 'Delivered Orders'
    };

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function money(value) {
        return '₹' + Number(value || 0).toFixed(2);
    }

    function formatDate(value) {
        if (!value) return '—';

        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return escapeHtml(value);
        }

        return date.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function paymentLabel(order) {
        const method = String(order.payment_method || '').toLowerCase();
        const status = String(order.payment_status || '').toLowerCase();

        let methodLabel = method.toUpperCase();

        if (method === 'cod' || method === 'cash_on_delivery') {
            methodLabel = 'COD';
        }

        return `
            <div class="aj-order-payment">
                <strong>${escapeHtml(methodLabel || '—')}</strong><br>
                <span class="text-muted">
                    ${escapeHtml(status || '—')}
                </span>
            </div>
        `;
    }

    function sellerStatusBadge(status) {
        const labels = {
            new: ['New', 'secondary'],
            processing: ['Processing', 'primary'],
            shipped: ['Shipped', 'info'],
            delivered: ['Delivered', 'success'],
            cancelled: ['Cancelled', 'danger']
        };

        const item = labels[String(status || '').toLowerCase()]
            || ['Pending', 'secondary'];

        return `
            <span class="badge badge-${item[1]}">
                ${escapeHtml(item[0])}
            </span>
        `;
    }

    function showMessage(message, type) {
        const alertType = type || 'info';

        const container = document.createElement('div');
        container.className = 'alert alert-' + alertType + ' alert-dismissible fade show';
        container.setAttribute('role', 'alert');

        const messageText = document.createElement('span');
        messageText.textContent = message;

        const close = document.createElement('button');
        close.type = 'button';
        close.className = 'close';
        close.setAttribute('data-dismiss', 'alert');
        close.innerHTML = '&times;';

        container.appendChild(messageText);
        container.appendChild(close);

        const page = document.querySelector('.aj-order-page');

        page.insertBefore(container, page.children[1]);

        setTimeout(function () {
            if (container.parentNode) {
                container.remove();
            }
        }, 4500);
    }

    function setLoading(message) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="aj-order-empty">
                    <i class="fas fa-spinner fa-spin"></i>
                    ${escapeHtml(message || 'Loading orders...')}
                </td>
            </tr>
        `;
    }

    function updateCounts(counts) {
        counts = counts || {};

        document.getElementById('countPending').textContent =
            Number(counts.pending || 0);

        document.getElementById('countRd').textContent =
            Number(counts.rd || 0);

        document.getElementById('countShipped').textContent =
            Number(counts.shipped || 0);

        document.getElementById('countDelivered').textContent =
            Number(counts.delivered || 0);
    }

    function updateActiveTab() {
        document.querySelectorAll('.aj-order-tab').forEach(function (tab) {
            tab.classList.toggle(
                'active',
                tab.dataset.section === currentSection
            );
        });

        document.getElementById('currentSectionTitle').textContent =
            sectionTitles[currentSection];
    }

    function labelActions(order) {
        const orderId = Number(order.id || order.order_id || 0);

        if (!orderId) return '';

        const labelExists = Boolean(
            order.label_id || order.label_number
        );

        if (currentSection === 'pending') {

            if (!Number(order.label_eligible)) {
                return `
                    <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            disabled
                            title="Online payment must be completed first">
                        <i class="fas fa-lock"></i>
                        Payment Pending
                    </button>
                `;
            }

            if (labelExists) {
                return `
                    <span class="badge badge-info">
                        Label already generated
                    </span>
                `;
            }

            return `
                <button type="button"
                        class="btn btn-sm btn-primary js-generate-label"
                        data-id="${orderId}">
                    <i class="fas fa-file-pdf"></i>
                    Generate Label
                </button>
            `;
        }

        if (currentSection === 'rd') {
            return `
                <p class="text-center">-<p>

                <!--
                <button type="button"
                        class="btn btn-sm btn-outline-primary js-view-label"
                        data-id="${orderId}">
                    <i class="fas fa-eye"></i>
                    View Label
                </button>

                <button type="button"
                        class="btn btn-sm btn-outline-secondary js-print-label"
                        data-id="${orderId}">
                    <i class="fas fa-print"></i>
                    Print
                </button>

                <button type="button"
                        class="btn btn-sm btn-success js-mark-shipped"
                        data-id="${orderId}">
                    <i class="fas fa-truck"></i>
                    Mark Shipped 
                </button>
                -->
            `;
        }

        if (currentSection === 'shipped') {
            return `
                <p class="text-center">-<p>
            <!--
                <button type="button"
                        class="btn btn-sm btn-outline-primary js-view-label"
                        data-id="${orderId}">
                    <i class="fas fa-eye"></i>
                    View Label
                </button>
                
                <button type="button"
                        class="btn btn-sm btn-success js-mark-delivered"
                        data-id="${orderId}">
                    <i class="fas fa-check"></i>
                    Mark Delivered
                </button>
                -->
            `;
        }

        if (currentSection === 'delivered') {
            return `
                <button type="button"
                        class="btn btn-sm btn-outline-primary js-view-label"
                        data-id="${orderId}">
                    <i class="fas fa-eye"></i>
                    View Label
                </button>

                <button type="button"
                        class="btn btn-sm btn-outline-secondary js-print-label"
                        data-id="${orderId}">
                    <i class="fas fa-print"></i>
                    Print
                </button>
            `;
        }

        return '';
    }

    function renderOrders() {
        const keyword = searchInput.value.trim().toLowerCase();

        const filtered = currentOrders.filter(function (order) {
            const orderNumber = String(order.order_number || '').toLowerCase();
            const customer = String(order.customer_name || '').toLowerCase();

            return orderNumber.includes(keyword) || customer.includes(keyword);
        });

        document.getElementById('orderResultCount').textContent =
            filtered.length + (filtered.length === 1 ? ' order' : ' orders');

        if (!filtered.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="aj-order-empty">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <br>
                        No orders found in this section.
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = filtered.map(function (order) {

            const orderId = Number(order.id || order.order_id || 0);

            const labelNumber = order.label_number
                ? `<div class="aj-order-muted">
                       Label: ${escapeHtml(order.label_number)}
                   </div>`
                : '';

            let statusContent = sellerStatusBadge(order.seller_status);

            if (currentSection === 'rd') {
                statusContent += `
                    <div class="aj-order-muted mt-1">
                        Shipping label generated
                    </div>
                `;
            }

            let dateContent = formatDate(order.created_at);

            if (currentSection === 'delivered' && order.delivered_at) {
                dateContent += `
                    <div class="aj-order-muted">
                        Delivered: ${formatDate(order.delivered_at)}
                    </div>
                `;
            }

            let trackingContent = '';

            if (
                currentSection === 'shipped' ||
                currentSection === 'delivered'
            ) {
                trackingContent = `
                    <div class="aj-order-muted mt-1">
                        ${escapeHtml(order.courier_name || '')}
                        ${order.tracking_number
                            ? '<br>Tracking: ' + escapeHtml(order.tracking_number)
                            : ''}
                    </div>
                `;
            }

            return `
                <tr>
                    <td>
                        <strong>${escapeHtml(order.order_number || ('#' + orderId))}</strong>
                        ${labelNumber}
                    </td>

                    <td>
                        ${escapeHtml(order.customer_name || 'Customer')}
                        ${order.customer_mobile
                            ? '<div class="aj-order-muted">' +
                                escapeHtml(order.customer_mobile) +
                              '</div>'
                            : ''}
                    </td>

                    <td>${Number(order.seller_item_count || 0)}</td>

                    <td>${Number(order.seller_total_quantity || 0)}</td>

                    <td>
                        <strong>${money(order.seller_totalAmount)}</strong>
                    </td>

                    <td>${paymentLabel(order)}</td>

                    <td>
                        ${statusContent}
                        ${trackingContent}
                    </td>

                    <td>${dateContent}</td>

                    <td>
                        <div class="aj-order-actions">
                            ${labelActions(order)}
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function loadOrders() {
        if (requestController) {
            requestController.abort();
        }

        requestController = new AbortController();

        setLoading('Loading ' + sectionTitles[currentSection] + '...');

        const params = new URLSearchParams({
            section: currentSection,
            from_date: fromDate.value,
            to_date: toDate.value
        });

        try {
            const response = await fetch(urls.list + '?' + params.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: requestController.signal
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                throw new Error(data.message || 'Unable to load orders.');
            }

            updateCounts(data.counts || {});

            currentOrders = Array.isArray(data.orders)
                ? data.orders
                : [];

            renderOrders();

        } catch (error) {
            if (error.name === 'AbortError') return;

            currentOrders = [];

            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="aj-order-empty text-danger">
                        ${escapeHtml(error.message)}
                    </td>
                </tr>
            `;

            document.getElementById('orderResultCount').textContent = '0 orders';
        }
    }

    function openLabel(orderId, print) {
        const url = urls.viewLabel + '/' + encodeURIComponent(orderId);

        if (print) {
            const printWindow = window.open(url + '?print=1', '_blank');

            if (!printWindow) {
                showMessage('Please allow pop-ups to print the label.', 'warning');
            }
            return;
        }

        window.open(url, '_blank');
    }

    async function postRequest(url, formData) {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (!response.ok || !data.status) {
            throw new Error(data.message || 'Request failed.');
        }

        return data;
    }

    // Change section.
    document.querySelectorAll('.aj-order-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            currentSection = this.dataset.section;

            updateActiveTab();
            loadOrders();
        });
    });

    // Apply date filters.
    document.getElementById('applyOrderFilters')
        .addEventListener('click', function () {

            if (
                fromDate.value &&
                toDate.value &&
                fromDate.value > toDate.value
            ) {
                showMessage('From date cannot be after To date.', 'warning');
                return;
            }

            loadOrders();
        });

    // Clear filters.
    document.getElementById('clearOrderFilters')
        .addEventListener('click', function () {

            fromDate.value = '';
            toDate.value = '';
            searchInput.value = '';

            loadOrders();
        });

    // Search current section.
    searchInput.addEventListener('input', renderOrders);

    // Refresh.
    refreshButton.addEventListener('click', loadOrders);

    // Table actions.
    tbody.addEventListener('click', async function (event) {

        const generateButton = event.target.closest('.js-generate-label');
        const viewButton = event.target.closest('.js-view-label');
        const printButton = event.target.closest('.js-print-label');
        const shippedOpenButton = event.target.closest('.js-mark-shipped');
        const deliveredButton = event.target.closest('.js-mark-delivered');

        if (viewButton) {
            openLabel(viewButton.dataset.id, false);
            return;
        }

        if (printButton) {
            openLabel(printButton.dataset.id, true);
            return;
        }

        if (shippedOpenButton) {
            document.getElementById('shippedOrderId').value =
                shippedOpenButton.dataset.id;

            shippedForm.reset();

            // Restore the selected order ID after resetting the form.
            document.getElementById('shippedOrderId').value =
                shippedOpenButton.dataset.id;

            $('#markShippedModal').modal('show');
            return;
        }

        if (generateButton) {
            const orderId = generateButton.dataset.id;

            if (!confirm('Generate shipping label for this order?')) {
                return;
            }

            generateButton.disabled = true;
            generateButton.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Generating...';

            const formData = new FormData();
            formData.append('order_id', orderId);

            const csrfInput = document.querySelector(
                '#markShippedForm input[type="hidden"]'
            );

            if (csrfInput) {
                formData.append(csrfInput.name, csrfInput.value);
            }

            try {
                const data = await postRequest(urls.generateLabel, formData);

                showMessage(data.message || 'Shipping label generated.', 'success');

                loadOrders();

            } catch (error) {
                showMessage(error.message, 'danger');

                generateButton.disabled = false;
                generateButton.innerHTML =
                    '<i class="fas fa-file-pdf"></i> Generate Label';
            }

            return;
        }

        if (deliveredButton) {
            const orderId = deliveredButton.dataset.id;

            if (!confirm('Confirm that this order has been delivered?')) {
                return;
            }

            deliveredButton.disabled = true;
            deliveredButton.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Updating...';

            const formData = new FormData();
            formData.append('order_id', orderId);

            const csrfInput = document.querySelector(
                '#markShippedForm input[type="hidden"]'
            );

            if (csrfInput) {
                formData.append(csrfInput.name, csrfInput.value);
            }

            try {
                const data = await postRequest(urls.markDelivered, formData);

                showMessage(data.message || 'Order marked as delivered.', 'success');

                loadOrders();

            } catch (error) {
                showMessage(error.message, 'danger');

                deliveredButton.disabled = false;
                deliveredButton.innerHTML =
                    '<i class="fas fa-check"></i> Mark Delivered';
            }
        }
    });

    // Submit shipment details.
    shippedForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        shippedButton.disabled = true;
        shippedButton.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Saving...';

        try {
            const formData = new FormData(shippedForm);

            const data = await postRequest(urls.markShipped, formData);

            $('#markShippedModal').modal('hide');

            shippedForm.reset();

            showMessage(data.message || 'Order marked as shipped.', 'success');

            loadOrders();

        } catch (error) {
            showMessage(error.message, 'danger');

        } finally {
            shippedButton.disabled = false;
            shippedButton.innerHTML =
                '<i class="fas fa-truck"></i> Confirm Shipment';
        }
    });

    // Initial page load.
    updateActiveTab();
    loadOrders();

})();
</script>