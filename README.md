### Basic Setup

-   Add APP_NAME in .env file
    -   This will be the name of the application shown in the title and footer of the application
-   Admin website setting for Logo (dark and light) and Favicons from admin panel (App Setting menu)
    -   Light Logo should be 369x222 pixels
    -   Dark Logo should be 222x133 pixels
    -   Favicon should be 270x270 pixels

### Create Admin

php artisan make:admin "username" "email" "role" "your_password"

role - enum('superadmin', 'customersupport', 'viewer')
