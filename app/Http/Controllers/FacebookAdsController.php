<?php

namespace App\Http\Controllers;

use App\Services\FacebookAdsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class FacebookAdsController extends Controller
{
    protected $facebookAdsService;

    public function __construct(FacebookAdsService $facebookAdsService)
    {
        $this->facebookAdsService = $facebookAdsService;
    }

    /**
     * Display the main dashboard
     */
    public function dashboard(): View
    {
        $campaigns = $this->facebookAdsService->getCampaigns();
        
        // Calculate summary statistics
        $totalCampaigns = $campaigns->count();
        $activeCampaigns = $campaigns->where('status', 'ACTIVE')->count();
        $pausedCampaigns = $campaigns->where('status', 'PAUSED')->count();
        
        return view('facebook-ads.dashboard', compact(
            'campaigns', 
            'totalCampaigns', 
            'activeCampaigns', 
            'pausedCampaigns'
        ));
    }

    /**
     * Get all campaigns
     */
    public function getCampaigns(): JsonResponse
    {
        $campaigns = $this->facebookAdsService->getCampaigns();
        
        return response()->json([
            'success' => true,
            'data' => $campaigns,
            'count' => $campaigns->count()
        ]);
    }

    /**
     * Show campaign details
     */
    public function showCampaign(string $campaignId): View
    {
        $campaigns = $this->facebookAdsService->getCampaigns();
        $campaign = $campaigns->firstWhere('id', $campaignId);
        
        if (!$campaign) {
            abort(404, 'Campaign not found');
        }
        
        $adSets = $this->facebookAdsService->getAdSets($campaignId);
        $insights = $this->facebookAdsService->getCampaignInsights($campaignId);
        
        return view('facebook-ads.campaign-details', compact('campaign', 'adSets', 'insights'));
    }

    /**
     * Create a new campaign
     */
    public function createCampaign(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'objective' => 'required|string',
            'status' => 'sometimes|string|in:ACTIVE,PAUSED',
        ]);

        try {
            $campaign = $this->facebookAdsService->createCampaign($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Campaign created successfully',
                'data' => $campaign
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create campaign: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ad sets for a campaign
     */
    public function getAdSets(string $campaignId): JsonResponse
    {
        $adSets = $this->facebookAdsService->getAdSets($campaignId);
        
        return response()->json([
            'success' => true,
            'data' => $adSets,
            'count' => $adSets->count()
        ]);
    }

    /**
     * Create a new ad set
     */
    public function createAdSet(string $campaignId, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'daily_budget' => 'required|integer|min:100',
            'optimization_goal' => 'sometimes|string',
            'status' => 'sometimes|string|in:ACTIVE,PAUSED',
        ]);

        try {
            $adSet = $this->facebookAdsService->createAdSet($campaignId, $validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Ad Set created successfully',
                'data' => $adSet
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ad set: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ads for an ad set
     */
    public function getAds(string $adSetId): JsonResponse
    {
        $ads = $this->facebookAdsService->getAds($adSetId);
        
        return response()->json([
            'success' => true,
            'data' => $ads,
            'count' => $ads->count()
        ]);
    }

    /**
     * Get campaign insights
     */
    public function getCampaignInsights(string $campaignId): JsonResponse
    {
        $insights = $this->facebookAdsService->getCampaignInsights($campaignId);
        
        return response()->json([
            'success' => true,
            'data' => $insights
        ]);
    }

    /**
     * Show create campaign form
     */
    public function showCreateCampaign(): View
    {
        return view('facebook-ads.create-campaign');
    }

    /**
     * Show ad sets page
     */
    public function showAdSets(string $campaignId): View
    {
        $campaigns = $this->facebookAdsService->getCampaigns();
        $campaign = $campaigns->firstWhere('id', $campaignId);
        
        if (!$campaign) {
            abort(404, 'Campaign not found');
        }
        
        $adSets = $this->facebookAdsService->getAdSets($campaignId);
        
        return view('facebook-ads.ad-sets', compact('campaign', 'adSets'));
    }

    /**
     * Show create ad set form
     */
    public function showCreateAdSet(string $campaignId): View
    {
        $campaigns = $this->facebookAdsService->getCampaigns();
        $campaign = $campaigns->firstWhere('id', $campaignId);
        
        if (!$campaign) {
            abort(404, 'Campaign not found');
        }
        
        return view('facebook-ads.create-ad-set', compact('campaign'));
    }
}
