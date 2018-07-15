<?php

return [
    'order_status' => [
        'checking_id' => 1,
        'checking_name' => 'Đang xác nhận',
        'accepted_id' => 2,
        'accepted_name' => 'Đã duyệt',
        'cancelled_id' => 99,
        'cancelled_name' => 'Huỷ đơn hàng',
        'returned_id' => 10,
        'pickup_item_failed_id' => 4,
        'processing_status' => 5,
        'delivered_id' => 8,
        'rejected_status_id' => [9, 10, 99],
        'order_success' => [8, 10]
    ],
    'transaction_status' => [
        'processing_id' => 1,
        'processing_name' => 'Đang xác nhận',
        'confirmed_status_id' => 2,
        'confirmed_status_name' => 'Đã xác nhận',
        'rejected_status_id' => 99,
        'rejected_status_name' => 'Đã từ chối',
    ],
    'transaction_category' => [
        'recharge_id' => 1,
        'recharge_name' => 'Nạp tiền',
        'withdrawal_id' => 2,
        'withdrawal_name' => 'Rút tiền',
        'deposit_id' => 3,
        'deposit_name' => 'Tạm ứng',
        'refund_id' => 4,
        'refund_name' => 'Hoàn ứng',
        'charge_id' => 6,
        'charge_name' => 'Thu phí'
    ],
    'fee' => [
        'withdrawal_fee_fix' => 1000,
        'withdrawal_fee_percent' => 3,// 3%
        'maximum_fee' => 10000
    ],
    'product_review_status' => [
        0 => 'Đang duyệt',
        1 => 'Đang bán',
        2 => 'Đã tạm khoá'
    ]
];