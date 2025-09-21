# NotesApp - Modern Web Application

A beautiful and modern note-taking web application built with HTML, CSS, PHP, and MySQL.

## Features

- **User Authentication**: Secure login and registration system
- **Modern Design**: Clean, responsive UI with beautiful gradients and animations
- **Note Management**: Add, edit, delete, and view notes
- **Secure**: Password hashing, session management, and SQL injection protection
- **Responsive**: Works great on desktop, tablet, and mobile devices

## Screenshots

The application features a modern design with:
- Beautiful gradient backgrounds
- Clean card-based layouts
- Smooth animations and transitions
- FontAwesome icons
- Responsive grid system

## Setup Instructions

### Prerequisites

- XAMPP, WAMP, or similar local server environment
- Web browser
- MySQL database

### Installation

1. **Copy Files**: Place all files in your web server directory (e.g., `C:\xampp\htdocs\withdatabase\`)

2. **Database Setup**:
   - Start your MySQL server (through XAMPP Control Panel)
   - Open phpMyAdmin or MySQL command line
   - Run the SQL commands from `database.sql` to create the database and tables

3. **Database Configuration**:
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     $host = 'localhost';
     $dbname = 'notes_app';
     $username = 'root';  // Your MySQL username
     $password = '';      // Your MySQL password
     ```

4. **Access the Application**:
   - Start your web server (Apache through XAMPP)
   - Open your browser and navigate to: `http://localhost/withdatabase/`

### Demo Account

A demo account is included:
- **Username**: `demo`
- **Password**: `demo123`

### File Structure

```
withdatabase/
├── index.php              # Main entry point
├── login.php              # Login page
├── register.php           # Registration page
├── dashboard.php          # Main dashboard with notes
├── database.sql           # Database setup script
├── README.md             # This file
├── assets/
│   └── css/
│       └── style.css     # All CSS styles
├── auth/
│   ├── login_process.php    # Login logic
│   ├── register_process.php # Registration logic
│   └── logout.php          # Logout logic
├── config/
│   └── database.php        # Database connection
└── notes/
    ├── add_note.php        # Add note logic
    ├── edit_note.php       # Edit note page & logic
    └── delete_note.php     # Delete note logic
```

### Usage

1. **Registration**: Create a new account or use the demo account
2. **Login**: Sign in with your credentials
3. **Dashboard**: View all your notes and add new ones
4. **Add Notes**: Use the form at the top to add new notes
5. **Edit Notes**: Click the edit button on any note to modify it
6. **Delete Notes**: Click the delete button to remove notes (with confirmation)

### Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection protection with prepared statements
- Session management for user authentication
- Input validation and sanitization
- XSS protection with `htmlspecialchars()`

### Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Icons**: FontAwesome 6.0
- **Styling**: Custom CSS with modern design principles

### Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge

### Troubleshooting

1. **Database Connection Error**: Check your database credentials in `config/database.php`
2. **Permission Issues**: Ensure your web server has read/write permissions
3. **Session Issues**: Make sure session support is enabled in PHP
4. **CSS Not Loading**: Check file paths and server configuration

### Contributing

Feel free to fork this project and submit pull requests for any improvements!

### License

This project is open source and available under the MIT License.
