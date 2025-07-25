<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Facebook Ads Demo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 800px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4285f4 0%, #667eea 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 1rem 0;
            font-size: 2.5rem;
            font-weight: 300;
        }
        .header p {
            margin: 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .content {
            padding: 3rem 2rem;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        .feature {
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .feature h3 {
            margin: 0 0 0.5rem 0;
            color: #2d3748;
        }
        .feature p {
            margin: 0;
            color: #4a5568;
            font-size: 0.9rem;
        }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin: 2rem 0;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary {
            background: #4285f4;
            color: white;
        }
        .btn-primary:hover {
            background: #3367d6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #4285f4;
            border: 2px solid #4285f4;
        }
        .btn-secondary:hover {
            background: #4285f4;
            color: white;
        }
        .note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 2rem;
            color: #856404;
        }
        .note strong {
            color: #533f03;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Facebook Ads Demo</h1>
            <p>Laravel application with Facebook Ads API integration</p>
        </div>
        
        <div class="content">
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <h3>Campaign Management</h3>
                    <p>Create and manage Facebook advertising campaigns with ease</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🎯</div>
                    <h3>Ad Set Creation</h3>
                    <p>Set up targeting, budgets, and optimization goals</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📈</div>
                    <h3>Performance Insights</h3>
                    <p>View detailed analytics and campaign performance metrics</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🧪</div>
                    <h3>Dummy Data Testing</h3>
                    <p>Test all features with realistic dummy data</p>
                </div>
            </div>

            <div class="cta-buttons">
                <a href="{{ route('facebook-ads.dashboard') }}" class="btn btn-primary">
                    Open Facebook Ads Dashboard
                </a>
                <a href="/" class="btn btn-secondary">
                    Laravel Welcome Page
                </a>
            </div>

            <div class="note">
                <strong>Demo Mode:</strong> This application is currently running with dummy data for demonstration purposes. 
                To connect to the real Facebook Ads API, configure your App ID, App Secret, and Access Token in the <code>.env</code> file 
                and set <code>FACEBOOK_USE_DUMMY_DATA=false</code>.
            </div>
        </div>
    </div>
</body>
</html>
