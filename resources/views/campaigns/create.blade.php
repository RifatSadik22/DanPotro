<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign - Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #87CEEB 0%, #f8fafc 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .back-link:hover {
            color: #2563eb;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #64748b;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .form-textarea {
            height: 120px;
            resize: vertical;
        }

        .form-select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            transition: border-color 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: border-color 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .file-upload-area.dragover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .file-input {
            display: none;
        }

        .upload-text {
            color: #64748b;
            margin-top: 0.5rem;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .form-help {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .required {
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.campaigns.index') }}" class="back-link">
            ← Back to Campaigns
        </a>

        <div class="form-container">
            <div class="form-header">
                <h1>Create New Campaign</h1>
                <p>Fill in the details below to create a new fundraising campaign</p>
            </div>

            <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" id="campaignForm">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Campaign Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-input" 
                           value="{{ old('title') }}" required maxlength="255">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Choose a compelling title that describes your campaign</div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Campaign Description <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-input form-textarea" 
                              required minlength="10">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Provide detailed information about your campaign, its goals, and impact</div>
                </div>

                <div class="form-group">
                    <label for="target_amount" class="form-label">Target Amount ($) <span class="required">*</span></label>
                    <input type="number" id="target_amount" name="target_amount" class="form-input" 
                           value="{{ old('target_amount') }}" required min="1" max="9999999.99" step="0.01">
                    @error('target_amount')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Set a realistic fundraising goal for your campaign</div>
                </div>

                <div class="form-group">
                    <label for="end_date" class="form-label">End Date <span class="required">*</span></label>
                    <input type="date" id="end_date" name="end_date" class="form-input" 
                           value="{{ old('end_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('end_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Choose when your campaign should end</div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Campaign Status <span class="required">*</span></label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Set the initial status of your campaign</div>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Campaign Image</label>
                    <div class="file-upload-area" onclick="document.getElementById('image').click()">
                        <div>📸</div>
                        <div>Click to upload an image</div>
                        <div class="upload-text">JPEG, PNG, JPG, GIF up to 2MB</div>
                    </div>
                    <input type="file" id="image" name="image" class="file-input" 
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Upload an image that represents your campaign (optional)</div>
                    <img id="imagePreview" class="preview-image" style="display: none;">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Create Campaign
                    </button>
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Drag and drop functionality
        const uploadArea = document.querySelector('.file-upload-area');
        const fileInput = document.getElementById('image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadArea.classList.add('dragover');
        }

        function unhighlight(e) {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        }

        // Form validation
        document.getElementById('campaignForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const targetAmount = document.getElementById('target_amount').value;
            const endDate = document.getElementById('end_date').value;
            const status = document.getElementById('status').value;

            if (!title || !description || !targetAmount || !endDate || !status) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return;
            }

            if (description.length < 10) {
                e.preventDefault();
                alert('Description must be at least 10 characters long.');
                return;
            }

            if (parseFloat(targetAmount) < 1) {
                e.preventDefault();
                alert('Target amount must be at least $1.00.');
                return;
            }

            const today = new Date();
            const selectedDate = new Date(endDate);
            if (selectedDate <= today) {
                e.preventDefault();
                alert('End date must be in the future.');
                return;
            }
        });

        // Set minimum date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const minDate = tomorrow.toISOString().split('T')[0];
        document.getElementById('end_date').setAttribute('min', minDate);
    </script>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    @if(session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
</body>
</html>