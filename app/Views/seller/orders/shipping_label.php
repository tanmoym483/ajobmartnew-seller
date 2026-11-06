
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajobmart Courier Label</title>

    <style>
        
@page {
    size: A4 portrait;
    margin: 8mm;
}

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    font-family: DejaVu Sans, sans-serif;
    font-size: 8px;
    color: #202020;
}

body {
    text-align: center;
}

/* COMPLETE LABEL CENTERED AT TOP */
.label {
    width: 125mm !important;
    max-width: 125mm;
    margin: 0 auto !important;
    border: 1.5px solid #222;
    padding: 8px;
    text-align: left;
    page-break-inside: avoid;
}





.content {
    padding: 8px;
}

.block {
    margin-bottom: 7px;
    page-break-inside: avoid;
}

.block-heading {
    font-size: 8px;
    font-weight: bold;
    letter-spacing: .7px;
    color: #555;
    padding-bottom: 4px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 5px;
}

.ship-to {
    padding: 8px;
    border: 1.5px solid #222;
}

.recipient {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 3px;
}

.phone {
    font-size: 9px;
    font-weight: bold;
    margin-bottom: 3px;
}

.address {
    line-height: 1.5;
    font-size: 8px;
}

.pin-area {
    margin-top: 6px;
    padding: 6px;
    background: #eee;
}

.pin-label {
    font-size: 7px;
    font-weight: bold;
    letter-spacing: 1px;
}

.pin {
    font-size: 21px;
    font-weight: bold;
    letter-spacing: 2px;
    margin-top: 2px;
}

.pickup {
    padding: 6px 8px;
    background: #f1f1f1;
    border-left: 3px solid #555;
}

.pickup-name {
    font-size: 10px;
    font-weight: bold;
    margin-bottom: 3px;
}

.pickup-address {
    font-size: 7px;
    line-height: 1.5;
}

.payment {
    border: 1.5px solid #222;
    padding: 7px;
    margin-bottom: 7px;
    text-align: center;
    page-break-inside: avoid;
}

.payment-label {
    font-size: 8px;
    font-weight: bold;
    letter-spacing: .7px;
}

.cod-amount {
    font-size: 19px;
    font-weight: bold;
    margin-top: 3px;
}

.prepaid {
    font-size: 14px;
    font-weight: bold;
}

.payment-note {
    font-size: 7px;
    color: #555;
    margin-top: 2px;
}

.shipment-grid {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 7px;
}

.shipment-grid td {
    border: 1px solid #ccc;
    padding: 5px;
}

.small-label {
    font-size: 7px;
    color: #666;
}

.value {
    font-size: 9px;
    font-weight: bold;
    margin-top: 2px;
}

.items {
    width: 100%;
    border-collapse: collapse;
}

.items th {
    background: #222;
    color: #fff;
    padding: 5px;
    font-size: 7px;
    text-align: left;
}

.items td {
    border-bottom: 1px solid #ccc;
    padding: 5px;
    font-size: 7px;
}

.center {
    text-align: center !important;
}

.total {
    text-align: right;
    font-weight: bold;
    padding-top: 5px;
    font-size: 8px;
}

.footer {
    border-top: 1px dashed #888;
    margin-top: 7px;
    padding-top: 5px;
    text-align: center;
    font-size: 7px;
    line-height: 1.4;
    color: #555;
}

.footer strong {
    color: #222;
}



/* MAIN HEADER - BRAND LEFT, PAYMENT RIGHT */
.top-header {
    background: #202020;
    color: #fff;
    padding: 10px 12px;
    width: 95%;
    display: block;
    overflow: hidden;
}

/* LEFT SIDE */
.header-left {
    float: left;
    width: 52%;
    text-align: left;
    padding-top: 3px;
}

.brand {
    font-size: 21px;
    font-weight: bold;
    letter-spacing: 1px;
    color: #fff;
}

.tagline {
    font-size: 7px;
    letter-spacing: 1px;
    margin-top: 2px;
    color: #ddd;
}

/* RIGHT SIDE */
.header-right {
    float: right;
    width: 40%;
    text-align: right;
    font-size: 7px;
    line-height: 1.5;
    color: #fff;
}

