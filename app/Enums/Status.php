<?php

namespace App\Enums;

 enum Status: int
 {
     case INACTIVE = 0;
     case ACTIVE = 1;
     case DELETED = -1;

     public function label(): string
     {
         return match ($this) {
             self::ACTIVE => 'Active',
             self::INACTIVE => 'Inactive',
             self::DELETED => 'Deleted',
         };
     }

     public static function options(): array
     {
         $options = [];
         foreach (self::cases() as $case) {
             $options[$case->value] = $case->label();
         }
         return $options;
     }

     public function color(): string
     {
         return match($this) {
             self::INACTIVE => 'secondary',
             self::ACTIVE => 'success',
             self::DELETED => 'danger',
         };
     }
 }
