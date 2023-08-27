<?php

namespace App\Enums;

enum OrderEnumStatus:string {
    case PROCESSING = 'PROCESSING';
    case CONFIRMED = 'CONFIRMED';
    case OFD = 'OUT FOR DELIVERY';
    case DELIVERED = 'DELIVERED';
    case CANCELLED = 'CANCELLED';
}