.header-right strong {
    font-size: 9px;
}

/* PAYMENT STATUS INSIDE HEADER */
.top-payment {
    display: inline-block;
    min-width: 115px;
    padding: 5px 9px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #fff;
    margin-bottom: 4px;
}

.top-payment.cod {
    background: #fff0e8;
    color: #a32600;
    border-color: #ffb69b;
}

.top-payment.prepaid {
    background: #e8f5e9;
    color: #176b2c;
    border-color: #a5d6a7;
}

.top-payment .payment-status {
    font-size: 10px;
    font-weight: bold;
    letter-spacing: .5px;
}

.top-payment .payment-amount {
    font-size: 16px;
    font-weight: bold;
}

.top-payment .payment-note {
    font-size: 6px;
    margin-top: 2px;
}


/* FOLD LINE */
.fold-line {
    position: relative;
    border-top: 1.5px dashed #555;
    margin: 12px 0 10px;
    height: 1px;
    text-align: center;
}

.fold-line span {
    position: relative;
    top: -7px;
    display: inline-block;
    background: #fff;
    padding: 0 10px;
    color: #555;
    font-size: 7px;
    font-weight: bold;
    letter-spacing: 1px;
}



    </style>
</head>

<body>

<?php
$labelSettings = $label_settings ?? [];

$companyName = $labelSettings['company_name'] ?? 'Ajobmart';

$showOrderNumber = (int) ($labelSettings['show_order_number'] ?? 1);
$showLabelNumber = (int) ($labelSettings['show_label_number'] ?? 1);
$showSellerDetails = (int) ($labelSettings['show_seller_details'] ?? 1);
$showProductDetails = (int) ($labelSettings['show_product_details'] ?? 1);
$showPaymentDetails = (int) ($labelSettings['show_payment_details'] ?? 1);
$showShipmentDetails = (int) ($labelSettings['show_shipment_details'] ?? 1);

$footerText = $labelSettings['footer_text'] ?? '';

$method = strtolower(trim($payment_method ?? ''));

$isCod = in_array($method, [
    'cod',
    'cash_on_delivery',
    'cash on delivery'
], true);

$codAmount = (float) ($cod_amount ?? 0);
$pickup = $pickup_address ?? [];
?>

<div class="label">

    <!-- DARK HEADER -->

    
    <!-- DARK HEADER -->

    <!-- HEADER WITH PAYMENT STATUS -->

<div class="top-header">

    <!-- LEFT: BRAND + ORDER DETAILS -->

    <div class="header-left">

        <div class="brand">
            <?= esc($companyName) ?>
        </div>

        <div class="tagline">
            ONLINE MARKETPLACE
        </div>

        <div style="font-size:7px; margin-top:6px; line-height:1.6;">

            <?php if ($showLabelNumber): ?>
                LABEL ID:
                <strong><?= esc($label_number) ?></strong><br>
            <?php endif; ?>

            <?php if ($showOrderNumber): ?>
                ORDER ID:
                <strong><?= esc($order['order_number'] ?? '') ?></strong>
            <?php endif; ?>

        </div>

    </div>


    <!-- RIGHT: PAYMENT STATUS -->

    <div class="header-right">

        <?php if ($showPaymentDetails): ?>

            <div class="top-payment <?= $isCod ? 'cod' : 'prepaid' ?>">

                <?php if ($isCod): ?>

                    <div class="payment-status">
                        CASH ON DELIVERY
                    </div>

                    <div class="payment-amount">
                        ₹<?= number_format($codAmount, 2) ?>
                    </div>

                    <div class="payment-note">
                        AMOUNT TO COLLECT
                    </div>

                <?php else: ?>

                    <div class="payment-status">
                        PREPAID
                    </div>

                    <div class="payment-note">
                        PAYMENT ALREADY RECEIVED
                    </div>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

    <div style="clear:both;"></div>

