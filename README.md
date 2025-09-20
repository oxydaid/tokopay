# Laravel Tokopay
[![Latest Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://packagist.org/packages/oxydaid/tokopay)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

Integrasi tidak resmi (unofficial) Payment Gateway [Tokopay](https://tokopay.id/) untuk Laravel.  
Menyediakan service sederhana untuk membuat transaksi, mengecek status order, generate signature, validasi webhook, dan tersedia Facade agar lebih mudah digunakan.  

## ✨ Fitur
- 🔑 Generate signature otomatis  
- 🛡️ Validasi signature untuk webhook Tokopay  
- 💳 Create transaction (POST `/v1/order/`)  
- 🔍 Check order status (GET `/v1/order`)  
- ⚡ Ringan, tanpa dependensi tambahan  
- 🛠️ Mendukung Laravel Facade (`Tokopay::`)  

## 📦 Instalasi

Anda dapat menginstal paket ini melalui **Composer**:

```bash
composer require oxydaid/tokopay
````

## ⚙️ Konfigurasi

Publikasikan file konfigurasi:

```bash
php artisan vendor:publish --tag=config --provider="Oxydaid\\Tokopay\\TokopayServiceProvider"
```

Atur kredensial Tokopay Anda di file `.env`:

```env
TOKOPAY_MERCHANT_ID=your_merchant_id
TOKOPAY_SECRET_KEY=your_secret_key
TOKOPAY_BASE_URL=https://api.tokopay.id
```

## 🚀 Penggunaan

### 1. Membuat Transaksi

```php
use Tokopay;

$refId = 'INV12345';
$signature = Tokopay::generateSignature($refId);

$data = [
    'merchant_id'    => config('tokopay.merchant_id'),
    'kode_channel'   => 'QRIS',
    'reff_id'        => $refId,
    'amount'         => 160000,
    'customer_name'  => "Joko Susilo",
    'customer_email' => "joko.susilo98@gmail.com",
    'customer_phone' => "082277665544",
    'redirect_url'   => route('payment.success'),
    'expired_ts'     => 0,
    'signature'      => $signature,
];

$response = Tokopay::createTransaction($data);
```

### 2. Cek Status Order

```php
$response = Tokopay::checkOrderStatus(
    config('tokopay.merchant_id'),
    config('tokopay.secret_key'),
    'INV12345',
    160000,
    'QRIS'
);
```

### 3. Webhook Signature Validation

```php
use Illuminate\Http\Request;
use Tokopay;

public function handleWebhook(Request $request)
{
    if (! Tokopay::validateSignature($request->reff_id, $request->signature)) {
        return response()->json(['status' => false, 'message' => 'Invalid signature'], 400);
    }

    // Signature valid → update status transaksi sesuai $request->input('status')

    return response()->json(['status' => true]);
}
```

Webhook harus merespons JSON berikut agar dianggap sukses:

```json
{ "status": true }
```
