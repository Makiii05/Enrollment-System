# Deployment Guide & Release Notes

## Enrollment Management System

**Version:** 1.0.0  
**Release Date:** January 26, 2026  
**Document Version:** 1.0

---

## Table of Contents

1. [Release Notes](#release-notes)
2. [System Requirements](#system-requirements)
3. [Pre-Deployment Checklist](#pre-deployment-checklist)
4. [Deployment Instructions](#deployment-instructions)
5. [Post-Deployment Verification](#post-deployment-verification)
6. [Rollback Procedures](#rollback-procedures)
7. [Troubleshooting](#troubleshooting)

---

## Release Notes

### Version 1.0.0 - Initial Release

**Release Date:** January 26, 2026

#### 🎉 New Features

##### Core Modules

- **Department Management** - Create, update, and manage academic departments
- **Program Management** - Full CRUD operations for academic programs linked to departments
- **Curriculum Management** - Define and manage academic curricula per program
- **Subject Management** - Comprehensive subject catalog with lecture/lab hours tracking
- **Prospectus Management** - Assign subjects to year levels and academic terms
- **Level Management** - Configure year/grade levels per program
- **Academic Term Management** - Semester and term configuration

##### Admission Module

- **Applicant Management** - Online application submission and tracking
- **Schedule Management** - Interview and examination scheduling with proctor assignment
- **Admission Processing** - Complete admission workflow (Application → Interview → Exam → Evaluation)

##### Student Records Module

- **Student Profiles** - Comprehensive student information management
- **Student Contacts** - Contact information storage
- **Guardian Information** - Parent/guardian details management
- **Academic History** - Track student academic progression

##### Financial Module

- **Fee Management** - Configure tuition and miscellaneous fees by program

##### Dashboard & Analytics

- **Statistics Overview** - Key metrics dashboard widgets
- **Enrollees Chart** - Visual enrollment trend analytics

##### User Experience

- **Role-Based Access Control** - Registrar, Admission, and Accounting panels
- **Advanced Search** - Full-text search across all modules
- **Custom Theme** - Modern, responsive Filament-based UI
- **Mobile Responsive** - Adaptive layouts for all devices

#### 🔧 Technical Stack

- Laravel 12.0 with PHP 8.2+
- Filament 4.0 Admin Panel
- Tailwind CSS 4.1.17 with DaisyUI
- Vite 7.0.7 Build System
- MySQL Database

#### 🐛 Known Issues

- **BUG-PROS-001**: Validation type mismatch for department field in prospectus search (Low severity - workaround available)

#### 📊 Test Coverage

- 10 automated test cases (5 Unit, 5 Integration)
- 100% pass rate
- 38 total assertions

---

## System Requirements

### Server Requirements

| Component      | Minimum                 | Recommended |
| -------------- | ----------------------- | ----------- |
| **PHP**        | 8.2                     | 8.3+        |
| **MySQL**      | 8.0                     | 8.0+        |
| **Node.js**    | 18.x                    | 20.x LTS    |
| **NPM**        | 9.x                     | 10.x        |
| **Composer**   | 2.6+                    | 2.7+        |
| **Web Server** | Apache 2.4 / Nginx 1.20 | Nginx 1.24+ |
| **RAM**        | 2GB                     | 4GB+        |
| **Storage**    | 10GB                    | 20GB+       |

### PHP Extensions Required

```
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- ZIP
```

### Browser Compatibility

| Browser | Minimum Version |
| ------- | --------------- |
| Chrome  | 90+             |
| Firefox | 88+             |
| Safari  | 14+             |
| Edge    | 90+             |

---

## Pre-Deployment Checklist

### Environment Preparation

- [ ] Server meets minimum system requirements
- [ ] PHP extensions installed and enabled
- [ ] MySQL database server running
- [ ] Node.js and NPM installed
- [ ] Composer installed globally
- [ ] SSL certificate configured (for HTTPS)
- [ ] Domain/subdomain DNS configured

### Application Preparation

- [ ] `.env` file configured with production settings
- [ ] Database credentials verified
- [ ] Application key generated
- [ ] Mail server configured (if applicable)
- [ ] Storage directories have proper permissions
- [ ] Cache directories writable

### Security Checklist

- [ ] `APP_DEBUG` set to `false`
- [ ] `APP_ENV` set to `production`
- [ ] Strong `APP_KEY` generated
- [ ] Database user has limited privileges
- [ ] Firewall rules configured
- [ ] Rate limiting enabled

---

## Deployment Instructions

### Option 1: Fresh Installation

#### Step 1: Clone Repository

```bash
# Clone the repository
git clone https://github.com/your-org/enrollment-system.git
cd enrollment-system
```

#### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
npm ci
```

#### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` file with production settings:

```env
APP_NAME="Enrollment Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=enrollment_system
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

#### Step 4: Build Assets

```bash
# Build production assets
npm run build
```

#### Step 5: Database Setup

```bash
# Run migrations
php artisan migrate --force

# (Optional) Seed initial data
php artisan db:seed --force
```

#### Step 6: Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Cache Filament components
php artisan filament:cache-components

# Generate Filament icons
php artisan icons:cache
```

#### Step 7: Set Permissions

```bash
# Set storage permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (adjust user/group as needed)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

#### Step 8: Web Server Configuration

##### Nginx Configuration

```nginx
server {
    listen 80;
    listen 443 ssl http2;
    server_name your-domain.com;
    root /var/www/enrollment-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    ssl_certificate /etc/ssl/certs/your-domain.crt;
    ssl_certificate_key /etc/ssl/private/your-domain.key;
}
```

##### Apache Configuration (.htaccess)

The default `.htaccess` in `/public` should work. Ensure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Step 9: Create Admin User

```bash
# Create initial admin user
php artisan make:filament-user
```

---

### Option 2: Update Existing Installation

#### Step 1: Enable Maintenance Mode

```bash
php artisan down --secret="your-bypass-token"
```

#### Step 2: Backup Current State

```bash
# Backup database
mysqldump -u username -p enrollment_system > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup application files (optional)
tar -czvf app_backup_$(date +%Y%m%d_%H%M%S).tar.gz --exclude=vendor --exclude=node_modules .
```

#### Step 3: Pull Latest Changes

```bash
git pull origin main
```

#### Step 4: Update Dependencies

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

#### Step 5: Run Migrations

```bash
php artisan migrate --force
```

#### Step 6: Clear and Rebuild Cache

```bash
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

#### Step 7: Disable Maintenance Mode

```bash
php artisan up
```

---

### Option 3: Docker Deployment

#### Docker Compose Configuration

Create `docker-compose.yml`:

```yaml
version: "3.8"

services:
    app:
        build:
            context: .
            dockerfile: Dockerfile
        container_name: enrollment-app
        restart: unless-stopped
        volumes:
            - ./storage:/var/www/html/storage
            - ./bootstrap/cache:/var/www/html/bootstrap/cache
        environment:
            - APP_ENV=production
            - APP_DEBUG=false
        depends_on:
            - mysql
        networks:
            - enrollment-network

    nginx:
        image: nginx:alpine
        container_name: enrollment-nginx
        restart: unless-stopped
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - ./nginx.conf:/etc/nginx/conf.d/default.conf
            - ./public:/var/www/html/public
        depends_on:
            - app
        networks:
            - enrollment-network

    mysql:
        image: mysql:8.0
        container_name: enrollment-mysql
        restart: unless-stopped
        environment:
            MYSQL_DATABASE: enrollment_system
            MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
            MYSQL_USER: ${DB_USERNAME}
            MYSQL_PASSWORD: ${DB_PASSWORD}
        volumes:
            - mysql-data:/var/lib/mysql
        networks:
            - enrollment-network

volumes:
    mysql-data:

networks:
    enrollment-network:
        driver: bridge
```

#### Deploy with Docker

```bash
# Build and start containers
docker-compose up -d --build

# Run migrations
docker-compose exec app php artisan migrate --force

# Create admin user
docker-compose exec app php artisan make:filament-user
```

---

## Post-Deployment Verification

### Automated Health Checks

Run the following commands to verify deployment:

```bash
# Check application status
php artisan about

# Verify database connection
php artisan db:show

# Run automated tests
php artisan test --filter=ProspectusController
```

### Manual Verification Checklist

| Check             | URL/Action               | Expected Result     |
| ----------------- | ------------------------ | ------------------- |
| Homepage loads    | `/`                      | Redirect to login   |
| Login page        | `/registrar/login`       | Login form displays |
| Admin login       | Enter credentials        | Dashboard loads     |
| Department list   | `/registrar/departments` | Table with data     |
| Create department | Click "New Department"   | Form displays       |
| Save department   | Submit form              | Record created      |
| Search function   | Use search bar           | Results filter      |
| Mobile view       | Resize browser           | Responsive layout   |

### Performance Baseline

| Metric              | Target      | Measurement Tool     |
| ------------------- | ----------- | -------------------- |
| Page Load Time      | < 2 seconds | Browser DevTools     |
| Time to First Byte  | < 500ms     | curl or Lighthouse   |
| Database Query Time | < 100ms avg | Laravel Debugbar     |
| Memory Usage        | < 128MB     | `memory_get_usage()` |

---

## Rollback Procedures

### Quick Rollback (Last Deployment)

```bash
# Enable maintenance mode
php artisan down

# Restore previous version
git checkout HEAD~1

# Restore database (if migrations were run)
mysql -u username -p enrollment_system < backup_YYYYMMDD_HHMMSS.sql

# Reinstall dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Clear cache
php artisan cache:clear
php artisan config:cache

# Disable maintenance mode
php artisan up
```

### Full Rollback (Specific Version)

```bash
# Find the commit to rollback to
git log --oneline

# Checkout specific version
git checkout <commit-hash>

# Follow quick rollback steps above
```

---

## Troubleshooting

### Common Issues and Solutions

#### Issue: 500 Internal Server Error

**Symptoms:** White screen or generic error page

**Solutions:**

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify file permissions on storage and cache directories
3. Check `.env` file exists and is properly formatted
4. Run `php artisan config:clear`

```bash
# Check logs
tail -100 storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache
```

#### Issue: Database Connection Failed

**Symptoms:** SQLSTATE connection error

**Solutions:**

1. Verify database credentials in `.env`
2. Check MySQL service is running
3. Verify database exists
4. Check firewall allows MySQL port

```bash
# Test MySQL connection
mysql -h localhost -u db_user -p -e "SHOW DATABASES;"

# Check MySQL service
sudo systemctl status mysql
```

#### Issue: Assets Not Loading (CSS/JS)

**Symptoms:** Unstyled page, broken layout

**Solutions:**

1. Run `npm run build`
2. Check `public/build` directory exists
3. Verify `APP_URL` in `.env` matches actual URL
4. Clear browser cache

```bash
# Rebuild assets
npm run build

# Check manifest
cat public/build/manifest.json
```

#### Issue: Session/Login Issues

**Symptoms:** Cannot login, session expires immediately

**Solutions:**

1. Check session driver configuration
2. Verify storage/framework/sessions is writable
3. Check cookie domain settings

```bash
# Clear session files
php artisan session:flush

# Check permissions
ls -la storage/framework/sessions
```

#### Issue: Filament Panel Not Loading

**Symptoms:** 404 on admin routes

**Solutions:**

1. Clear route cache: `php artisan route:clear`
2. Verify Filament service provider is registered
3. Check panel path configuration

```bash
# Clear all caches
php artisan optimize:clear

# Re-cache
php artisan filament:cache-components
```

---

## Support Information

### Log Locations

| Log Type            | Location                     |
| ------------------- | ---------------------------- |
| Application Logs    | `storage/logs/laravel.log`   |
| Web Server (Nginx)  | `/var/log/nginx/error.log`   |
| Web Server (Apache) | `/var/log/apache2/error.log` |
| PHP-FPM             | `/var/log/php8.2-fpm.log`    |
| MySQL               | `/var/log/mysql/error.log`   |

### Useful Commands

```bash
# View real-time logs
php artisan pail

# Check application status
php artisan about

# List all routes
php artisan route:list

# Run database query
php artisan tinker

# Clear all caches
php artisan optimize:clear
```

### Contact Information

For deployment assistance or critical issues:

- **Technical Support:** support@your-institution.edu
- **System Administrator:** admin@your-institution.edu
- **Emergency Hotline:** +1-XXX-XXX-XXXX

---

## Document History

| Version | Date             | Author           | Changes         |
| ------- | ---------------- | ---------------- | --------------- |
| 1.0     | January 26, 2026 | Development Team | Initial release |

---

_This document is part of the Enrollment Management System documentation suite._
