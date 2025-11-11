<?php

namespace App\Enums;

use App\Models\Seo;

enum SEOPage: string
{
    case HOME = 'Home';
    case ABOUT_US = 'About Us';
    case CONTACT = 'Contact';
    case PRICING = 'Pricing';
    case PRODUCTS = 'Products';
    case PAST_PAPER = 'Past Paper';
    case RESOURCES = 'Resources';
    case BLOGS = 'Blogs';
    case TERMS_CONDITION = 'Terms & Conditions';
    case FAQ = 'FAQ';
    case RETURN_POLICY = 'Return Policy';
    case REFUND_POLICY = 'Refund Policy';
    case PRIVACY_POLICY = 'Privacy Policy';

    public static function filerPages(): array
    {
        // Get all existing SEO 'page' values from the database
        $existingPages = Seo::query()->pluck('page_title')->toArray();

        // Return enum cases that are not in the database
        return array_filter(self::cases(), function (self $case) use ($existingPages) {
            return !in_array($case->value, $existingPages);
        });
    }
}
