<?php

if (!function_exists('getOrderCount')) {
    function getOrderCount()
    {
        return $count = (new \App\Models\Orders())->where('status', 'pending')->countAllResults();
    }
}

if (!function_exists('getKycCount')) {
    function getKycCount()
    {
        return $count = (new \App\Models\Kyc())->where('status', 'pending')->countAllResults();
    }
}

if (!function_exists('getPayoutCount')) {
    function getPayoutCount()
    {
        return $count = (new \App\Models\Payouts())->where('status', 'pending')->countAllResults();
    }
}