</div>


    <div class="content">
        

        <!-- SHIP TO -->

        <div class="block ship-to">

            <div class="block-heading">
                01 &nbsp; DELIVER TO
            </div>

            <div class="recipient">
                <?= esc(
                    $address['recipient_name']
                    ?? $customer['name']
                    ?? 'Customer'
                ) ?>
            </div>

            <div class="phone">
                +91 <?= esc(
                    $address['mobile']
                    ?? $customer['mobile']
                    ?? ''
                ) ?>
            </div>

            <div class="address">

                <?= esc($address['address_line1'] ?? '') ?>

                <?php if (!empty($address['address_line2'])): ?>
                    , <?= esc($address['address_line2']) ?>
                <?php endif; ?>

                <?php if (!empty($address['landmark'])): ?>
                    <br>Landmark: <?= esc($address['landmark']) ?>
                <?php endif; ?>

                <br>

                <?= esc($address['city'] ?? '') ?>,
                <?= esc($address['state'] ?? '') ?>

            </div>

            <div class="pin-area">
                <div class="pin-label">DESTINATION PIN CODE</div>
                <div class="pin">
                    <?= esc($address['pincode'] ?? '') ?>
                </div>
            </div>

        </div>


        <!-- PICKUP FROM -->

        <?php if ($showSellerDetails): ?>

            <div class="block pickup">

                <div class="block-heading">
                    02 &nbsp; PICKUP FROM
                </div>

                <div class="pickup-name">
                    <?= esc($pickup['name'] ?? 'Seller') ?>
                </div>

                <div class="pickup-address">

                    Mobile: <?= esc($pickup['mobile'] ?? '') ?>

                    <br>

                    <?= esc($pickup['address_line1'] ?? '') ?>

                    <?php if (!empty($pickup['address_line2'])): ?>
                        , <?= esc($pickup['address_line2']) ?>
                    <?php endif; ?>

                    <?php if (!empty($pickup['landmark'])): ?>
                        <br>Landmark: <?= esc($pickup['landmark']) ?>
                    <?php endif; ?>

                    <br>

                    <?= esc($pickup['city'] ?? '') ?>,
                    <?= esc($pickup['state'] ?? '') ?>

                    - <?= esc($pickup['pincode'] ?? '') ?>

                </div>

            </div>

        <?php endif; ?>

        <!-- FOLD LINE -->

        <div class="fold-line">
            <span>FOLD HERE</span>
        </div>



        <!-- SHIPMENT INFORMATION -->

        <?php if ($showShipmentDetails): ?>

            <table class="shipment-grid">
                <tr>
                    <td width="50%">
                        <div class="small-label">ORDER DATE</div>
                        <div class="value">
                            <?= esc($order['created_at'] ?? '') ?>
                        </div>
                    </td>

                    <td width="50%">
                        <div class="small-label">TOTAL QUANTITY</div>
                        <div class="value">
                            <?= (int) $total_quantity ?> PCS
                        </div>
                    </td>
                </tr>
            </table>

        <?php endif; ?>


        <!-- PRODUCT DETAILS -->

        <?php if ($showProductDetails): ?>

            <div class="block">

                <div class="block-heading">
                    03 &nbsp; PACKAGE CONTENTS
                </div>

                <table class="items">

                    <thead>
                        <tr>
                            <th width="10%" class="center">SL</th>
                            <th width="70%">PRODUCT</th>
                            <th width="20%" class="center">QTY</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (($items ?? []) as $index => $item): ?>

                            <tr>
                                <td class="center">
                                    <?= $index + 1 ?>
                                </td>

                                <td>
                                    <?= esc($item['product_name'] ?? '') ?>
                                </td>

                                <td class="center">
                                    <?= (int) ($item['quantity'] ?? 0) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

                <div class="total">
                    TOTAL: <?= (int) $total_quantity ?> PCS
                </div>

            </div>

        <?php endif; ?>


        <!-- FOOTER -->

        <div class="footer">

            <strong><?= esc($companyName) ?></strong><br>

            <?= esc(
                $footerText !== ''
                    ? $footerText
                    : 'Please attach this label securely to the package.'
            ) ?>

            <br>

            Generated: <?= esc($generated_at) ?>

        </div>

    </div>

</div>

</body>
</html>
