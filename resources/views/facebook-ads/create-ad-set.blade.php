<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Ad Set - {{ $campaign['name'] }}</title>
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
        .campaign-info {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
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
        .budget-preview {
            background: #e3f2fd;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 0.5rem;
        }
        .optimization-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .optimization-option {
            padding: 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            background: white;
        }
        .optimization-option:hover {
            border-color: #4285f4;
            background: #f0f4ff;
        }
        .optimization-option.selected {
            border-color: #4285f4;
            background: #e3f2fd;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="{{ route('facebook-ads.dashboard') }}">Facebook Ads</a> > 
                <a href="{{ route('facebook-ads.campaigns.show', $campaign['id']) }}">{{ $campaign['name'] }}</a> > 
                <a href="{{ route('facebook-ads.ad-sets.index', $campaign['id']) }}">Ad Sets</a> > 
                Create Ad Set
            </div>
            <h1>Create New Ad Set</h1>
            <p>Set up targeting, budget, and optimization for your ads.</p>

            <div class="campaign-info">
                <strong>Campaign:</strong> {{ $campaign['name'] }} ({{ $campaign['objective'] }})
                <br>
                <strong>Campaign ID:</strong> {{ $campaign['id'] }}
            </div>
        </div>

        <div class="form-container">
            <div id="alertContainer"></div>

            <form id="adSetForm">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Ad Set Name *</label>
                    <input type="text" id="name" name="name" class="form-input" required 
                           placeholder="Enter ad set name (e.g., Desktop Users 18-65)">
                    <div class="form-help">Choose a descriptive name that reflects your targeting</div>
                </div>

                <div class="form-group">
                    <label for="daily_budget" class="form-label">Daily Budget *</label>
                    <input type="number" id="daily_budget" name="daily_budget" class="form-input" 
                           min="100" step="50" value="1000" required 
                           placeholder="Enter daily budget in cents">
                    <div class="form-help">Minimum $1.00 (100 cents). This is the maximum amount you'll spend per day.</div>
                    <div class="budget-preview" id="budgetPreview">
                        Daily Budget: $10.00 | Monthly Estimate: ~$300.00
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Optimization Goal *</label>
                    <div class="optimization-grid">
                        <div class="optimization-option selected" data-goal="REACH">
                            <div>Reach</div>
                        </div>
                        <div class="optimization-option" data-goal="IMPRESSIONS">
                            <div>Impressions</div>
                        </div>
                        <div class="optimization-option" data-goal="LINK_CLICKS">
                            <div>Link Clicks</div>
                        </div>
                        <div class="optimization-option" data-goal="LANDING_PAGE_VIEWS">
                            <div>Page Views</div>
                        </div>
                        <div class="optimization-option" data-goal="POST_ENGAGEMENT">
                            <div>Engagement</div>
                        </div>
                        <div class="optimization-option" data-goal="OFFSITE_CONVERSIONS">
                            <div>Conversions</div>
                        </div>
                    </div>
                    <input type="hidden" id="optimization_goal" name="optimization_goal" value="REACH">
                    <div class="form-help">Choose what you want to optimize your ad delivery for</div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Ad Set Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="PAUSED">Paused (Recommended for new ad sets)</option>
                        <option value="ACTIVE">Active</option>
                    </select>
                    <div class="form-help">You can activate the ad set later after creating ads</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Targeting</label>
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 6px; border: 1px solid #e2e8f0;">
                        <h4 style="margin-top: 0;">Default Targeting Settings</h4>
                        <ul style="margin: 0; padding-left: 1.5rem; color: #666;">
                            <li>Location: United States</li>
                            <li>Age: 18-65</li>
                            <li>Gender: All</li>
                            <li>Language: English</li>
                        </ul>
                        <div class="form-help" style="margin-top: 0.5rem;">
                            Advanced targeting options can be configured after creating the ad set
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <button type="button" onclick="goBack()" class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn">
                        Create Ad Set
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle optimization goal selection
        document.querySelectorAll('.optimization-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.optimization-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Update hidden input
                document.getElementById('optimization_goal').value = this.dataset.goal;
            });
        });

        // Handle budget preview
        document.getElementById('daily_budget').addEventListener('input', function() {
            const dailyBudget = parseFloat(this.value) || 0;
            const dailyAmount = (dailyBudget / 100).toFixed(2);
            const monthlyEstimate = (dailyBudget * 30 / 100).toFixed(2);
            
            document.getElementById('budgetPreview').textContent = 
                `Daily Budget: $${dailyAmount} | Monthly Estimate: ~$${monthlyEstimate}`;
        });

        // Handle form submission
        document.getElementById('adSetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Creating...';
            submitBtn.disabled = true;
            
            fetch('{{ route("facebook-ads.ad-sets.store", $campaign["id"]) }}', {
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
                    showAlert('Ad Set created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("facebook-ads.ad-sets.index", $campaign["id"]) }}';
                    }, 1500);
                } else {
                    showAlert(data.message || 'Error creating ad set', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error creating ad set. Please try again.', 'error');
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

        function goBack() {
            window.location.href = '{{ route("facebook-ads.ad-sets.index", $campaign["id"]) }}';
        }
    </script>
</body>
</html>
