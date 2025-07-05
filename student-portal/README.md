# Student Portal Web Application

## Overview
This is a simple student portal web application that allows students to log in, view their dashboard, and manage their profiles. The application is built using PHP and utilizes a MySQL database for data storage.

## File Structure
```
student-portal
├── components
│   ├── header.php
│   └── footer.php
├── config.php
├── pages
│   ├── dashboard.php
│   ├── home.php
│   ├── login.php
│   └── profile.php
├── public
│   └── index.php
├── styles
│   └── main.css
├── utils
│   └── auth.php
├── README.md
```

## Features
- **Home Page**: Provides an introduction to the student portal and links to the login and dashboard pages.
- **Login Page**: Allows users to log in using their email and password. Validates credentials against the database.
- **Dashboard/Profile Page**: Displays user information and allows users to update their profile details.
- **Consistent Header and Footer**: The application includes a header and footer that are consistent across all pages.

## Setup Instructions
1. **Clone the Repository**: Clone this repository to your local machine.
2. **Install XAMPP**: Ensure you have XAMPP installed and running on your machine.
3. **Create Database**: Create a MySQL database named `student_portal` and set up the necessary tables for user data.
4. **Configure Database**: Update the `config.php` file with your database credentials if necessary.
5. **Start XAMPP**: Start the Apache and MySQL services in XAMPP.
6. **Access the Application**: Open your web browser and navigate to `http://localhost/studentPortal/public/index.php`.

## Usage Guidelines
- Use the login page to access the dashboard.
- Update your profile information from the dashboard.
- Ensure to log out after finishing your session for security purposes.

## Author
This project was developed by [Your Name]. All rights reserved.