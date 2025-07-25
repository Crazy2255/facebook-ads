<?php

namespace App\Services;

use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Ad;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use Illuminate\Support\Collection;

class FacebookAdsService
{
    protected $api;
    protected $adAccount;
    protected $useDummyData;

    public function __construct()
    {
        $this->useDummyData = config('facebook-ads.use_dummy_data', true);
        
        if (!$this->useDummyData) {
            Api::init(
                config('facebook-ads.app_id'),
                config('facebook-ads.app_secret'),
                config('facebook-ads.access_token')
            );
            
            $this->api = Api::instance();
            $this->adAccount = new AdAccount(config('facebook-ads.ad_account_id'));
        }
    }

    /**
     * Get all campaigns
     */
    public function getCampaigns(): Collection
    {
        if ($this->useDummyData) {
            return collect($this->getDummyCampaigns());
        }

        try {
            $campaigns = $this->adAccount->getCampaigns([
                CampaignFields::ID,
                CampaignFields::NAME,
                CampaignFields::STATUS,
                CampaignFields::OBJECTIVE,
                CampaignFields::CREATED_TIME,
                CampaignFields::UPDATED_TIME,
            ]);

            return collect($campaigns->getArrayCopy());
        } catch (\Exception $e) {
            return collect($this->getDummyCampaigns());
        }
    }

    /**
     * Create a new campaign
     */
    public function createCampaign(array $data): array
    {
        if ($this->useDummyData) {
            return $this->createDummyCampaign($data);
        }

        try {
            $campaign = new Campaign(null, $this->adAccount->id);
            $campaign->setData([
                CampaignFields::NAME => $data['name'],
                CampaignFields::OBJECTIVE => $data['objective'] ?? config('facebook-ads.default_campaign_objective'),
                CampaignFields::STATUS => $data['status'] ?? 'PAUSED',
                CampaignFields::SPECIAL_AD_CATEGORIES => [],
            ]);

            $campaign->create();
            return $campaign->exportAllData();
        } catch (\Exception $e) {
            return $this->createDummyCampaign($data);
        }
    }

    /**
     * Get ad sets for a campaign
     */
    public function getAdSets(string $campaignId): Collection
    {
        if ($this->useDummyData) {
            return collect($this->getDummyAdSets($campaignId));
        }

        try {
            $campaign = new Campaign($campaignId);
            $adSets = $campaign->getAdSets([
                AdSetFields::ID,
                AdSetFields::NAME,
                AdSetFields::STATUS,
                AdSetFields::DAILY_BUDGET,
                AdSetFields::OPTIMIZATION_GOAL,
                AdSetFields::CREATED_TIME,
            ]);

            return collect($adSets->getArrayCopy());
        } catch (\Exception $e) {
            return collect($this->getDummyAdSets($campaignId));
        }
    }

    /**
     * Create a new ad set
     */
    public function createAdSet(string $campaignId, array $data): array
    {
        if ($this->useDummyData) {
            return $this->createDummyAdSet($campaignId, $data);
        }

        try {
            $adSet = new AdSet(null, $this->adAccount->id);
            $adSet->setData([
                AdSetFields::NAME => $data['name'],
                AdSetFields::CAMPAIGN_ID => $campaignId,
                AdSetFields::DAILY_BUDGET => $data['daily_budget'] ?? 1000, // in cents
                AdSetFields::OPTIMIZATION_GOAL => $data['optimization_goal'] ?? config('facebook-ads.default_optimization_goal'),
                AdSetFields::BID_STRATEGY => config('facebook-ads.default_bid_strategy'),
                AdSetFields::STATUS => $data['status'] ?? 'PAUSED',
                AdSetFields::TARGETING => $data['targeting'] ?? ['geo_locations' => ['countries' => ['US']]],
            ]);

            $adSet->create();
            return $adSet->exportAllData();
        } catch (\Exception $e) {
            return $this->createDummyAdSet($campaignId, $data);
        }
    }

    /**
     * Get ads for an ad set
     */
    public function getAds(string $adSetId): Collection
    {
        if ($this->useDummyData) {
            return collect($this->getDummyAds($adSetId));
        }

        try {
            $adSet = new AdSet($adSetId);
            $ads = $adSet->getAds([
                AdFields::ID,
                AdFields::NAME,
                AdFields::STATUS,
                AdFields::CREATED_TIME,
                AdFields::UPDATED_TIME,
            ]);

            return collect($ads->getArrayCopy());
        } catch (\Exception $e) {
            return collect($this->getDummyAds($adSetId));
        }
    }

