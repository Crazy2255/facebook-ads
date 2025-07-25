<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Access Token Generator</title>
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
        .step {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .step h3 {
            margin-top: 0;
            color: #1f2937;
        }
        .code-block {
            background: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 6px;
            font-family: monospace;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .url-link {
            display: block;
            background: #dbeafe;
            color: #1e40af;
            padding: 1rem;
            border-radius: 6px;
            text-decoration: none;
            margin: 1rem 0;
            word-break: break-all;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
        }
        .success {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
        }
        .breadcrumb {
            color: #666;
            margin-bottom: 1rem;
        }
        .breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }
        ol {
            padding-left: 1.5rem;
        }
        li {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > 
                <a href="{{ route('facebook-ads.test.page') }}">API Test</a> > 
                Generate Access Token
            </div>
            <h1>🔑 Generate Facebook User Access Token</h1>
            <p>Follow these steps to generate a proper User Access Token with the required permissions.</p>
        </div>

        <div class="step">
            <h3>📋 Step 1: Go to Facebook Graph API Explorer</h3>
            <p>Open the Facebook Graph API Explorer to generate a User Access Token:</p>
            <a href="https://developers.facebook.com/tools/explorer/" target="_blank" class="url-link">
                🔗 https://developers.facebook.com/tools/explorer/
            </a>
        </div>

        <div class="step">
            <h3>⚙️ Step 2: Configure the Explorer</h3>
            <ol>
                <li><strong>Select your Facebook App</strong> from the dropdown (App ID: {{ config('facebook-ads.app_id') }})</li>
                <li><strong>Click "Generate Access Token"</strong> button</li>
                <li><strong>Select the following permissions:</strong>
                    <div class="code-block">ads_management
ads_read
business_management
pages_read_engagement
pages_manage_ads</div>
                </li>
                <li><strong>Click "Generate Access Token"</strong></li>
                <li><strong>Copy the generated token</strong> (it should start with your User ID, not App ID)</li>
            </ol>
        </div>

        <div class="step">
            <h3>🔄 Step 3: Get Long-Lived Token (Optional but Recommended)</h3>
            <p>Convert your short-lived token to a long-lived token using this URL:</p>
            <div class="code-block">https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id={{ config('facebook-ads.app_id') }}&client_secret={{ config('facebook-ads.app_secret') }}&fb_exchange_token=YOUR_SHORT_LIVED_TOKEN</div>
            
            <div class="warning">
                <strong>Note:</strong> Replace YOUR_SHORT_LIVED_TOKEN with the token from Step 2
            </div>
        </div>

        <div class="step">
            <h3>📝 Step 4: Update Your .env File</h3>
            <p>Update your .env file with the new User Access Token:</p>
            <div class="code-block">FACEBOOK_ACCESS_TOKEN=YOUR_NEW_USER_ACCESS_TOKEN
FACEBOOK_API_VERSION=v21.0
FACEBOOK_USE_DUMMY_DATA=false</div>
        </div>

        <div class="step">
            <h3>🔍 Step 5: Verify Ad Account Access</h3>
            <p>Make sure you have access to the ad account. Check these:</p>
            <ol>
                <li><strong>Go to Facebook Ads Manager:</strong> 
                    <a href="https://www.facebook.com/adsmanager/" target="_blank" class="url-link">
                        https://www.facebook.com/adsmanager/
                    </a>
                </li>
                <li><strong>Select your ad account</strong> and verify the URL shows: <code>act_301794521967906</code></li>
                <li><strong>Make sure you have admin or advertiser access</strong> to this account</li>
                <li><strong>If you don't see this account</strong>, use a different ad account ID</li>
            </ol>
        </div>

        <div class="step">
            <h3>🧪 Step 6: Test Again</h3>
            <p>After updating your .env file:</p>
            <ol>
                <li>Save the .env file</li>
                <li>Go back to the <a href="{{ route('facebook-ads.test.page') }}">API Test Page</a></li>
                <li>Run the tests again</li>
            </ol>
        </div>

        <div class="step">
            <h3>🛠️ Alternative: Use Facebook Business Manager</h3>
            <p>If you continue having issues, try getting a System User Access Token:</p>
            <ol>
                <li>Go to <a href="https://business.facebook.com/" target="_blank" class="url-link">Facebook Business Manager</a></li>
                <li>Go to Business Settings → System Users</li>
                <li>Create a new System User or use existing</li>
                <li>Generate Access Token with ads_management permissions</li>
                <li>Use this token in your .env file</li>
            </ol>
        </div>

        <div class="warning">
            <strong>⚠️ Common Issues:</strong>
            <ul>
                <li><strong>App Access Token vs User Access Token:</strong> Make sure you're using a User Access Token, not an App Access Token</li>
                <li><strong>Permissions:</strong> Your token must have ads_management and ads_read permissions</li>
                <li><strong>Ad Account Access:</strong> You must be an admin/advertiser on the ad account</li>
                <li><strong>App Review:</strong> Some permissions might need Facebook app review for production use</li>
            </ul>
        </div>
    </div>
</body>
</html>
