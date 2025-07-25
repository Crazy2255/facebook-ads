<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create New Campaign</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        .breadcrumb {
            color: #666;
            margin-bottom: 1rem;
        }
        .breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2d3748;
        }
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
        }
        .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 1rem;
            background: white;
        }
        .btn {
            background: #4285f4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
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
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-help {
            font-size: 0.875rem;
            color: #666;
            margin-top: 0.25rem;
        }
        .objective-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }
        .objective-option {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .objective-option:hover {
            border-color: #4285f4;
            background: #f0f4ff;
        }
        .objective-option.selected {
            border-color: #4285f4;
            background: #e3f2fd;
        }
        .objective-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .objective-desc {
            font-size: 0.875rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > Create Campaign
            </div>
            <h1>Create New Campaign</h1>
            <p>Set up a new Facebook advertising campaign with your objectives and settings.</p>
        </div>

        <div class="form-container">
            <div id="alertContainer"></div>

            <form id="campaignForm">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Campaign Name *</label>
                    <input type="text" id="name" name="name" class="form-input" required 
                           placeholder="Enter campaign name (e.g., Summer Sale 2025)">
                    <div class="form-help">Choose a descriptive name for your campaign</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Campaign Objective *</label>
                    <div class="objective-grid">
                        <div class="objective-option" data-objective="OUTCOME_AWARENESS">
                            <div class="objective-title">Brand Awareness</div>
                            <div class="objective-desc">Increase awareness of your brand</div>
                        </div>
                        <div class="objective-option selected" data-objective="OUTCOME_TRAFFIC">
                            <div class="objective-title">Traffic</div>
                            <div class="objective-desc">Send people to your website</div>
                        </div>
                        <div class="objective-option" data-objective="OUTCOME_ENGAGEMENT">
                            <div class="objective-title">Engagement</div>
                            <div class="objective-desc">Get more likes, comments, and shares</div>
                        </div>
                        <div class="objective-option" data-objective="OUTCOME_LEADS">
                            <div class="objective-title">Lead Generation</div>
                            <div class="objective-desc">Collect leads for your business</div>
                        </div>
                        <div class="objective-option" data-objective="OUTCOME_SALES">
                            <div class="objective-title">Sales</div>
                            <div class="objective-desc">Drive sales and conversions</div>
                        </div>
                        <div class="objective-option" data-objective="OUTCOME_APP_PROMOTION">
                            <div class="objective-title">App Promotion</div>
                            <div class="objective-desc">Promote your mobile app</div>
                        </div>
                    </div>
                    <input type="hidden" id="objective" name="objective" value="OUTCOME_TRAFFIC">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Campaign Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="PAUSED">Paused (Recommended for new campaigns)</option>
                        <option value="ACTIVE">Active</option>
                    </select>
                    <div class="form-help">You can activate the campaign later after setting up ad sets and ads</div>
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <button type="button" onclick="window.location.href='{{ route('facebook-ads.dashboard') }}'" class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn">
                        Create Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle objective selection
        document.querySelectorAll('.objective-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.objective-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Update hidden input
                document.getElementById('objective').value = this.dataset.objective;
            });
        });

        // Handle form submission
        document.getElementById('campaignForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Creating...';
            submitBtn.disabled = true;
            
            fetch('{{ route("facebook-ads.campaigns.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Campaign created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("facebook-ads.dashboard") }}';
                    }, 1500);
                } else {
                    showAlert(data.message || 'Error creating campaign', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error creating campaign. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    ${message}
                </div>
            `;
            
            // Auto-hide success alerts
            if (type === 'success') {
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, 3000);
            }
        }
    </script>
</body>
</html>
