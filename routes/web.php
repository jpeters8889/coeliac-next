<?php

declare(strict_types=1);

use App\Http\Controllers\Comments\GetController;
use App\Http\Controllers\CookiePolicy\IndexController as CookiePolicyIndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Popup\Activity\StoreController as PopupActivityStoreController;
use App\Http\Controllers\PrivacyPolicy\IndexController as PrivacyPolicyIndexController;
use App\Http\Controllers\TermsOfUse\IndexController as TermsOfUseIndexController;
use App\Http\Controllers\WorkWithUs\IndexController as WorkWithUsIndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('blog')->group(base_path('routes/blogs/web.php'));
Route::prefix('collection')->group(base_path('routes/collections/web.php'));
Route::prefix('recipe')->group(base_path('routes/recipes/web.php'));
Route::prefix('search')->group(base_path('routes/search/web.php'));
Route::prefix('shop')->group(base_path('routes/shop/web.php'));
Route::prefix('')->group(base_path('routes/eating-out/web.php'));

Route::get('/', HomeController::class)->name('home');

Route::post('comments', GetController::class)->name('comments.create');

Route::get('cookie-policy', CookiePolicyIndexController::class)->name('cookie-policy');
Route::get('privacy-policy', PrivacyPolicyIndexController::class)->name('privacy-policy');
Route::get('terms-of-use', TermsOfUseIndexController::class)->name('terms-of-use');
Route::get('work-with-us', WorkWithUsIndexController::class)->name('work-with-us');

Route::post('popup/{popup}', PopupActivityStoreController::class)->name('popup.activity.store');
