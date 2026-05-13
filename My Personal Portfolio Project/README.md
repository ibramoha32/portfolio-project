# Full-Stack Portfolio Project

A comprehensive personal portfolio website built with HTML5, CSS3, JavaScript, PHP, and MySQL. This project demonstrates full-stack web development skills including client-side interactivity, server-side logic, database integration, and administrative functionality.

## Features

### Frontend
- **Responsive Design**: Mobile-first approach using CSS Flexbox and Grid
- **Dark Mode**: Toggle between light and dark themes with localStorage persistence
- **Interactive Navigation**: Smooth scrolling and mobile hamburger menu
- **Dynamic Content**: Projects loaded via AJAX without page refresh
- **Form Validation**: Real-time JavaScript validation for contact form

### Backend
- **Contact Form**: Messages saved to MySQL database via PHP
- **Admin Authentication**: Secure login system with session management
- **Project Management**: CRUD operations for projects via admin dashboard
- **Database Integration**: MySQL with proper indexing and relationships

### Technologies Used
- HTML5 (Semantic markup, forms, tables)
- CSS3 (Variables, Flexbox, Grid, animations, responsive design)
- JavaScript (DOM manipulation, AJAX, localStorage, event handling)
- PHP (Sessions, prepared statements, form handling)
- MySQL (Database design, CRUD operations)

## Project Structure

```
portfolio-project/
├── index.html              # Main portfolio page
├── style.css               # Stylesheets with CSS variables
├── script.js               # JavaScript interactivity
├── config.php              # Database configuration and helper functions
├── database.sql            # Database schema and sample data
├── api/
│   ├── contact.php         # Contact form handler
│   └── projects.php        # Projects API endpoint
├── admin/
│   ├── login.php           # Admin login page
│   ├── dashboard.php       # Admin dashboard for project management
│   └── logout.php          # Logout script
└── README.md               # This file
```

## Setup Instructions

### Prerequisites
- XAMPP, WAMP, or any PHP/MySQL server
- Web browser (Chrome, Firefox, etc.)
- Text editor or IDE

### Installation Steps

1. **Clone or Download the Project**
   - Extract the project folder to your server's web root (e.g., `htdocs` for XAMPP)

2. **Set Up the Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click on the "Import" tab
   - Select the `database.sql` file
   - Click "Go" to import the database schema and sample data

3. **Configure Database Connection**
   - Open `config.php`
   - Update the database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'portfolio_db');
   ```

4. **Start the Server**
   - Start Apache and MySQL in XAMPP/WAMP control panel

5. **Access the Portfolio**
   - Open your browser and navigate to: `http://localhost/portfolio-project/`

6. **Access Admin Dashboard**
   - Navigate to: `http://localhost/portfolio-project/admin/login.php`
   - Default credentials:
     - Username: `admin`
     - Password: `admin123`

## Usage Guide

### For Visitors
- Browse sections using the navigation menu
- Toggle dark mode using the moon/sun icon
- View projects dynamically loaded from the database
- Submit messages via the contact form (validated with JavaScript)

### For Administrators
1. **Login**: Use the admin link at the bottom of the page or navigate to `/admin/login.php`
2. **Manage Projects**: Add, edit, or delete projects from the dashboard
3. **View Messages**: See recent contact form submissions
4. **Logout**: Click the logout button when done

## Database Schema

### Users Table
- Stores admin credentials
- Passwords hashed with bcrypt
- Session-based authentication

### Projects Table
- Stores project information
- Fields: title, description, tags, link, image_url
- Supports CRUD operations

### Contacts Table
- Stores contact form submissions
- Fields: name, email, subject, message
- Timestamped entries

## Security Features

- **SQL Injection Prevention**: Prepared statements for all database queries
- **XSS Protection**: Input sanitization and output escaping
- **Password Security**: Bcrypt hashing for passwords
- **Session Management**: Secure session handling for admin authentication
- **CSRF Protection**: Form validation and proper HTTP methods

## Customization

### Personalize Content
- Edit `index.html` to update your name, bio, and contact information
- Modify `style.css` to change colors (update CSS variables)
- Add your own projects via the admin dashboard

### Default Admin Password
To change the default admin password:
1. Generate a new bcrypt hash using PHP's `password_hash()`
2. Update the password in the `users` table via phpMyAdmin
3. Or create a new admin user via the database

## Browser Compatibility
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Troubleshooting

### Database Connection Error
- Verify MySQL server is running
- Check database credentials in `config.php`
- Ensure database `portfolio_db` exists

### Projects Not Loading
- Check browser console for JavaScript errors
- Verify `api/projects.php` is accessible
- Ensure database has project records

### Contact Form Not Working
- Verify JavaScript validation is passing
- Check `api/contact.php` for errors
- Ensure database connection is working

## Submission Requirements

This project meets all course requirements:
- ✅ Semantic HTML5 structure
- ✅ CSS3 with Flexbox/Grid and responsive design
- ✅ JavaScript interactivity and DOM manipulation
- ✅ Form validation (client-side)
- ✅ PHP backend with database integration
- ✅ AJAX for dynamic content loading
- ✅ Session management and secure admin login
- ✅ CRUD operations for project management
- ✅ SQL export file included (`database.sql`)

## Future Enhancements
- Image upload functionality for projects
- Email notifications for new contact messages
- Blog section with dynamic content
- Multi-language support
- Analytics integration

## License
This project is for educational purposes. Feel free to use it as a template for your own portfolio.

## Credits
- Font Awesome for icons
- Google Fonts for typography
- Built as a course project for Web Programming

---

**Note**: You are responsible for every line of code in this repository. Ensure you understand how each feature works before submitting. Be prepared to explain the code during the technical Q&A session.
