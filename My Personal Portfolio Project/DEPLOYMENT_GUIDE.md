# Portfolio Deployment Guide

## Free Hosting with InfinityFree

### Step 1: Create Account
1. Go to https://www.infinityfree.com/
2. Click "Sign Up"
3. Fill in:
   - Email address
   - Password
   - Security questions
4. Verify email address

### Step 2: Get Hosting Credentials
After signup, you'll receive:
- **FTP Host**: Usually `ftp.infinityfree.com`
- **FTP Username**: Your account username
- **FTP Password**: Your account password
- **MySQL Host**: Usually `localhost` or provided
- **MySQL Database**: Usually auto-created
- **MySQL Credentials**: Same as account credentials

### Step 3: Update Configuration
1. Open `config.php`
2. Update these lines:
   ```php
   define('DB_HOST', 'YOUR_MYSQL_HOST');
   define('DB_USER', 'YOUR_MYSQL_USER');
   define('DB_PASS', 'YOUR_MYSQL_PASSWORD');
   define('DB_NAME', 'YOUR_DATABASE_NAME');
   ```

### Step 4: Upload Files via FTP
**Option A: File Manager (Easier)**
1. Login to InfinityFree cPanel
2. Open "File Manager"
3. Upload all project files
4. Make sure `api/` and `admin/` folders are included

**Option B: FTP Client**
1. Use FileZilla or similar
2. Connect with provided FTP credentials
3. Upload entire project folder

### Step 5: Create Database
1. In cPanel, find "MySQL Databases"
2. Create database named `portfolio_db`
3. Create database user (if separate)
4. Grant permissions

### Step 6: Import Database
1. In cPanel, open "phpMyAdmin"
2. Select your database
3. Click "Import" tab
4. Upload `database.sql` file
5. Click "Go"

### Step 7: Test Your Live Site
1. Visit your domain: `http://your-username.infinityfree.com`
2. Test all features:
   - Contact form submission
   - Admin dashboard login
   - Dynamic project loading

### Troubleshooting
- **500 Error**: Check `config.php` database credentials
- **Database Error**: Verify database exists and user has permissions
- **404 Error**: Ensure files are in correct directory
- **Permission Denied**: Check file/folder permissions

### Alternative Hosting Options
If InfinityFree doesn't work, try:
- **FreeHosting.com**: Similar features
- **GitHub Pages**: For frontend only (no PHP)
- **Netlify**: For frontend only (no PHP)
- **Local Tunnel**: Use `ngrok` for temporary live demo

### Security Notes
- Change default admin password
- Keep database credentials private
- Use HTTPS if available
- Regular backups recommended
