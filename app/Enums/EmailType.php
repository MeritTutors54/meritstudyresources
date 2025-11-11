<?php

namespace App\Enums;

enum EmailType: int
{
    case NEW_SUBSCRIPTION = 1;
    case PAUSE_SUBSCRIBER = 2;
    case CANCEL_SUBSCRIBER = 3;
    case RESUME_SUBSCRIBER = 4;
    case RENEW_SUBSCRIBER = 5;

}
