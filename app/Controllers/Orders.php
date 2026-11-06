<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ShippingLabelBookingModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Orders extends BaseController
{
    protected $layout = 'layouts/dashboard/default_dashboard';

    private function sellerId(): int
    {
        return (int) ($this->session->get('seller_id') ?? 0);
    }

    /**
     * Seller order list.
     * Only orders containing this seller's products.
     */
    public function index()
    {
        $sellerId = $this->sellerId();

        if ($sellerId <= 0) {
            return redirect()->to(site_url('seller/login'));
        }

        return $this->view('seller/orders/index', [
            'pageTitle' => 'My Orders',
        ]);
    }

    /**
     * Fetch seller-specific orders.
     */
    /**
 * Fetch seller-specific orders.
 */
public function listData()
{
    $sellerId = $this->sellerId();

    if ($sellerId <= 0) {
        return $this->response->setStatusCode(401)->setJSON([
            'status' => false,
            'message' => 'Please log in.',
        ]);
    }

    $section = strtolower(trim(
        (string) $this->request->getGet('section')
    ));

    $allowedSections = [
        'pending',
        'rd',
        'shipped',
        'delivered',
    ];

    if (!in_array($section, $allowedSections, true)) {
        $section = 'pending';
    }

    $fromDate = trim((string) $this->request->getGet('from_date'));
    $toDate = trim((string) $this->request->getGet('to_date'));

    $validDate = static function ($date) {
        $parsed = \DateTime::createFromFormat('!Y-m-d', $date);

        return $parsed && $parsed->format('Y-m-d') === $date;
    };

    if ($fromDate !== '' && !$validDate($fromDate)) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Invalid From Date.',
        ]);
    }

    if ($toDate !== '' && !$validDate($toDate)) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Invalid To Date.',
        ]);
    }

    if (
        $fromDate !== '' &&
        $toDate !== '' &&
        $fromDate > $toDate
    ) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'From Date cannot be after To Date.',
        ]);
    }

    /*
     * Base query: one row per seller/order.
     */
    $baseSql = "
        SELECT
            o.id,
            o.order_number,
            o.user_id,
            o.payment_method,
            o.payment_status,
            o.order_status AS main_order_status,
            o.created_at,
            o.total_amount,
            o.cashback_deduct,
            o.platform_fee,

            u.name AS customer_name,
            u.mobile AS customer_mobile,

            f.seller_status,
            f.courier_name,
            f.tracking_number,
            f.tracking_url,
            f.seller_note,
            f.shipped_at,
            f.delivered_at,

            COUNT(DISTINCT oi.id) AS seller_item_count,
            SUM(oi.quantity) AS seller_total_quantity,
            SUM(oi.line_total) AS seller_subtotal,

            l.id AS label_id,
            l.label_number,
            l.generated_at AS label_generated_at,

            CASE
                WHEN LOWER(o.payment_status) = 'paid'
                    THEN 1

                WHEN LOWER(o.payment_method) IN (
                    'cod',
                    'cash_on_delivery',
                    'cash on delivery'
                )
                AND LOWER(o.payment_status) = 'pending'
                    THEN 1

                ELSE 0
            END AS label_eligible

        FROM ajobmart_orders o

        INNER JOIN ajobmart_order_items oi
            ON oi.order_id = o.id

        INNER JOIN ajobmart_products p
            ON p.id = oi.product_id
            AND p.seller_id = ?

        LEFT JOIN ajobmart_users u
            ON u.id = o.user_id

        LEFT JOIN ajobmart_seller_order_fulfillments f
            ON f.order_id = o.id
            AND f.seller_id = ?

        LEFT JOIN ajobmart_seller_order_labels l
            ON l.order_id = o.id
            AND l.seller_id = ?

        WHERE o.payment_status IN ('paid', 'pending')
          AND COALESCE(f.seller_status, 'new') != 'cancelled'

        GROUP BY
            o.id,
            o.order_number,
            o.user_id,
            o.payment_method,
            o.payment_status,
            o.order_status,
            o.created_at,
            u.name,
            u.mobile,
            f.seller_status,
            f.courier_name,
            f.tracking_number,
            f.tracking_url,
            f.seller_note,
            f.shipped_at,
            f.delivered_at,
            l.id,
            l.label_number,
            l.generated_at
    ";

    $params = [$sellerId, $sellerId, $sellerId];

    $orders = $this->db->query($baseSql, $params)
        ->getResultArray();

    /*
     * Classify orders into dashboard sections.
     */
    $counts = [
        'pending' => 0,
        'rd' => 0,
        'shipped' => 0,
        'delivered' => 0,
    ];

    $classified = [];

    foreach ($orders as $order) {
        $sellerStatus = $order['seller_status'] ?: 'new';
        $hasLabel = !empty($order['label_id']);

        if ($sellerStatus === 'delivered') {
            $orderSection = 'delivered';
        } elseif ($sellerStatus === 'shipped') {
            $orderSection = 'shipped';
        } elseif ($hasLabel) {
            $orderSection = 'rd';
        } else {
            $orderSection = 'pending';
        }

        /*
         * Dashboard date filter uses order creation date.
         */
        $orderDate = substr($order['created_at'], 0, 10);

        if ($fromDate !== '' && $orderDate < $fromDate) {
            continue;
        }

        if ($toDate !== '' && $orderDate > $toDate) {
            continue;
        }

        $counts[$orderSection]++;

        $order['dashboard_section'] = $orderSection;
        $order['label_id'] = $order['label_id']
            ? (int) $order['label_id']
            : null;

        $order['label_eligible'] =
            (int) $order['label_eligible'];

        $order['seller_item_count'] =
            (int) $order['seller_item_count'];

        $order['seller_total_quantity'] =
            (int) $order['seller_total_quantity'];

        $order['seller_subtotal'] =
            (float) $order['seller_subtotal'];
        
        $order['seller_totalAmount'] =
            (float) $order['total_amount'];

        if ($orderSection === $section) {
            $classified[] = $order;
        }
    }

    return $this->response->setJSON([
        'status' => true,
        'selected_section' => $section,
        'counts' => $counts,
        'orders' => $classified,
        'count' => count($classified),
    ]);
}

    /**
     * Seller-specific order details.
     */
    public function details($orderId = 0)
    {
        $sellerId = $this->sellerId();
        $orderId = (int) $orderId;

        if ($sellerId <= 0) {
            return redirect()->to(site_url('seller/login'));
        }

        if ($orderId <= 0) {
            return redirect()->to(site_url('seller/orders'));
        }

        // Verify that this order contains the seller's products.
        $order = $this->db->table('ajobmart_orders o')
            ->select("
                o.id,
                o.order_number,
                o.user_id,
                o.address_id,
                o.payment_method,
                o.payment_status,
                o.order_status AS main_order_status,
                o.created_at,
                u.name AS customer_name,
                u.mobile AS customer_mobile,
                a.recipient_name,
                a.mobile AS delivery_mobile,
                a.pincode,
                a.state,
                a.city,
                a.address_line1,
                a.address_line2,
                a.landmark,
                f.seller_status,
                f.courier_name,
                f.tracking_number,
                f.tracking_url,
                f.seller_note
            ")
            ->join('ajobmart_users u', 'u.id = o.user_id', 'left')
            ->join(
                'ajobmart_customer_addresses a',
                'a.id = o.address_id',
                'left'
            )
            ->join(
                'ajobmart_seller_order_fulfillments f',
                'f.order_id = o.id AND f.seller_id = ' . $sellerId,
                'left'
            )
            ->where('o.id', $orderId)
            ->whereIn('o.payment_status', ['paid', 'pending'])
            ->where(
                "EXISTS (
                    SELECT 1
                    FROM ajobmart_order_items oi
                    INNER JOIN ajobmart_products p
                        ON p.id = oi.product_id
                    WHERE oi.order_id = o.id
                    AND p.seller_id = {$sellerId}
                )",
                null,
                false
            )
            ->get()
            ->getRowArray();

        if (!$order) {
            return redirect()->to(site_url('seller/orders'))
                ->with('error', 'Order not found or access denied.');
        }

        // Only products belonging to this seller.
        $items = $this->db->table('ajobmart_order_items oi')
            ->select("
                oi.id,
                oi.product_id,
                oi.product_name,
                oi.product_image,
                oi.quantity,
                oi.unit_price,
                oi.unit_shipping_allowance,
                oi.line_total
            ")
            ->join(
                'ajobmart_products p',
                'p.id = oi.product_id'
            )
            ->where('oi.order_id', $orderId)
            ->where('p.seller_id', $sellerId)
            ->orderBy('oi.id', 'ASC')
            ->get()
            ->getResultArray();

        $order['seller_status'] =
            $order['seller_status'] ?: 'new';

        $order['seller_subtotal'] = 0;
        $order['seller_total_quantity'] = 0;

        foreach ($items as $item) {
            $order['seller_subtotal'] +=
                (float) $item['line_total'];

            $order['seller_total_quantity'] +=
                (int) $item['quantity'];
        }

        return $this->view('seller/orders/details', [
            'pageTitle' => 'Order Details',
            'order' => $order,
            'items' => $items,
        ]);
    }

    /**
     * Update seller-specific status and tracking.
     */
    public function updateStatus()
    {
        $sellerId = $this->sellerId();

        if ($sellerId <= 0) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Please log in.',
            ]);
        }

        $orderId = (int) $this->request->getPost('order_id');

        $status = trim(
            (string) $this->request->getPost('seller_status')
        );

        $courier = trim(
            (string) $this->request->getPost('courier_name')
        );

        $tracking = trim(
            (string) $this->request->getPost('tracking_number')
        );

        $trackingUrl = trim(
            (string) $this->request->getPost('tracking_url')
        );

        $note = trim(
            (string) $this->request->getPost('seller_note')
        );

        $allowedStatuses = [
            'new',
            'processing',
            'shipped',
            'delivered',
            'cancelled',
        ];

        if (
            $orderId <= 0 ||
            !in_array($status, $allowedStatuses, true)
        ) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Invalid order or status.',
            ]);
        }

        if (
            $trackingUrl !== '' &&
            !filter_var($trackingUrl, FILTER_VALIDATE_URL)
        ) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Enter a valid tracking URL.',
            ]);
        }

        // Verify order ownership before updating.
        $ownsOrder = $this->db->table('ajobmart_order_items oi')
            ->join(
                'ajobmart_products p',
                'p.id = oi.product_id'
            )
            ->where('oi.order_id', $orderId)
            ->where('p.seller_id', $sellerId)
            ->countAllResults();

        if (!$ownsOrder) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Order not found or access denied.',
            ]);
        }

        $data = [
            'seller_id' => $sellerId,
            'order_id' => $orderId,
            'seller_status' => $status,
            'courier_name' => $courier ?: null,
            'tracking_number' => $tracking ?: null,
            'tracking_url' => $trackingUrl ?: null,
            'seller_note' => $note ?: null,
        ];

        $existing = $this->db
            ->table('ajobmart_seller_order_fulfillments')
            ->where('seller_id', $sellerId)
            ->where('order_id', $orderId)
            ->get()
            ->getRowArray();

        if ($existing) {
            $this->db->table('ajobmart_seller_order_fulfillments')
                ->where('seller_id', $sellerId)
                ->where('order_id', $orderId)
                ->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->db->table('ajobmart_seller_order_fulfillments')
                ->insert($data);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Seller order status updated successfully.',
        ]);
    }

    public function markShipped()
{
    $sellerId = $this->sellerId();

    if ($sellerId <= 0) {
        return $this->response->setStatusCode(401)->setJSON([
            'status' => false,
            'message' => 'Please log in.',
        ]);
    }

    $orderId = (int) $this->request->getPost('order_id');

    $courier = trim(
        (string) $this->request->getPost('courier_name')
    );

    $tracking = trim(
        (string) $this->request->getPost('tracking_number')
    );

    $trackingUrl = trim(
        (string) $this->request->getPost('tracking_url')
    );

    if ($orderId <= 0 || $courier === '' || $tracking === '') {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Order, courier and tracking number are required.',
        ]);
    }

    if (
        $trackingUrl !== '' &&
        !filter_var($trackingUrl, FILTER_VALIDATE_URL)
    ) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Enter a valid tracking URL.',
        ]);
    }

    // Confirm seller ownership and existing label.
    $label = $this->db->table('ajobmart_seller_order_labels')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->get()
        ->getRowArray();

    if (!$label) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Generate the shipping label before dispatch.',
        ]);
    }

    $ownsOrder = $this->db->table('ajobmart_order_items oi')
        ->join(
            'ajobmart_products p',
            'p.id = oi.product_id'
        )
        ->where('oi.order_id', $orderId)
        ->where('p.seller_id', $sellerId)
        ->countAllResults();

    if (!$ownsOrder) {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => false,
            'message' => 'Order not found or access denied.',
        ]);
    }

    $fulfillment = $this->db
        ->table('ajobmart_seller_order_fulfillments')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->get()
        ->getRowArray();

    if (
        $fulfillment &&
        in_array(
            $fulfillment['seller_status'],
            ['shipped', 'delivered', 'cancelled'],
            true
        )
    ) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'This order cannot be dispatched in its current status.',
        ]);
    }

    $data = [
        'seller_id' => $sellerId,
        'order_id' => $orderId,
        'seller_status' => 'shipped',
        'courier_name' => $courier,
        'tracking_number' => $tracking,
        'tracking_url' => $trackingUrl ?: null,
        'shipped_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    if ($fulfillment) {
        $this->db->table('ajobmart_seller_order_fulfillments')
            ->where('seller_id', $sellerId)
            ->where('order_id', $orderId)
            ->update($data);
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->db->table('ajobmart_seller_order_fulfillments')
            ->insert($data);
    }

    return $this->response->setJSON([
        'status' => true,
        'message' => 'Order marked as shipped successfully.',
    ]);
}

