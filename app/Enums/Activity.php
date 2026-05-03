<?php

namespace App\Enums;

 enum Activity: int
 {
     case CREATED = 1;
     case DELETED = 2;
     case UPDATE = 3;
 }
