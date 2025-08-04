# Donation Tracker System

A comprehensive donation tracking website built with Laravel 10, featuring user authentication, campaign management, and donation processing.

## 🚀 Features

### ✅ Completed Features (Sprint 1)
- **User Authentication System**
  - User registration and login
  - Admin login (hardcoded credentials)
  - Role-based access control (User/Admin)
  - Secure logout functionality

- **Campaign Management (Admin Only)**
  - Create new campaigns with images
  - Edit existing campaigns
  - Delete campaigns
  - Campaign status management (Active/Completed/Cancelled)

- **Donation System**
  - Users can make donations to campaigns
  - Donation tracking and history
  - Campaign progress tracking
  - Real-time donation updates

- **Database Integration**
  - MySQL database with proper relationships
  - Migrations for all tables
  - Seeders for sample data
  - Foreign key constraints

## 🛠️ Technical Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: HTML, CSS (Light Blue, White, Ash color scheme)
- **Architecture**: MVC (Model-View-Controller)
- **Authentication**: Laravel's built-in authentication
- **File Storage**: Laravel Storage for campaign images

## 📋 Database Schema

### Tables
1. **users** - User accounts with role-based access
2. **campaigns** - Campaign information and progress
3. **donations** - Donation records linked to users and campaigns

### Relationships
- User has many Donations
- Campaign has many Donations
- Donation belongs to User and Campaign

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2+
- MySQL 5.7+
- Composer
- XAMPP/WAMP (for local development)

### Installation Steps

1. **Clone/Download the project**
   ```bash
   cd donation-tracker-v1
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure database**
   - Update `.env` file with your MySQL credentials
   - Ensure MySQL is running

4. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Create storage link**
   ```bash
   php artisan storage:link
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - Open: http://localhost:8000

## 👤 Default Admin Account

- **Email**: admin@donationtracker.com
- **Password**: admin123

## 🧪 Testing the System

### 1. Admin Features Testing

#### Login as Admin
1. Go to http://localhost:8000/login
2. Use admin credentials:
   - Email: `admin@donationtracker.com`
   - Password: `admin123`
3. You should be redirected to the admin dashboard

#### Create New Campaign
1. From admin dashboard, click "Create New Campaign"
2. Fill in the form:
   - Title: "Test Campaign"
   - Description: "This is a test campaign"
   - Target Amount: 10000
   - End Date: Select a future date
   - Image: Upload an image (optional)
3. Click "Create Campaign"
4. Verify the campaign appears in the admin dashboard

#### Edit Campaign
1. From admin dashboard, click "Edit" on any campaign
2. Modify the details
3. Click "Update Campaign"
4. Verify changes are saved

#### Delete Campaign
1. From admin dashboard, click "Delete" on any campaign
2. Confirm deletion
3. Verify campaign is removed

### 2. User Features Testing

#### Register New User
1. Go to http://localhost:8000/register
2. Fill in the registration form
3. Verify account is created and you're logged in

#### Browse Campaigns
1. Go to http://localhost:8000/campaigns
2. View all active campaigns
3. Click on a campaign to see details

#### Make Donation
1. Login as a user
2. Go to a campaign page
3. Fill in the donation form:
   - Your Name: Your name
   - Donation Amount: 100
   - Message: "Test donation" (optional)
4. Click "Make Donation"
5. Verify donation is recorded

#### View Donation History
1. Login as a user
2. Go to your dashboard
3. View your donation history
4. Verify amounts and campaign details

### 3. Database Verification

#### Check MySQL Tables
```sql
-- Check if tables exist
SHOW TABLES;

-- Check users table
SELECT * FROM users;

-- Check campaigns table
SELECT * FROM campaigns;

-- Check donations table
SELECT * FROM donations;

-- Check relationships
SELECT 
    d.id,
    u.name as donor_name,
    c.title as campaign_title,
    d.amount,
    d.created_at
FROM donations d
JOIN users u ON d.user_id = u.id
JOIN campaigns c ON d.campaign_id = c.id;
```

## 🎨 Design Features

- **Color Scheme**: Light Blue (#87CEEB), White, Ash (#f8fafc)
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Modern UI**: Clean cards, gradients, hover effects
- **Progress Bars**: Visual campaign progress tracking
- **Status Indicators**: Color-coded status badges

## 🔒 Security Features

- **Authentication**: Laravel's secure authentication system
- **Authorization**: Role-based access control
- **Validation**: Server-side form validation
- **CSRF Protection**: Built-in CSRF token protection
- **File Upload Security**: Image validation and secure storage

## 📁 Project Structure

```
donation-tracker-v1/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── CampaignController.php
│   │   └── DonationController.php
│   ├── Http/Middleware/
│   │   └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Campaign.php
│       └── Donation.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   ├── auth/
│   ├── user/
│   ├── admin/
│   └── campaigns/
└── routes/
    └── web.php
```

## 🚀 Future Enhancements (Next Sprints)

- Payment gateway integration
- Email notifications
- Campaign categories
- Advanced reporting
- User profiles
- Social media sharing
- Mobile app

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check MySQL is running
   - Verify database credentials in `.env`
   - Ensure database exists

2. **Migration Errors**
   - Run `php artisan migrate:fresh --seed`
   - Check for syntax errors in migration files

3. **File Upload Issues**
   - Ensure `storage` directory is writable
   - Run `php artisan storage:link`
   - Check file permissions

4. **Admin Access Issues**
   - Verify admin user exists in database
   - Check AdminMiddleware is registered
   - Ensure user has 'admin' role

## 📞 Support

For issues or questions, please check:
1. Laravel documentation
2. Database logs
3. Laravel logs in `storage/logs/`

---

**Built with ❤️ using Laravel 10**
