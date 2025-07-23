<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
    | ------------------------------------------- Web Routes
*/

require __DIR__ . '/auth.php';


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::get('/', [FrontendController::class, 'index'])->name('home');


        Route::get('/visitors', [FrontendController::class, 'visitorForm'])->name('visitors');
        Route::post('/visitor-form', [FrontendController::class, 'visitorForm2'])->name('visitor-form');

        Route::post('campaigns/email/', [FrontendController::class, 'visitorForm'])->name('frontend.campaigns.email');
        Route::post('/campaigns/coupon/success', [FrontendController::class, 'visitorForm'])->name('frontend.campaigns.email');



        // routes/web.php

        Route::post('/campaign-form/{slug}/email-verify', [FrontendController::class, 'emailVerify'])
            ->name('campaign.email.verify');



        Route::get('/campaign-form/{slug}/otp-verify', [FrontendController::class, 'showOtpVerifyForm'])
            ->name('campaign.email.otp.verify');

        Route::post('/campaign-form/{slug}/otp-verify', [FrontendController::class, 'verifyOtp'])
            ->name('campaign.email.otp.verify.post');


        Route::get('/campaign-form/{slug}/success', [FrontendController::class, 'success'])->name('campaign.success');

        // Loyalty Campaign Landing Page
        Route::get('/loyalty-campaign/{id}', [FrontendController::class, 'loyaltyCampaignLanding'])->name('loyalty.campaign.landing');

        // Route::get('/about-us', [FrontendController::class, 'about_us'])->name('about_us');
        // Route::get('/contact-us', [FrontendController::class, 'contact_us'])->name('contact_us');
        // Route::post('/get-prices/{chalet}', [FrontendController::class, 'getPrices']);
        // عرض صفحة نجاح الطلب

    }
);
