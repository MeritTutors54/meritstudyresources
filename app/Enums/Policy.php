<?php

namespace App\Enums;

enum Policy: string
{
    case PRIVACY = 'Privacy Policy';
    case RETURN = 'Return Policy';
    case REFUND = 'Refund Policy';
    case TERMS = 'Terms & Conditions';
}
