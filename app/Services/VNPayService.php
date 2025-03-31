<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class VNPayService
{
    public function createPayment(
        string $orderId,
        float $amount,
        string $orderInfo,
        string $email = null,
        string $phone = null
    ): string {
        $vnp_Url = Config::get('services.vnpay.url');
        $vnp_Returnurl = Config::get('services.vnpay.return_url');
        $vnp_TmnCode = Config::get('services.vnpay.tmn_code');
        $vnp_HashSecret = Config::get('services.vnpay.hash_secret');
        
        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = $orderInfo;
        $vnp_OrderType = 'other';
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();
        
        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
        ];
        
        if ($email) {
            $inputData['vnp_Bill_Email'] = $email;
        }
        
        if ($phone) {
            $inputData['vnp_Bill_Mobile'] = $phone;
        }
        
        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        
        $vnp_Url .= '?' . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        
        return $vnp_Url;
    }
    
    public function validateReturn(array $inputData): bool
    {
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        $vnp_HashSecret = Config::get('services.vnpay.hash_secret');
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = '';
        
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        
        $hashData = rtrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        return $secureHash === $vnp_SecureHash;
    }
}