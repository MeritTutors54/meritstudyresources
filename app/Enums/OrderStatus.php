<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case PROCESSING = 1;
    case SHIPPED = 2;
    case DELIVERED = 4;
    case COMPLETED = 5;
    case CANCELLED = -1;

}
