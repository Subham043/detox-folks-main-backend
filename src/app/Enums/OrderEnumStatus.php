<?php

namespace App\Enums;

enum OrderEnumStatus:string {
    case PLACED = 'ORDER PLACED';
    case CONFIRMED = 'CONFIRMED';
    case PACKED = 'PACKED';
    case READY = 'READY FOR SHIPMENT';
    case OFD = 'OUT FOR DELIVERY';
    case DELIVERED = 'DELIVERED';
    case CANCELLED = 'CANCELLED';
}
