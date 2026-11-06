
<?php
$orderStatus = $order['seller_status'] ?? 'new';
?>

<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4>Order Details</h4>
            <small class="text-muted">
                <?= esc($order['order_number']) ?>
            </small>
        </div>

        <a href="<?= site_url('seller/orders') ?>"
           class="btn btn-outline-secondary btn-sm">
            Back to Orders
        </a>
    </div>

    <div class="row">

        <!-- ORDER ITEMS -->
        <div class="col-lg-8">

            <div class="card mb-3">
                <div class="card-header">
                    <strong>Your Ordered Products</strong>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <?= esc($item['product_name']) ?>
                                            </strong>
                                            <br>
                                            <small>
                                                Product ID:
                                                <?= (int) $item['product_id'] ?>
                                            </small>
                                        </td>

                                        <td>
                                            ₹<?= number_format(
                                                (float) $item['unit_price'],
                                                2
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= (int) $item['quantity'] ?>
                                        </td>

                                        <td>
                                            ₹<?= number_format(
                                                (float) $item['line_total'],
                                                2
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">
                                        Your Product Total
                                    </th>
                                    <th>
                                        ₹<?= number_format(
                                            (float) $order['seller_subtotal'],
                                            2
                                        ) ?>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>

            <!-- CUSTOMER ADDRESS -->
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Delivery Address</strong>
                </div>

                <div class="card-body">
                    <strong>
                        <?= esc($order['recipient_name'] ?? $order['customer_name'] ?? '') ?>
                    </strong>

                    <br>
                    <?= esc($order['delivery_mobile'] ?? $order['customer_mobile'] ?? '') ?>

                    <br>
                    <?= esc($order['address_line1'] ?? '') ?>

                    <?= esc($order['address_line2'] ?? '') ?>

                    <br>
                    <?= esc($order['landmark'] ?? '') ?>

                    <br>
                    <?= esc($order['city'] ?? '') ?>,
                    <?= esc($order['state'] ?? '') ?>

                    <br>
                    PIN: <?= esc($order['pincode'] ?? '') ?>
                </div>
            </div>

        </div>

        <!-- ORDER MANAGEMENT -->
        <div class="col-lg-4">

            <div class="card mb-3">
                <div class="card-header">
                    <strong>Manage Your Order</strong>
                </div>

                <div class="card-body">

                    <form id="sellerOrderForm">

                        <?= csrf_field() ?>

                        <input type="hidden"
                               name="order_id"
                               value="<?= (int) $order['id'] ?>">

                        <div class="form-group">
                            <label>Seller Order Status</label>

                            <select name="seller_status"
                                    class="form-control"
                                    required>
                                <?php foreach ([
                                    'new' => 'New',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ] as $value => $label): ?>

                                    <option value="<?= esc($value) ?>"
                                        <?= $orderStatus === $value ? 'selected' : '' ?>>
                                        <?= esc($label) ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Courier Name</label>

                            <input type="text"
                                   name="courier_name"
                                   class="form-control"
                                   value="<?= esc($order['courier_name'] ?? '') ?>"
                                   placeholder="Courier company">
                        </div>

                        <div class="form-group">
                            <label>Tracking Number</label>

                            <input type="text"
                                   name="tracking_number"
                                   class="form-control"
                                   value="<?= esc($order['tracking_number'] ?? '') ?>"
                                   placeholder="Tracking ID">
                        </div>

                        <div class="form-group">
                            <label>Tracking URL</label>

                            <input type="url"
                                   name="tracking_url"
                                   class="form-control"
                                   value="<?= esc($order['tracking_url'] ?? '') ?>"
                                   placeholder="https://...">
                        </div>

                        <div class="form-group">
                            <label>Seller Note</label>

                            <textarea name="seller_note"
                                      class="form-control"
                                      rows="3"><?= esc($order['seller_note'] ?? '') ?></textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Update Order
                        </button>

                    </form>

                    <div id="orderUpdateMessage" class="mt-3"></div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Payment Information</strong>
                </div>

                <div class="card-body">
                    Payment:
                    <?= esc(strtoupper($order['payment_method'])) ?>

                    <br>

                    Status:
                    <?= esc(strtoupper($order['payment_status'])) ?>

                    <hr>

                    <strong>Your Product Amount</strong>
                    <h4>
                        ₹<?= number_format(
                            (float) $order['seller_subtotal'],
                            2
                        ) ?>
                    </h4>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
(function () {
    'use strict';

    const form = document.getElementById('sellerOrderForm');
    const message = document.getElementById('orderUpdateMessage');

    const updateUrl = <?= json_encode(
        site_url('seller/orders/update-status')
    ) ?>;

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        message.innerHTML = '';

        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.textContent = 'Updating...';

        try {
            const response = await fetch(updateUrl, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                throw new Error(
                    data.message || 'Unable to update order.'
                );
            }

            message.innerHTML = `
                <div class="alert alert-success">
                    ${data.message}
                </div>
            `;

        } catch (error) {
            message.innerHTML = `
                <div class="alert alert-danger">
                    ${error.message}
                </div>
            `;
        } finally {
            button.disabled = false;
            button.textContent = 'Update Order';
        }
    });
})();
</script>
