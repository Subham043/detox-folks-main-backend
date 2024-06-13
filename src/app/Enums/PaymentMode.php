<?php

namespace App\Enums;

enum PaymentMode:string {
    case COD = 'Cash On Delivery';
    case PHONEPE = 'Online - Phonepe';
    case RAZORPAY = 'Online - Razorpay';
}