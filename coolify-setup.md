# Coolify Deployment Guide

## Environment Variables Setup

In your Coolify application settings, add these environment variables:

### Required Environment Variables

```
DB_HOST=your-database-host
DB_DATABASE=notes_app
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
DB_PORT=3306
APP_ENV=production
```

## Database Setup in Coolify

1. **Create a MySQL Service** in Coolify:
   - Go to your Coolify dashboard
   - Create a new MySQL service
   - Note the connection details (host, username, password)

2. **Connect with TablePlus**:
   - Host: Use the database host from Coolify
   - Port: Usually 3306 (check your Coolify MySQL service)
   - Database: `notes_app`
   - Username: From your Coolify MySQL service
   - Password: From your Coolify MySQL service

3. **Import Database Schema**:
   - Connect to your database with TablePlus
   - Run the SQL commands from `database.sql` to create tables

## Application Deployment

1. **Connect Repository**: Link your Git repository to Coolify
2. **Set Environment Variables**: Add all the database variables listed above
3. **Deploy**: Coolify will automatically deploy your application

## File Structure for Production

Make sure these files are in your repository:
- `config/database.php` (now supports environment variables)
- All your PHP files
- `database.sql` (for manual database setup)
- `.env.example` (template for environment variables)

## Troubleshooting

### Database Connection Issues
- Check that your environment variables are correctly set in Coolify
- Verify database service is running in Coolify dashboard
- Test connection with TablePlus using the same credentials

### Session Issues
- Fixed: `session_start()` now runs before any HTML output
- Ensure your server has session support enabled

### File Permissions
- Coolify usually handles this automatically
- If issues persist, check that PHP can write to session directories

## TablePlus Connection Example

Once your database is set up in Coolify:

1. Open TablePlus
2. Create new connection (MySQL)
3. Fill in the details from your Coolify MySQL service:
   - **Name**: NotesApp Database
   - **Host**: [from Coolify dashboard]
   - **Port**: 3306 (or custom port)
   - **User**: [from Coolify dashboard]
   - **Password**: [from Coolify dashboard]
   - **Database**: notes_app

4. Test connection and import the schema from `database.sql`

Your application should now be running on Coolify with proper database connectivity!
