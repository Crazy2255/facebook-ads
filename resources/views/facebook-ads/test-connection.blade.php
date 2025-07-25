<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facebook Ads API Test</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .test-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .btn {
            background: #4285f4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            margin-right: 1rem;
            margin-bottom: 1rem;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background: #3367d6;
        }
        .btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
        .result {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 6px;
            white-space: pre-wrap;
            font-family: monospace;
            font-size: 0.9rem;
        }
        .result.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .result.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .config-display {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
        }
        .config-item {
            margin-bottom: 0.5rem;
        }
        .config-label {
            font-weight: 600;
            color: #374151;
        }
        .config-value {
            color: #6b7280;
            font-family: monospace;
        }
        .breadcrumb {
            color: #666;
            margin-bottom: 1rem;
        }
        .breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-unknown {
            background: #9ca3af;
        }
        .status-success {
            background: #10b981;
        }
        .status-error {
            background: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > API Connection Test
            </div>
            <h1>Facebook Ads API Connection Test</h1>
            <p>Test your Facebook App credentials and Ad Account access before switching to live data.</p>
        </div>

        <div class="test-section">
            <h2>Current Configuration</h2>
            <div class="config-display">
                <div class="config-item">
                    <span class="config-label">App ID:</span>
                    <span class="config-value">{{ config('facebook-ads.app_id') }}</span>
                </div>
                <div class="config-item">
                    <span class="config-label">App Secret:</span>
                    <span class="config-value">{{ substr(config('facebook-ads.app_secret'), 0, 8) }}...</span>
                </div>
                <div class="config-item">
                    <span class="config-label">Access Token:</span>
                    <span class="config-value">{{ substr(config('facebook-ads.access_token'), 0, 20) }}...</span>
                </div>
                <div class="config-item">
                    <span class="config-label">Ad Account ID:</span>
                    <span class="config-value">{{ config('facebook-ads.ad_account_id') }}</span>
                </div>
                <div class="config-item">
                    <span class="config-label">API Version:</span>
                    <span class="config-value">{{ config('facebook-ads.api_version') }}</span>
                </div>
                <div class="config-item">
                    <span class="config-label">Using Dummy Data:</span>
                    <span class="config-value">{{ config('facebook-ads.use_dummy_data') ? 'Yes' : 'No' }}</span>
                </div>
            </div>
        </div>

        <div class="test-section">
            <h2>
                <span class="status-indicator status-unknown" id="apiStatus"></span>
                API Connection Test
            </h2>
            <p>Test basic Facebook API connectivity with your App credentials.</p>
            <button onclick="testApiConnection()" class="btn" id="testApiBtn">Test API Connection</button>
            <div id="apiResult"></div>
        </div>

        <div class="test-section">
            <h2>
                <span class="status-indicator status-unknown" id="adAccountStatus"></span>
                Ad Account Access Test
            </h2>
            <p>Test access to your Facebook Ad Account.</p>
            <button onclick="testAdAccount()" class="btn" id="testAdAccountBtn">Test Ad Account Access</button>
            <div id="adAccountResult"></div>
        </div>

        <div class="test-section">
            <h2>Next Steps</h2>
            <div style="background: #fff3cd; padding: 1rem; border-radius: 6px; border: 1px solid #ffeaa7; color: #856404;">
                <strong>If tests are failing:</strong>
                <ol style="margin: 0.5rem 0 0 1.5rem;">
                    <li><a href="{{ route('facebook-ads.test.token-generator') }}" style="color: #1e40af; text-decoration: underline;">Generate a proper User Access Token</a></li>
                    <li>Make sure your token has ads_management permissions</li>
                    <li>Verify you have access to the ad account</li>
                    <li>Update your .env file with the new token</li>
                </ol>
            </div>
            <div style="background: #d1fae5; padding: 1rem; border-radius: 6px; border: 1px solid #10b981; color: #065f46; margin-top: 1rem;">
                <strong>After successful tests:</strong>
                <ol style="margin: 0.5rem 0 0 1.5rem;">
                    <li>Set <code>FACEBOOK_USE_DUMMY_DATA=false</code> in your .env file</li>
                    <li>Test campaign creation with real API</li>
                    <li>Verify all functionality works with live data</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        async function testApiConnection() {
            const btn = document.getElementById('testApiBtn');
            const result = document.getElementById('apiResult');
            const status = document.getElementById('apiStatus');
            
            btn.disabled = true;
            btn.textContent = 'Testing...';
            result.innerHTML = '';
            status.className = 'status-indicator status-unknown';
            
            try {
                const response = await fetch('/facebook-ads/test/connection', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    result.innerHTML = `<div class="result success">✅ Success!\n\n${JSON.stringify(data, null, 2)}</div>`;
                    status.className = 'status-indicator status-success';
                } else {
                    result.innerHTML = `<div class="result error">❌ Failed!\n\n${JSON.stringify(data, null, 2)}</div>`;
                    status.className = 'status-indicator status-error';
                }
            } catch (error) {
                result.innerHTML = `<div class="result error">❌ Error: ${error.message}</div>`;
                status.className = 'status-indicator status-error';
            }
            
            btn.disabled = false;
            btn.textContent = 'Test API Connection';
        }

        async function testAdAccount() {
            const btn = document.getElementById('testAdAccountBtn');
            const result = document.getElementById('adAccountResult');
            const status = document.getElementById('adAccountStatus');
            
            btn.disabled = true;
            btn.textContent = 'Testing...';
            result.innerHTML = '';
            status.className = 'status-indicator status-unknown';
            
            try {
                const response = await fetch('/facebook-ads/test/ad-account', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    result.innerHTML = `<div class="result success">✅ Success!\n\n${JSON.stringify(data, null, 2)}</div>`;
                    status.className = 'status-indicator status-success';
                } else {
                    result.innerHTML = `<div class="result error">❌ Failed!\n\n${JSON.stringify(data, null, 2)}</div>`;
                    status.className = 'status-indicator status-error';
                }
            } catch (error) {
                result.innerHTML = `<div class="result error">❌ Error: ${error.message}</div>`;
                status.className = 'status-indicator status-error';
            }
            
            btn.disabled = false;
            btn.textContent = 'Test Ad Account Access';
        }
    </script>
</body>
</html>
