<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facebook Ads Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #4285f4;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            color: #666;
            margin-top: 0.5rem;
        }
        .campaigns-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .btn {
            background: #4285f4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background: #3367d6;
        }
        .campaigns-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .campaigns-table th,
        .campaigns-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .campaigns-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #2d3748;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-paused {
            background: #f8d7da;
            color: #721c24;
        }
        .campaign-link {
            color: #4285f4;
            text-decoration: none;
            font-weight: 500;
        }
        .campaign-link:hover {
            text-decoration: underline;
        }
        .nav-links {
            margin-bottom: 1rem;
        }
        .nav-links a {
            color: #4285f4;
            text-decoration: none;
            margin-right: 1rem;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .nav-links a:hover {
            background: #f0f4ff;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Facebook Ads Dashboard</h1>
            <p>Manage your Facebook advertising campaigns, ad sets, and performance metrics</p>
        </div>

        <div class="nav-links">
            <a href="{{ route('facebook-ads.dashboard') }}">Dashboard</a>
            <a href="{{ route('facebook-ads.campaigns.create') }}">Create Campaign</a>
            <a href="{{ route('facebook-ads.test.page') }}">Test API Connection</a>
            <a href="/">← Back to Home</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalCampaigns }}</div>
                <div class="stat-label">Total Campaigns</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $activeCampaigns }}</div>
                <div class="stat-label">Active Campaigns</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $pausedCampaigns }}</div>
                <div class="stat-label">Paused Campaigns</div>
            </div>
        </div>

        <div class="campaigns-section">
            <div class="section-header">
                <h2>Recent Campaigns</h2>
                <a href="{{ route('facebook-ads.campaigns.create') }}" class="btn">Create New Campaign</a>
            </div>

            @if($campaigns->count() > 0)
                <table class="campaigns-table">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Objective</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                            <tr>
                                <td>
                                    <a href="{{ route('facebook-ads.campaigns.show', $campaign['id']) }}" class="campaign-link">
                                        {{ $campaign['name'] }}
                                    </a>
                                </td>
                                <td>{{ $campaign['objective'] }}</td>
                                <td>
                                    <span class="status-badge {{ $campaign['status'] === 'ACTIVE' ? 'status-active' : 'status-paused' }}">
                                        {{ $campaign['status'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($campaign['created_time'])->format('M j, Y') }}</td>
                                <td>
                                    <a href="{{ route('facebook-ads.campaigns.show', $campaign['id']) }}" class="campaign-link">View Details</a>
                                    |
                                    <a href="{{ route('facebook-ads.ad-sets.index', $campaign['id']) }}" class="campaign-link">Ad Sets</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 2rem; color: #666;">
                    <p>No campaigns found. <a href="{{ route('facebook-ads.campaigns.create') }}" class="campaign-link">Create your first campaign</a></p>
                </div>
            @endif
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background: #e3f2fd; border-radius: 8px; border-left: 4px solid #2196f3;">
            <strong>Note:</strong> This demo is using dummy data. In production, connect to real Facebook Ads API with your App ID, App Secret, and Access Token.
        </div>
    </div>
</body>
</html>
