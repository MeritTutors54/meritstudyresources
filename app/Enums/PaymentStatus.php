<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case INCOMPLETE = 0;
    case CONFIRMED = 1;

    case CANCELLED = -1;

}