    /**
     * Get campaign insights/statistics
     */
    public function getCampaignInsights(string $campaignId): array
    {
        if ($this->useDummyData) {
            return $this->getDummyCampaignInsights($campaignId);
        }

        try {
            $campaign = new Campaign($campaignId);
            $insights = $campaign->getInsights([
                'impressions',
                'clicks',
                'spend',
                'reach',
                'frequency',
                'ctr',
                'cpm',
                'cpp',
                'cost_per_result',
            ]);

            return $insights->getArrayCopy()[0] ?? [];
        } catch (\Exception $e) {
            return $this->getDummyCampaignInsights($campaignId);
        }
    }

    /**
     * Dummy data methods for testing
     */
    private function getDummyCampaigns(): array
    {
        return [
            [
                'id' => 'camp_001',
                'name' => 'Summer Sale Campaign',
                'status' => 'ACTIVE',
                'objective' => 'OUTCOME_TRAFFIC',
                'created_time' => '2025-07-01T10:00:00+0000',
                'updated_time' => '2025-07-20T15:30:00+0000',
            ],
            [
                'id' => 'camp_002',
                'name' => 'Brand Awareness Campaign',
                'status' => 'PAUSED',
                'objective' => 'OUTCOME_AWARENESS',
                'created_time' => '2025-06-15T08:00:00+0000',
                'updated_time' => '2025-07-18T12:45:00+0000',
            ],
            [
                'id' => 'camp_003',
                'name' => 'Holiday Promotion',
                'status' => 'ACTIVE',
                'objective' => 'OUTCOME_SALES',
                'created_time' => '2025-07-10T14:00:00+0000',
                'updated_time' => '2025-07-24T09:15:00+0000',
            ],
        ];
    }

    private function createDummyCampaign(array $data): array
    {
        return [
            'id' => 'camp_' . rand(100, 999),
            'name' => $data['name'],
            'status' => $data['status'] ?? 'PAUSED',
            'objective' => $data['objective'] ?? config('facebook-ads.default_campaign_objective'),
            'created_time' => now()->toISOString(),
            'updated_time' => now()->toISOString(),
        ];
    }

    private function getDummyAdSets(string $campaignId): array
    {
        return [
            [
                'id' => 'adset_001',
                'name' => 'Desktop Users',
                'status' => 'ACTIVE',
                'daily_budget' => '2000',
                'optimization_goal' => 'REACH',
                'campaign_id' => $campaignId,
                'created_time' => '2025-07-01T10:00:00+0000',
            ],
            [
                'id' => 'adset_002',
                'name' => 'Mobile Users',
                'status' => 'ACTIVE',
                'daily_budget' => '1500',
                'optimization_goal' => 'IMPRESSIONS',
                'campaign_id' => $campaignId,
                'created_time' => '2025-07-01T11:00:00+0000',
            ],
        ];
    }

    private function createDummyAdSet(string $campaignId, array $data): array
    {
        return [
            'id' => 'adset_' . rand(100, 999),
            'name' => $data['name'],
            'status' => $data['status'] ?? 'PAUSED',
            'daily_budget' => $data['daily_budget'] ?? '1000',
            'optimization_goal' => $data['optimization_goal'] ?? config('facebook-ads.default_optimization_goal'),
            'campaign_id' => $campaignId,
            'created_time' => now()->toISOString(),
        ];
    }

    private function getDummyAds(string $adSetId): array
    {
        return [
            [
                'id' => 'ad_001',
                'name' => 'Creative Ad 1',
                'status' => 'ACTIVE',
                'adset_id' => $adSetId,
                'created_time' => '2025-07-01T12:00:00+0000',
                'updated_time' => '2025-07-20T16:30:00+0000',
            ],
            [
                'id' => 'ad_002',
                'name' => 'Creative Ad 2',
                'status' => 'PAUSED',
                'adset_id' => $adSetId,
                'created_time' => '2025-07-02T09:00:00+0000',
                'updated_time' => '2025-07-19T11:20:00+0000',
            ],
        ];
    }

    private function getDummyCampaignInsights(string $campaignId): array
    {
        return [
            'campaign_id' => $campaignId,
            'impressions' => rand(10000, 100000),
            'clicks' => rand(500, 5000),
            'spend' => rand(100, 1000) . '.00',
            'reach' => rand(8000, 80000),
            'frequency' => round(rand(100, 300) / 100, 2),
            'ctr' => round(rand(100, 500) / 100, 2),
            'cpm' => round(rand(500, 2000) / 100, 2),
            'cpp' => round(rand(1000, 4000) / 100, 2),
            'cost_per_result' => round(rand(50, 200) / 100, 2),
        ];
    }
}
