<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookAdsController;
use App\Http\Controllers\FacebookAdsTestController;

Route::get('/', function () {
    return view('facebook-ads-welcome');
});

Route::get('/laravel', function () {
    return view('welcome');
});

// Facebook Ads Routes
Route::prefix('facebook-ads')->name('facebook-ads.')->group(function () {
    // Dashboard
    Route::get('/', [FacebookAdsController::class, 'dashboard'])->name('dashboard');
    
    // Campaigns
    Route::get('/campaigns', [FacebookAdsController::class, 'getCampaigns'])->name('campaigns.index');
    Route::get('/campaigns/create', [FacebookAdsController::class, 'showCreateCampaign'])->name('campaigns.create');
    Route::post('/campaigns', [FacebookAdsController::class, 'createCampaign'])->name('campaigns.store');
    Route::get('/campaigns/{campaignId}', [FacebookAdsController::class, 'showCampaign'])->name('campaigns.show');
    Route::get('/campaigns/{campaignId}/insights', [FacebookAdsController::class, 'getCampaignInsights'])->name('campaigns.insights');
    
    // Ad Sets
    Route::get('/campaigns/{campaignId}/ad-sets', [FacebookAdsController::class, 'showAdSets'])->name('ad-sets.index');
    Route::get('/campaigns/{campaignId}/ad-sets/data', [FacebookAdsController::class, 'getAdSets'])->name('ad-sets.data');
    Route::get('/campaigns/{campaignId}/ad-sets/create', [FacebookAdsController::class, 'showCreateAdSet'])->name('ad-sets.create');
    Route::post('/campaigns/{campaignId}/ad-sets', [FacebookAdsController::class, 'createAdSet'])->name('ad-sets.store');
    
    // Ads
    Route::get('/ad-sets/{adSetId}/ads', [FacebookAdsController::class, 'getAds'])->name('ads.index');
    
    // API Testing Routes
    Route::get('/test', [FacebookAdsTestController::class, 'showTestPage'])->name('test.page');
    Route::get('/test/connection', [FacebookAdsTestController::class, 'testConnection'])->name('test.connection');
    Route::get('/test/ad-account', [FacebookAdsTestController::class, 'testAdAccount'])->name('test.ad-account');
    Route::get('/test/token-generator', function () {
        return view('facebook-ads.token-generator');
    })->name('test.token-generator');
});
