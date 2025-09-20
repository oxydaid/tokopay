<?php

return [
    'merchant_id' => env('TOKOPAY_MERCHANT_ID', ''),
    'secret_key'  => env('TOKOPAY_SECRET_KEY', ''),
    'base_url'    => env('TOKOPAY_BASE_URL', 'https://api.tokopay.id'),
];
