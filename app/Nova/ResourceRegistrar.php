<?php

declare(strict_types=1);

namespace App\Nova;

use App\Nova\Resources\EatingOut\Counties;
use App\Nova\Resources\EatingOut\Countries;
use App\Nova\Resources\EatingOut\Eateries;
use App\Nova\Resources\EatingOut\MyPlaces;
use App\Nova\Resources\EatingOut\NationwideBranches;
use App\Nova\Resources\EatingOut\NationwideEateries;
use App\Nova\Resources\EatingOut\PlaceRecommendations;
use App\Nova\Resources\EatingOut\PlaceReports;
use App\Nova\Resources\EatingOut\ReviewImage;
use App\Nova\Resources\EatingOut\Reviews;
use App\Nova\Resources\EatingOut\SuggestedEdits;
use App\Nova\Resources\EatingOut\Towns;
use App\Nova\Resources\Main\Blog;
use App\Nova\Resources\Main\BlogTag;
use App\Nova\Resources\Main\Collection;
use App\Nova\Resources\Main\CollectionItem;
use App\Nova\Resources\Main\CommentReply;
use App\Nova\Resources\Main\Comments;
use App\Nova\Resources\Main\Recipe;
use App\Nova\Resources\Main\RecipeAllergens;
use App\Nova\Resources\Main\RecipeNutritionalInformation;
use App\Nova\Resources\Shop\Baskets;
use App\Nova\Resources\Shop\Categories;
use App\Nova\Resources\Shop\Customer;
use App\Nova\Resources\Shop\OrderItem;
use App\Nova\Resources\Shop\Orders;
use App\Nova\Resources\Shop\Payment;
use App\Nova\Resources\Shop\ProductPrice;
use App\Nova\Resources\Shop\Products;
use App\Nova\Resources\Shop\ProductVariant;
use App\Nova\Resources\Shop\ShippingAddress;
use App\Nova\Resources\Shop\ShippingMethod;
use Laravel\Nova\Nova;

class ResourceRegistrar
{
    public static function handle(): void
    {
        Nova::resources([
            // Main
            Blog::class,
            BlogTag::class,
            Collection::class,
            CollectionItem::class,
            Recipe::class,
            RecipeAllergens::class,
            RecipeNutritionalInformation::class,
            Comments::class,
            CommentReply::class,

            // Eating Out
            Eateries::class,
            NationwideEateries::class,
            NationwideBranches::class,
            Countries::class,
            Counties::class,
            Towns::class,
            Reviews::class,
            ReviewImage::class,
            MyPlaces::class,
            PlaceRecommendations::class,
            PlaceReports::class,
            SuggestedEdits::class,

            // Shop Sales
            Baskets::class,
            Orders::class,
            Payment::class,
            OrderItem::class,

            // Shop Inventory
            Categories::class,
            Products::class,
            ShippingMethod::class,
            ProductPrice::class,
            ProductVariant::class,

            // Shop Customers
            Customer::class,
            ShippingAddress::class,
        ]);
    }
}
