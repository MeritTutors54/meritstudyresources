<?php

namespace App\Enums;

enum UserType: int
{
    case NONE = 0;
    case STUDENT = 1;
    case SCHOOL = 2;
    case TEACHER = 3;
}
