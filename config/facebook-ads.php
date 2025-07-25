<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Facebook App Configuration
    |--------------------------------------------------------------------------
    */
    'app_id' => env('FACEBOOK_APP_ID', 'dummy_app_id_123456789'),
    'app_secret' => env('FACEBOOK_APP_SECRET', 'dummy_app_secret_abcdef123456'),
    'access_token' => env('FACEBOOK_ACCESS_TOKEN', 'dummy_access_token_xyz789'),

    /*
    |--------------------------------------------------------------------------
    | Facebook Ads Configuration
    |--------------------------------------------------------------------------
    */
    'ad_account_id' => env('FACEBOOK_AD_ACCOUNT_ID', 'act_123456789'),
    'api_version' => env('FACEBOOK_API_VERSION', 'v21.0'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Campaign Settings
    |--------------------------------------------------------------------------
    */
    'default_campaign_objective' => 'OUTCOME_TRAFFIC',
    'default_bid_strategy' => 'LOWEST_COST_WITHOUT_CAP',
    'default_optimization_goal' => 'REACH',
    
    /*
    |--------------------------------------------------------------------------
    | Dummy Data Configuration
    |--------------------------------------------------------------------------
    */
    'use_dummy_data' => env('FACEBOOK_USE_DUMMY_DATA', true),
];
