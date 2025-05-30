# BENTA.PH - Online Shopping Platform

A simple online ordering system for affordable products built with PHP and MySQL.

## Features

**Customer:**
- User registration and login
- Browse products by category
- Shopping cart with quantity validation
- Order placement and tracking

**Admin:**
- Product and category management
- Order processing (approve/cancel/complete)
- Dashboard with transaction overview

## Tech Stack

- **Frontend:** HTML, CSS, Bootstrap 5, JavaScript
- **Backend:** PHP
- **Database:** MySQL

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/benta-ph.git
   ```

2. **Set up database**
   - Create MySQL database named `dbbenta`
   - Import `dbbenta.sql` file

3. **Configure web server**
   - Place project in `htdocs` (XAMPP) or `www` (WAMP)
   - Access via `localhost/benta-ph`

## Requirements

- PHP 7+
- MySQL 5.6+
- Web server (Apache/Nginx)

## Project Structure

```
benta-ph/
├── admin/          # Admin panel
├── users/          # Customer interface  
├── uploads/        # Product images
├── index.php       # Main page
└── dbbenta.sql     # Database file
```
