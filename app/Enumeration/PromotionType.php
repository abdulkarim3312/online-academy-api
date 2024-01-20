<?php
namespace App\Enumeration;

class PromotionType {
    public static $PERCENTAGE = 0;
    public static $FIXED = 1;

    public static $TEXT = [
        '0'=> 'Percentage discount by order amount',
        '1'=> 'Fixed price discount by order amount'
    ];
}