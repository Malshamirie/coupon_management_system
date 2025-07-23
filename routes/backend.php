<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoyaltyCardController;
use App\Http\Controllers\LoyaltyCampaignController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\LoyaltyCampaignRecipientController;
use App\Http\Controllers\LoyaltyCardRequestController;




// Backend ====================================================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::resource('dashboard', DashboardController::class);
        Route::resource('setting', SettingController::class);
        // PaymentMethod ======================================================================
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('containers', ContainerController::class);

        Route::post('/import-coupons', [CouponController::class, 'import'])->name('coupons.import');
        Route::get('usercodes', [CouponUserController::class, 'index'])->name('usercodes');
        Route::get('usercodes/export/excel', [CouponUserController::class, 'excel'])->name('usercodes.export.excel');




        // الصلاحيات
        Route::resource('permissions', PermissionController::class);



        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('verified');
            Route::resource('containers', ContainerController::class);
            Route::resource('coupons', CouponController::class);
            Route::resource('campaigns', CampaignController::class);
            Route::get('container/{id}/coupons', [ContainerController::class, 'coupons'])->name('container.coupons');

            // حملات الولاء
            Route::resource('loyalty_cards', LoyaltyCardController::class);
            Route::resource('loyalty_campaigns', LoyaltyCampaignController::class);
            Route::post('loyalty_campaigns/{loyaltyCampaign}/toggle-status', [LoyaltyCampaignController::class, 'toggleStatus'])->name('loyalty_campaigns.toggle-status');
            Route::get('loyalty_campaigns/{loyaltyCampaign}/customers', [LoyaltyCampaignController::class, 'customers'])->name('loyalty_campaigns.customers');
            Route::get('loyalty_campaigns/{loyaltyCampaign}/send', [LoyaltyCampaignController::class, 'sendCampaign'])->name('loyalty_campaigns.send');
            Route::post('loyalty_campaigns/{loyaltyCampaign}/send-customers', [LoyaltyCampaignController::class, 'sendToCustomers'])->name('loyalty_campaigns.send-customers');
            Route::post('loyalty_campaigns/export', [LoyaltyCampaignController::class, 'export'])->name('loyalty_campaigns.export');
            Route::resource('cities', CityController::class);
            Route::resource('groups', GroupController::class);
            Route::resource('branches', BranchController::class);
            Route::resource('customers', CustomerController::class);
            Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
            Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
        });
    }
);


Route::get('campaigns/{slug}', [CampaignController::class, 'form'])->name('campaign.form');
Route::get('loyalty-campaign/{id}', [LoyaltyCampaignController::class, 'landingPage'])->name('loyalty.campaign.landing');
Route::get('loyalty_campaigns/{loyaltyCampaign}/test-whatsapp', [LoyaltyCampaignController::class, 'showTestWhatsApp'])->name('loyalty_campaigns.test-whatsapp');
Route::post('loyalty_campaigns/{loyaltyCampaign}/test-whatsapp-send', [LoyaltyCampaignController::class, 'testWhatsApp'])->name('admin.loyalty_campaigns.test-whatsapp-send');
Route::get('/loyalty-campaign-recipients', [LoyaltyCampaignRecipientController::class, 'index'])->name('admin.loyalty_campaign_recipients.index');
Route::post('/loyalty-campaign-recipients/retry', [LoyaltyCampaignRecipientController::class, 'retryFailed'])->name('admin.loyalty_campaign_recipients.retry');
Route::get('/loyalty-campaign-recipients/statistics', [LoyaltyCampaignRecipientController::class, 'statistics'])->name('admin.loyalty_campaign_recipients.statistics');

// Loyalty Card Requests
Route::resource('loyalty-card-requests', LoyaltyCardRequestController::class)->names('admin.loyalty_card_requests');
Route::post('/loyalty-card-requests/{loyaltyCardRequest}/approve', [LoyaltyCardRequestController::class, 'approve'])->name('admin.loyalty_card_requests.approve');
Route::post('/loyalty-card-requests/{loyaltyCardRequest}/reject', [LoyaltyCardRequestController::class, 'reject'])->name('admin.loyalty_card_requests.reject');
Route::post('/loyalty-card-requests/{loyaltyCardRequest}/deliver', [LoyaltyCardRequestController::class, 'deliver'])->name('admin.loyalty_card_requests.deliver');
Route::get('/loyalty-card-requests/export', [LoyaltyCardRequestController::class, 'export'])->name('admin.loyalty_card_requests.export');

// API Routes for frontend
Route::get('/api/cities', [LoyaltyCardRequestController::class, 'getCities'])->name('api.cities');
Route::get('/api/branches-by-city', [LoyaltyCardRequestController::class, 'getBranchesByCity'])->name('api.branches.by.city');
Route::post('/api/loyalty-card-requests', [LoyaltyCardRequestController::class, 'store'])->name('api.loyalty_card_requests.store');
