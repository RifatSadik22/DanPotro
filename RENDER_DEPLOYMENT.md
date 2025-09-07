# Render Deployment Guide for Laravel Donation Tracker

This guide will help you deploy your Laravel 10 donation tracker application to Render.

## Prerequisites

1. A Render account (sign up at https://render.com)
2. Your Laravel project pushed to a Git repository (GitHub, GitLab, or Bitbucket)

## Deployment Steps

### 1. Create a New Web Service on Render

1. Log in to your Render dashboard
2. Click "New +" and select "Web Service"
3. Connect your Git repository
4. Choose the branch you want to deploy (usually `main` or `master`)

### 2. Configure Build Settings

**Build Command:**
```bash
composer install --no-dev --optimize-autoloader
```

**Start Command:**
```bash
vendor/bin/heroku-php-apache2 public/
```

### 3. Environment Variables

Set the following environment variables in your Render dashboard:

**Required Variables:**
- `APP_NAME`: Your application name (e.g., "Donation Tracker")
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `APP_URL`: `https://your-app-name.onrender.com` (replace with your actual Render URL)
- `APP_KEY`: Leave empty (will be generated automatically)

**Database Variables:**
- `DATABASE_URL`: Will be automatically provided by Render when you add a PostgreSQL database
- `DB_CONNECTION`: `pgsql`

**Optional Variables:**
- `FILESYSTEM_DISK`: `public`
- `LOG_LEVEL`: `error` (for production)

### 4. Add PostgreSQL Database

1. In your Render dashboard, click "New +" and select "PostgreSQL"
2. Choose a name for your database
3. Select the free tier (if available) or paid plan
4. Once created, copy the `DATABASE_URL` from the database settings
5. Add the `DATABASE_URL` to your web service environment variables

### 5. Deploy

1. Click "Create Web Service" to start the deployment
2. Render will automatically:
   - Install PHP dependencies via Composer
   - Generate application key
   - Create storage symlink
   - Run database migrations
   - Cache configuration, routes, and views
   - Start the web server

### 6. Verify Deployment

1. Once deployment is complete, visit your Render URL
2. Check that the application loads correctly
3. Test database connectivity by creating a test campaign or donation
4. Verify file uploads work (if your app has file upload functionality)

## Configuration Files Updated

The following files have been updated for Render deployment:

### `.env.example`
- Set production defaults
- Added `DATABASE_URL` support
- Configured for PostgreSQL

### `composer.json`
- Added `post-install-cmd` scripts for automatic deployment tasks
- Confirmed PHP 8.1+ requirement

### `config/database.php`
- Changed default connection to PostgreSQL
- Added `DATABASE_URL` parsing for Render's PostgreSQL connection

### `config/filesystems.php`
- Changed default filesystem disk to `public`

### `Procfile`
- Created for Render's web server configuration

## Troubleshooting

### Common Issues

1. **Application Key Error**
   - The `post-install-cmd` script should generate this automatically
   - If it fails, manually set `APP_KEY` in environment variables

2. **Database Connection Error**
   - Ensure `DATABASE_URL` is set correctly
   - Check that PostgreSQL database is running
   - Verify database credentials

3. **Storage Link Error**
   - The `storage:link` command is included in post-install scripts
   - If files aren't accessible, check the symlink was created

4. **Migration Errors**
   - Check database permissions
   - Ensure all migration files are committed to Git
   - Review migration logs in Render dashboard

### Logs

- View application logs in the Render dashboard under "Logs" tab
- Check for any error messages during build or runtime

## Performance Optimization

The deployment includes several optimizations:
- Configuration caching (`config:cache`)
- Route caching (`route:cache`)
- View caching (`view:cache`)
- Optimized Composer autoloader

## Security Notes

- `APP_DEBUG` is set to `false` for production
- Application key is generated automatically
- Database credentials are managed by Render
- All sensitive data should be in environment variables

## Next Steps

After successful deployment:
1. Set up a custom domain (if needed)
2. Configure SSL (handled automatically by Render)
3. Set up monitoring and alerts
4. Configure backup strategies for your database
5. Set up CI/CD for automatic deployments

## Support

If you encounter issues:
1. Check the Render documentation: https://render.com/docs
2. Review Laravel deployment guides
3. Check the application logs in Render dashboard
4. Verify all environment variables are set correctly
