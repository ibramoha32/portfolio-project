# Portfolio Deployment Guide - 000webhost

## Step-by-Step Deployment to 000webhost

### Step 1: Create 000webhost Account
1. Go to **https://www.000webhost.net/**
2. Click **"GET FREE & CHEAPEST CPANEL WEB HOSTING"**
3. Fill in registration form:
   - Email address (use real email)
   - Password (create strong password)
   - Security questions
4. Verify your email address

### Step 2: Access Your Hosting Control Panel
1. After signup, log in to your 000webhost dashboard
2. Look for **"cPanel"** or **"Control Panel"** link
3. This is where you'll manage your hosting

### Step 3: Upload Files via File Manager
1. In cPanel, find **"File Manager"** or **"File Explorer"**
2. Navigate to main directory (usually `public_html`)
3. Upload all project files:
   - `index.html`
   - `style.css`
   - `script.js`
   - `config.php`
   - `database.sql`
   - `api/` folder (with contact.php and projects.php)
   - `admin/` folder (with login.php, dashboard.php, logout.php)

### Step 4: Set Up MySQL Database
1. In cPanel, find **"MySQL Databases"** or **"Database Wizard"**
2. Create a new database named **`portfolio_db`**
3. Create a database user (or use default)
4. Note down your database credentials:
   - Database Host: Usually `localhost`
   - Database Name: `portfolio_db`
   - Database User: Your username
   - Database Password: Your password

### Step 5: Import Database
1. In cPanel, find **"phpMyAdmin"**
2. Select your `portfolio_db` database
3. Click **"Import"** tab
4. Choose `database.sql` file from your project
5. Click **"Go"** to import

### Step 6: Update Database Configuration
1. In File Manager, edit `config.php`
2. Update these lines with your actual database credentials:
   ```php
   define('DB_HOST', 'YOUR_DATABASE_HOST');
   define('DB_USER', 'YOUR_DATABASE_USER');
   define('DB_PASS', 'YOUR_DATABASE_PASSWORD');
   define('DB_NAME', 'portfolio_db');
   ```

### Step 7: Test Your Live Site
1. Visit your domain: `http://your-username.000webhostapp.com`
2. Test all features:
   - ✅ Homepage loads with animations
   - ✅ Contact form submits to database
   - ✅ Admin dashboard works (username: `admin`, password: `admin123`)
   - ✅ Projects load dynamically

### Step 8: Get Your Live Demo URL
Once everything works, your live demo URL will be:
`http://your-username.000webhostapp.com`

### 000webhost Features
- ✅ **Completely Free** - No credit card required
- ✅ **cPanel** - Professional control panel
- ✅ **PHP & MySQL** - Full backend support
- ✅ **File Manager** - Easy file uploads
- ✅ **SSL Certificate** - HTTPS support
- ✅ **Unlimited Bandwidth** - No traffic limits

### Troubleshooting
- **500 Error**: Check `config.php` database credentials
- **Database Error**: Verify database exists and user has permissions
- **404 Error**: Ensure files are in correct directory
- **Permission Denied**: Check file/folder permissions
- **White Screen**: Check PHP syntax errors

### Alternative: Use CrazyHost
If 000webhost is full, try the alternative mentioned:
- Go to **https://crazyhost.net/**
- Similar free cPanel hosting with PHP/MySQL

### Security Notes
- Change default admin password
- Keep database credentials private
- Use HTTPS when available
- Regular backups recommended

### Final Steps
1. Deploy to 000webhost
2. Test all functionality
3. Get live demo URL
4. Submit LMS package with live URL