public function markDelivered()
{
    $sellerId = $this->sellerId();

    if ($sellerId <= 0) {
        return $this->response->setStatusCode(401)->setJSON([
            'status' => false,
            'message' => 'Please log in.',
        ]);
    }

    $orderId = (int) $this->request->getPost('order_id');

    if ($orderId <= 0) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Invalid order.',
        ]);
    }

    $fulfillment = $this->db
        ->table('ajobmart_seller_order_fulfillments')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->get()
        ->getRowArray();

    if (!$fulfillment || $fulfillment['seller_status'] !== 'shipped') {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Only shipped orders can be marked as delivered.',
        ]);
    }

    $this->db->table('ajobmart_seller_order_fulfillments')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->update([
            'seller_status' => 'delivered',
            'delivered_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    return $this->response->setJSON([
        'status' => true,
        'message' => 'Order marked as delivered successfully.',
    ]);
}

/**
 * Generate one private shipping label for this seller's part of an order.
 */


public function generateLabel()
{
    $sellerId = $this->sellerId();

    // 1. Seller authentication
    if (!$sellerId) {
        return $this->response->setStatusCode(401)->setJSON([
            'status'  => false,
            'message' => 'Please login as a seller.',
        ]);
    }

    // 2. Validate order ID
    $orderId = (int) $this->request->getPost('order_id');

    if (!$orderId) {
        return $this->response->setStatusCode(400)->setJSON([
            'status'  => false,
            'message' => 'Invalid order.',
        ]);
    }

    // 3. Verify order belongs to this seller
    $order = $this->db->table('ajobmart_orders o')
        ->select('
            o.id,
            o.order_number,
            o.user_id,
            o.address_id,
            o.payment_method,
            o.payment_status,
            o.order_status,
            o.created_at,
            o.subtotal,
            o.shipping_charge,
            o.included_shipping,
            o.actual_shipping,
            o.cashback_deduct,
            o.platform_fee,
            o.total_amount
        ')
        ->join(
            'ajobmart_order_items oi',
            'oi.order_id = o.id',
            'inner'
        )
        ->join(
            'ajobmart_products p',
            'p.id = oi.product_id',
            'inner'
        )
        ->where('o.id', $orderId)
        ->where('p.seller_id', $sellerId)
        ->groupBy('o.id')
        ->get()
        ->getRowArray();

    if (!$order) {
        return $this->response->setStatusCode(404)->setJSON([
            'status'  => false,
            'message' => 'Order not found or you do not have access to it.',
        ]);
    }

    // 4. Prevent labels for cancelled orders
    if (strtolower(trim((string) $order['order_status'])) === 'cancelled') {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => 'A cancelled order cannot have a shipping label.',
        ]);
    }

    // 5. Payment eligibility
    $paymentMethod = strtolower(trim((string) $order['payment_method']));
    $paymentStatus = strtolower(trim((string) $order['payment_status']));

    $isCod = in_array($paymentMethod, [
        'cod',
        'cash_on_delivery',
        'cash on delivery',
    ], true);

    $isEligible = (
        $paymentStatus === 'paid'
        || ($isCod && $paymentStatus === 'pending')
    );

    if (!$isEligible) {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => 'Online payment must be completed before generating a shipping label.',
        ]);
    }

    // 6. Initialize booking model
    $bookingModel = new ShippingLabelBookingModel();

    // 7. Check existing seller label
    $existingLabel = $this->db->table('ajobmart_seller_order_labels')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->get()
        ->getRowArray();

    if ($existingLabel) {

        // Ensure admin booking exists
        $bookingId = $bookingModel->createFromLabel($existingLabel);

        return $this->response->setJSON([
            'status'       => true,
            'message'      => 'Shipping label has already been generated.',
            'label_id'     => $existingLabel['id'],
            'label_number' => $existingLabel['label_number'],
            'booking_id'   => $bookingId ?: null,
        ]);
    }

    // 8. Fetch only this seller's order items
    $items = $this->db->table('ajobmart_order_items oi')
        ->select('
            oi.product_id,
            oi.product_name,
            oi.product_image,
            oi.quantity,
            oi.unit_price,
            oi.line_total
        ')
        ->join(
            'ajobmart_products p',
            'p.id = oi.product_id',
            'inner'
        )
        ->where('oi.order_id', $orderId)
        ->where('p.seller_id', $sellerId)
        ->get()
        ->getResultArray();

    if (empty($items)) {
        return $this->response->setStatusCode(404)->setJSON([
            'status'  => false,
            'message' => 'No products belonging to this seller were found.',
        ]);
    }

    // 9. Calculate seller-specific item subtotal and quantity
    $totalQuantity = 0;
    $sellerSubtotal = 0;

    foreach ($items as $item) {
        $totalQuantity += (int) $item['quantity'];
        $sellerSubtotal += (float) $item['line_total'];
    }

    // 10. Fetch customer delivery address
    $address = $this->db->table('ajobmart_customer_addresses')
        ->where('id', $order['address_id'])
        ->get()
        ->getRowArray();

    if (!$address) {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => 'Customer delivery address was not found.',
        ]);
    }

    // 11. Fetch customer information
    $customer = $this->db->table('ajobmart_users')
        ->select('name, mobile')
        ->where('id', $order['user_id'])
        ->get()
        ->getRowArray();

    if (!$customer) {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => 'Customer information was not found.',
        ]);
    }

    // 12. Fetch seller's active pickup address
    $pickupAddress = $this->db->table('ajobmart_seller_addresses')
        ->where('seller_id', $sellerId)
        ->where('is_active', 1)
        ->orderBy('is_default', 'DESC')
        ->get()
        ->getRowArray();

    if (!$pickupAddress) {
        return $this->response->setStatusCode(422)->setJSON([
            'status'  => false,
            'message' => 'Please add an active pickup address before generating a shipping label.',
        ]);
    }

    // 13. Generate unique label number
    $labelNumber = 'AJL-' . date('Ymd') . '-' .
        strtoupper(bin2hex(random_bytes(4)));

    // 14. Final order amount
    // total_amount already includes platform_fee
    $orderTotalAmount = (float) $order['total_amount'];

    // COD amount = complete customer payable amount
    $sellerCodAmount = $isCod ? $orderTotalAmount : 0;

    // 15. Prepare label data
    $labelData = [
        'label_number' => $labelNumber,

        'order' => $order,
        'items' => $items,
        'address' => $address,
        'customer' => $customer,

        'pickup_address' => [
            'name'          => $pickupAddress['contact_name'] ?? '',
            'mobile'        => $pickupAddress['mobile'] ?? '',
            'address_line1' => $pickupAddress['address_line1'] ?? '',
            'address_line2' => $pickupAddress['address_line2'] ?? '',
            'landmark'      => $pickupAddress['landmark'] ?? '',
            'city'          => $pickupAddress['city'] ?? '',
            'state'         => $pickupAddress['state'] ?? '',
            'pincode'       => $pickupAddress['pincode'] ?? '',
        ],

        'total_quantity' => $totalQuantity,

        // Seller's product subtotal
        'seller_subtotal' => $sellerSubtotal,

        // Customer's complete order total
        'seller_totalAmount' => $orderTotalAmount,

        'payment_method' => $order['payment_method'],
        'payment_status' => $order['payment_status'],

        // COD = complete customer order total
        'cod_amount' => $sellerCodAmount,

        'generated_at' => date('d M Y, h:i A'),
    ];

    // 16. Render shipping label HTML
    $html = view('seller/orders/shipping_label', $labelData);

    // 17. Configure Dompdf
    $options = new \Dompdf\Options();

    $options->set('isRemoteEnabled', false);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');

    $dompdf = new \Dompdf\Dompdf($options);

    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 18. Shared storage configuration
    $storageRoot = trim(
        (string) env('AJOBMART_LABEL_STORAGE_PATH')
    );

    if ($storageRoot === '') {
        return $this->response->setStatusCode(500)->setJSON([
            'status'  => false,
            'message' => 'Shipping label storage path is not configured.',
        ]);
    }

    $storageRoot = rtrim($storageRoot, '/\\')
        . DIRECTORY_SEPARATOR;

    // Seller-specific directory
    $directory = $storageRoot
        . 'seller_' . $sellerId . DIRECTORY_SEPARATOR;

    // Create directory if required
    if (
        !is_dir($directory) &&
        !mkdir($directory, 0755, true) &&
        !is_dir($directory)
    ) {
        return $this->response->setStatusCode(500)->setJSON([
            'status'  => false,
            'message' => 'Unable to create the shipping label directory.',
        ]);
    }

    // 19. Save PDF
    $fileName = $labelNumber . '.pdf';

    $fullPath = $directory . $fileName;

    $pdfContent = $dompdf->output();

    if (file_put_contents($fullPath, $pdfContent) === false) {
        return $this->response->setStatusCode(500)->setJSON([
            'status'  => false,
            'message' => 'Unable to save the shipping label PDF.',
        ]);
    }

    // Relative path stored in database
    $relativePath = 'seller_' . $sellerId . '/' . $fileName;

    // 20. Insert seller label record
    $inserted = $this->db->table('ajobmart_seller_order_labels')
        ->insert([
            'seller_id'         => $sellerId,
            'order_id'          => $orderId,
            'label_number'      => $labelNumber,
            'pdf_path'          => $relativePath,
            'generated_by_type' => 'seller',
            'generated_by_id'   => $sellerId,
            'label_status'      => 'generated',
            'generated_at'      => date('Y-m-d H:i:s'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

    if (!$inserted) {

        // Remove PDF if database insert failed
        @unlink($fullPath);

        // Check concurrent label generation
        $existingLabel = $this->db->table('ajobmart_seller_order_labels')
            ->where('seller_id', $sellerId)
            ->where('order_id', $orderId)
            ->get()
            ->getRowArray();

        if ($existingLabel) {

            // Ensure booking exists
            $bookingId = $bookingModel->createFromLabel($existingLabel);

            return $this->response->setJSON([
                'status'       => true,
                'message'      => 'Shipping label has already been generated.',
                'label_id'     => $existingLabel['id'],
                'label_number' => $existingLabel['label_number'],
                'booking_id'   => $bookingId ?: null,
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status'  => false,
            'message' => 'Unable to save shipping label information.',
        ]);
    }

    // 21. Get newly inserted label ID
    $labelId = (int) $this->db->insertID();

    // 22. Fetch created label record
    $createdLabel = $this->db->table('ajobmart_seller_order_labels')
        ->where('id', $labelId)
        ->get()
        ->getRowArray();

    if (!$createdLabel) {
        return $this->response->setStatusCode(500)->setJSON([
            'status'  => false,
            'message' => 'Label was generated, but its record could not be retrieved.',
        ]);
    }

    // 23. Automatically create admin shipping booking
    $bookingId = $bookingModel->createFromLabel($createdLabel);

    // 24. Final response
    return $this->response->setJSON([
        'status'       => true,
        'message'      => 'Shipping label generated successfully.',
        'label_id'     => $labelId,
        'label_number' => $labelNumber,
        'booking_id'   => $bookingId ?: null,
    ]);
}



/**
 * View or print a seller's private shipping label.
 */

public function viewLabel($orderId)
{
    $sellerId = $this->sellerId();

    if (!$sellerId) {
        return $this->response
            ->setStatusCode(401)
            ->setBody('Please login as a seller.');
    }

    $orderId = (int) $orderId;

    if ($orderId <= 0) {
        return $this->response->setStatusCode(400)->setBody('Invalid order ID.');
    }

    // Verify seller ownership.
    $ownership = $this->db->table('ajobmart_order_items oi')
        ->select('oi.id')
        ->join('ajobmart_products p', 'p.id = oi.product_id')
        ->where('oi.order_id', $orderId)
        ->where('p.seller_id', $sellerId)
        ->get()
        ->getRowArray();

    if (!$ownership) {
        return $this->response->setStatusCode(404)->setBody('Label not found.');
    }

    // Fetch seller label.
    $label = $this->db->table('ajobmart_seller_order_labels')
        ->where('seller_id', $sellerId)
        ->where('order_id', $orderId)
        ->get()
        ->getRowArray();

    if (!$label) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('Shipping label not found.');
    }

    // Relative DB path: seller_5/label_number.pdf
    $relativePath = str_replace('\\', '/', trim($label['pdf_path']));

    // Prevent unsafe paths.
    if (
        $relativePath === ''
        || str_contains($relativePath, '..')
        || str_starts_with($relativePath, '/')
        || preg_match('/^[A-Za-z]:/', $relativePath)
    ) {
        return $this->response
            ->setStatusCode(403)
            ->setBody('Invalid label path.');
    }

    // Shared label storage root from .env.
    $storageRoot = rtrim(
        (string) env('AJOBMART_LABEL_STORAGE_PATH'),
        '/\\'
    );

    if ($storageRoot === '') {
        return $this->response
            ->setStatusCode(500)
            ->setBody('Label storage path is not configured.');
    }

    // Build physical PDF path.
    $fullPath = $storageRoot . DIRECTORY_SEPARATOR
        . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

    if (!is_file($fullPath)) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('PDF file not found: ' . $relativePath);
    }

    if (!is_readable($fullPath)) {
        return $this->response
            ->setStatusCode(403)
            ->setBody('PDF file is not readable.');
    }

    $pdf = file_get_contents($fullPath);

    if ($pdf === false) {
        return $this->response
            ->setStatusCode(500)
            ->setBody('Unable to read PDF file.');
    }

    // Mark printed only when print=1 is requested.
    if ($this->request->getGet('print') === '1') {
        $this->db->table('ajobmart_seller_order_labels')
            ->where('id', $label['id'])
            ->update([
                'label_status' => 'printed',
                'printed_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
    }

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader(
            'Content-Disposition',
            'inline; filename="' . basename($fullPath) . '"'
        )
        ->setHeader('Content-Length', (string) strlen($pdf))
        ->setHeader('Cache-Control', 'private, no-store')
        ->setBody($pdf);
}

}
