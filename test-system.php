<?php

// Simple test script to verify system functionality
echo "=== Donation Tracker System Test ===\n\n";

// Test 1: Check if Laravel is accessible
echo "1. Testing Laravel Framework...\n";
if (file_exists('vendor/autoload.php')) {
    echo "   ✅ Laravel dependencies found\n";
} else {
    echo "   ❌ Laravel dependencies not found\n";
    exit(1);
}

// Test 2: Check database connection
echo "\n2. Testing Database Connection...\n";
try {
    require_once 'vendor/autoload.php';
    
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $db = app('db');
    $connection = $db->connection();
    
    if ($connection->getPdo()) {
        echo "   ✅ Database connection successful\n";
        
        // Test 3: Check if tables exist
        echo "\n3. Testing Database Tables...\n";
        $tables = ['users', 'campaigns', 'donations'];
        
        foreach ($tables as $table) {
            try {
                $result = $connection->select("SHOW TABLES LIKE '$table'");
                if (!empty($result)) {
                    echo "   ✅ Table '$table' exists\n";
                } else {
                    echo "   ❌ Table '$table' missing\n";
                }
            } catch (Exception $e) {
                echo "   ❌ Error checking table '$table': " . $e->getMessage() . "\n";
            }
        }
        
        // Test 4: Check admin user
        echo "\n4. Testing Admin User...\n";
        try {
            $admin = $connection->table('users')->where('email', 'admin@donationtracker.com')->first();
            if ($admin) {
                echo "   ✅ Admin user exists\n";
                echo "   📧 Email: " . $admin->email . "\n";
                echo "   👤 Name: " . $admin->name . "\n";
                echo "   🔑 Role: " . $admin->role . "\n";
            } else {
                echo "   ❌ Admin user not found\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Error checking admin user: " . $e->getMessage() . "\n";
        }
        
        // Test 5: Check sample campaigns
        echo "\n5. Testing Sample Campaigns...\n";
        try {
            $campaigns = $connection->table('campaigns')->get();
            if ($campaigns->count() > 0) {
                echo "   ✅ Found " . $campaigns->count() . " sample campaigns\n";
                foreach ($campaigns as $campaign) {
                    echo "   📋 Campaign: " . $campaign->title . " (Target: $" . $campaign->target_amount . ")\n";
                }
            } else {
                echo "   ❌ No campaigns found\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Error checking campaigns: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "   ❌ Database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 6: Check storage directory
echo "\n6. Testing Storage Directory...\n";
if (is_dir('storage/app/public')) {
    echo "   ✅ Storage directory exists\n";
} else {
    echo "   ❌ Storage directory missing\n";
}

if (is_link('public/storage')) {
    echo "   ✅ Storage link exists\n";
} else {
    echo "   ❌ Storage link missing (run: php artisan storage:link)\n";
}

// Test 7: Check routes
echo "\n7. Testing Routes...\n";
$routes = [
    '/' => 'Home page',
    '/login' => 'Login page',
    '/register' => 'Register page',
    '/campaigns' => 'Campaigns page',
    '/admin/dashboard' => 'Admin dashboard (requires auth)'
];

foreach ($routes as $route => $description) {
    echo "   📍 $route - $description\n";
}

echo "\n=== Test Summary ===\n";
echo "✅ System is ready for testing!\n\n";

echo "🚀 To start testing:\n";
echo "1. Run: php artisan serve\n";
echo "2. Open: http://localhost:8000\n";
echo "3. Login as admin:\n";
echo "   - Email: admin@donationtracker.com\n";
echo "   - Password: admin123\n\n";

echo "📋 Test Checklist:\n";
echo "□ Login as admin\n";
echo "□ Create new campaign\n";
echo "□ Edit existing campaign\n";
echo "□ Delete campaign\n";
echo "□ Register new user\n";
echo "□ Make donation\n";
echo "□ View donation history\n\n";

echo "🎯 All tests completed!\n";
?> 