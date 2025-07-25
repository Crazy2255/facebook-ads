<?php

namespace App\Http\Controllers;

use App\Services\FacebookAdsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use FacebookAds\Api;

class FacebookAdsTestController extends Controller
{
    /**
     * Test Facebook API connection
     */
    public function testConnection(): JsonResponse
    {
        try {
            // Initialize Facebook API
            Api::init(
                config('facebook-ads.app_id'),
                config('facebook-ads.app_secret'),
                config('facebook-ads.access_token')
            );

            $api = Api::instance();
            
            // Test API call - get user info
            $response = $api->call('/me', 'GET');
            
            return response()->json([
                'success' => true,
                'message' => 'Facebook API connection successful!',
                'data' => $response->getContent(),
                'app_id' => config('facebook-ads.app_id'),
                'api_version' => config('facebook-ads.api_version')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Facebook API connection failed',
                'error' => $e->getMessage(),
                'suggestions' => [
                    'Check if your App ID and App Secret are correct',
                    'Verify your Access Token is valid and not expired',
                    'Make sure your Facebook App has Ads Management permissions',
                    'Check if your Ad Account ID is correct'
                ]
            ], 400);
        }
    }

    /**
     * Test Ad Account access
     */
    public function testAdAccount(): JsonResponse
    {
        try {
            Api::init(
                config('facebook-ads.app_id'),
                config('facebook-ads.app_secret'),
                config('facebook-ads.access_token')
            );

            $adAccountId = config('facebook-ads.ad_account_id');
            $api = Api::instance();
            
            // Test ad account access
            $response = $api->call("/{$adAccountId}", 'GET', [
                'fields' => 'id,name,account_status,currency,timezone_name'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Ad Account access successful!',
                'data' => $response->getContent()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ad Account access failed',
                'error' => $e->getMessage(),
                'suggestions' => [
                    'Check if your Ad Account ID is correct (should start with "act_")',
                    'Verify you have access to this ad account',
                    'Make sure your Access Token has ads_management permission'
                ]
            ], 400);
        }
    }

    /**
     * Show test page
     */
    public function showTestPage(): View
    {
        return view('facebook-ads.test-connection');
    }
}
