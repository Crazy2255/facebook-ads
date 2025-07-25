<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ad Sets - {{ $campaign['name'] }}</title>
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
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-left: 1rem;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-paused {
            background: #f8d7da;
            color: #721c24;
        }
        .section {
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
        .btn-secondary {
            background: #6c757d;
            margin-right: 1rem;
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
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }
        .info-item {
            text-align: center;
        }
        .info-label {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-weight: 600;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > 
                <a href="{{ route('facebook-ads.campaigns.show', $campaign['id']) }}">{{ $campaign['name'] }}</a> > 
                Ad Sets
            </div>
            
            <div class="campaign-header">
                <div>
                    <h1>Ad Sets for "{{ $campaign['name'] }}"</h1>
                    <span class="status-badge {{ $campaign['status'] === 'ACTIVE' ? 'status-active' : 'status-paused' }}">
                        Campaign {{ $campaign['status'] }}
                    </span>
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
                    <div class="info-label">Ad Sets</div>
                    <div class="info-value">{{ $adSets->count() }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Created</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($campaign['created_time'])->format('M j, Y') }}</div>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn">Create New Ad Set</a>
                <a href="{{ route('facebook-ads.campaigns.show', $campaign['id']) }}" class="btn btn-secondary">Back to Campaign</a>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Ad Sets ({{ $adSets->count() }})</h2>
                <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn">Create Ad Set</a>
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
                                    <div style="font-size: 0.875rem; color: #666; margin-top: 0.25rem;">
                                        ID: {{ $adSet['id'] }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $adSet['status'] === 'ACTIVE' ? 'status-active' : 'status-paused' }}">
                                        {{ $adSet['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <strong>${{ number_format($adSet['daily_budget'] / 100, 2) }}</strong>
                                    <div style="font-size: 0.875rem; color: #666;">per day</div>
                                </td>
                                <td>{{ $adSet['optimization_goal'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($adSet['created_time'])->format('M j, Y g:i A') }}</td>
                                <td>
                                    <a href="#" class="link" onclick="viewAds('{{ $adSet['id'] }}', '{{ $adSet['name'] }}')">
                                        View Ads
                                    </a>
                                    |
                                    <a href="#" class="link" onclick="editAdSet('{{ $adSet['id'] }}')">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                    <h3>No Ad Sets Yet</h3>
                    <p>Create your first ad set to start running ads in this campaign.</p>
                    <a href="{{ route('facebook-ads.ad-sets.create', $campaign['id']) }}" class="btn" style="margin-top: 1rem;">
                        Create Your First Ad Set
                    </a>
                </div>
            @endif
        </div>

        <!-- Ads Modal -->
        <div id="adsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 12px; max-width: 800px; width: 90%; max-height: 80vh; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 id="adsModalTitle">Ads in Ad Set</h3>
                    <button onclick="closeAdsModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                </div>
                <div id="adsContent"></div>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <button onclick="closeAdsModal()" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewAds(adSetId, adSetName) {
            document.getElementById('adsModalTitle').textContent = `Ads in "${adSetName}"`;
            document.getElementById('adsContent').innerHTML = '<div style="text-align: center; padding: 2rem;">Loading ads...</div>';
            document.getElementById('adsModal').style.display = 'block';

            fetch(`/facebook-ads/ad-sets/${adSetId}/ads`)
                .then(response => response.json())
                .then(data => {
                    let content = '';
                    if (data.data.length > 0) {
                        content = '<div style="overflow-x: auto;"><table style="width: 100%; border-collapse: collapse;">';
                        content += '<thead><tr style="background: #f8fafc;"><th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Ad Name</th><th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Status</th><th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Created</th><th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Last Updated</th></tr></thead><tbody>';
                        data.data.forEach(ad => {
                            const statusClass = ad.status === 'ACTIVE' ? 'status-active' : 'status-paused';
                            content += `<tr>
                                <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                                    <strong>${ad.name}</strong>
                                    <div style="font-size: 0.875rem; color: #666; margin-top: 0.25rem;">ID: ${ad.id}</div>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                                    <span class="status-badge ${statusClass}">${ad.status}</span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">${new Date(ad.created_time).toLocaleDateString()}</td>
                                <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">${new Date(ad.updated_time).toLocaleDateString()}</td>
                            </tr>`;
                        });
                        content += '</tbody></table></div>';
                    } else {
                        content = `
                            <div style="text-align: center; padding: 2rem; color: #666;">
                                <div style="font-size: 2rem; margin-bottom: 1rem;">📢</div>
                                <h4>No Ads Found</h4>
                                <p>This ad set doesn't have any ads yet. Create ads to start reaching your audience.</p>
                            </div>
                        `;
                    }
                    document.getElementById('adsContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('adsContent').innerHTML = '<div style="text-align: center; padding: 2rem; color: #e53e3e;">Error loading ads. Please try again.</div>';
                });
        }

        function editAdSet(adSetId) {
            alert(`Edit Ad Set functionality would be implemented here for Ad Set ID: ${adSetId}`);
        }

        function closeAdsModal() {
            document.getElementById('adsModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('adsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAdsModal();
            }
        });
    </script>
</body>
</html>
