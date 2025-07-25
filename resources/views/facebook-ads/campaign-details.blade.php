<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Campaign Details - {{ $campaign['name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .breadcrumb {
            color: #666;
            margin-bottom: 1rem;
        }
        .breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }
        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
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
        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .insight-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .insight-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .insight-label {
            color: #666;
            font-size: 0.875rem;
        }
        .section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
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
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .adsets-table {
            width: 100%;
            border-collapse: collapse;
        }
        .adsets-table th,
        .adsets-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .adsets-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #2d3748;
        }
        .link {
            color: #4285f4;
            text-decoration: none;
            font-weight: 500;
        }
        .link:hover {
            text-decoration: underline;
        }
        .campaign-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .info-item {
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }
        .info-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        .info-value {
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > Campaign Details
            </div>
            
            <div class="campaign-header">
                <div>
                    <h1>{{ $campaign['name'] }}</h1>
                    <span class="status-badge {{ $campaign['status'] === 'ACTIVE' ? 'status-active' : 'status-paused' }}">
                        {{ $campaign['status'] }}
                    </span>
                </div>
                <div>
                    <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn">Create Ad Set</a>
                    <a href="{{ route('facebook-ads.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>

            <div class="campaign-info">
                <div class="info-item">
                    <div class="info-label">Campaign ID</div>
                    <div class="info-value">{{ $campaign['id'] }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Objective</div>
                    <div class="info-value">{{ $campaign['objective'] }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Created</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($campaign['created_time'])->format('M j, Y g:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($campaign['updated_time'])->format('M j, Y g:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="insights-grid">
            <div class="insight-card">
                <div class="insight-value">{{ number_format($insights['impressions']) }}</div>
                <div class="insight-label">Impressions</div>
            </div>
            <div class="insight-card">
                <div class="insight-value">{{ number_format($insights['clicks']) }}</div>
                <div class="insight-label">Clicks</div>
            </div>
            <div class="insight-card">
                <div class="insight-value">${{ $insights['spend'] }}</div>
                <div class="insight-label">Spend</div>
            </div>
            <div class="insight-card">
                <div class="insight-value">{{ number_format($insights['reach']) }}</div>
                <div class="insight-label">Reach</div>
            </div>
            <div class="insight-card">
                <div class="insight-value">{{ $insights['ctr'] }}%</div>
                <div class="insight-label">CTR</div>
            </div>
            <div class="insight-card">
                <div class="insight-value">${{ $insights['cpm'] }}</div>
                <div class="insight-label">CPM</div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Ad Sets ({{ $adSets->count() }})</h2>
                <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn">Create New Ad Set</a>
            </div>

            @if($adSets->count() > 0)
                <table class="adsets-table">
                    <thead>
                        <tr>
                            <th>Ad Set Name</th>
                            <th>Status</th>
                            <th>Daily Budget</th>
                            <th>Optimization Goal</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adSets as $adSet)
                            <tr>
                                <td>
                                    <strong>{{ $adSet['name'] }}</strong>
                                    <div style="font-size: 0.875rem; color: #666;">ID: {{ $adSet['id'] }}</div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $adSet['status'] === 'ACTIVE' ? 'status-active' : 'status-paused' }}">
                                        {{ $adSet['status'] }}
                                    </span>
                                </td>
                                <td>${{ number_format($adSet['daily_budget'] / 100, 2) }}</td>
                                <td>{{ $adSet['optimization_goal'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($adSet['created_time'])->format('M j, Y') }}</td>
                                <td>
                                    <a href="#" class="link" onclick="viewAds('{{ $adSet['id'] }}')">View Ads</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 2rem; color: #666;">
                    <p>No ad sets found for this campaign.</p>
                    <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn">Create First Ad Set</a>
                </div>
            @endif
        </div>

        <!-- Ads Modal (Hidden by default) -->
        <div id="adsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 12px; max-width: 600px; width: 90%;">
                <h3>Ads in Ad Set</h3>
                <div id="adsContent"></div>
                <button onclick="closeAdsModal()" class="btn btn-secondary" style="margin-top: 1rem;">Close</button>
            </div>
        </div>
    </div>

    <script>
        function viewAds(adSetId) {
            fetch(`/facebook-ads/ad-sets/${adSetId}/ads`)
                .then(response => response.json())
                .then(data => {
                    let content = '';
                    if (data.data.length > 0) {
                        content = '<table style="width: 100%; border-collapse: collapse;">';
                        content += '<thead><tr><th style="padding: 8px; border-bottom: 1px solid #ddd;">Ad Name</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Status</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Created</th></tr></thead><tbody>';
                        data.data.forEach(ad => {
                            content += `<tr>
                                <td style="padding: 8px; border-bottom: 1px solid #eee;">${ad.name}</td>
                                <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                    <span class="status-badge ${ad.status === 'ACTIVE' ? 'status-active' : 'status-paused'}">${ad.status}</span>
                                </td>
                                <td style="padding: 8px; border-bottom: 1px solid #eee;">${new Date(ad.created_time).toLocaleDateString()}</td>
                            </tr>`;
                        });
                        content += '</tbody></table>';
                    } else {
                        content = '<p>No ads found in this ad set.</p>';
                    }
                    document.getElementById('adsContent').innerHTML = content;
                    document.getElementById('adsModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('adsContent').innerHTML = '<p>Error loading ads.</p>';
                    document.getElementById('adsModal').style.display = 'block';
                });
        }

        function closeAdsModal() {
            document.getElementById('adsModal').style.display = 'none';
        }
    </script>
</body>
</html>
