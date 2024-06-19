---
# Voter Online Web Application

Welcome to the Voter Online Web Application. This web application is designed to facilitate online voting. It is built using HTML, CSS, JavaScript, PHP, and MySQL, and it runs on the XAMPP server. Below is the detailed information on how to set up and use this application.
-----
![Screenshot 2024-02-08 224356](https://github.com/Neharsputhran/Voter-Online-Web-Application/assets/109666034/48034a2f-6e0b-48cf-9043-4b1f7df59601)
-----
## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Setup Instructions](#setup-instructions)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [License](#license)

## Features
- User registration and authentication
- Candidate registration
- Voting system with secure vote submission
- Admin panel for managing users and candidates
- Real-time vote counting and results display

## Technologies Used
- **HTML**: Structure of the web pages
- **CSS**: Styling of the web pages
- **JavaScript**: Client-side scripting
- **PHP**: Server-side scripting
- **MySQL**: Database management
- **XAMPP**: Local server environment

## Setup Instructions
To set up the Voter Online Web Application on your local machine, follow these steps:

1. **Download and Install XAMPP**:
   - Download XAMPP from [Apache Friends](https://www.apachefriends.org/index.html).
   - Install XAMPP on your local machine.

2. **Clone the Repository**:
   - Clone this repository to your local machine or download the zip file and extract it.

3. **Copy Files to XAMPP Directory**:
   - Copy the application files to the `htdocs` directory inside your XAMPP installation folder (e.g., `C:\xampp\htdocs\`).

4. **Start XAMPP**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL modules.

5. **Create Database**:
   - Open your web browser and go to `http://localhost/phpmyadmin`.
   - Create a new database named `voteronline`.
   - Import the SQL file provided in the `database` folder of this repository to set up the necessary tables.

6. **Configure Database Connection**:
   - Open the `config.php` file in the project directory.
   - Update the database credentials (hostname, username, password, database name) to match your local setup.

## Usage
1. **Access the Application**:
   - Open your web browser and navigate to `http://localhost/voteronline`.

2. **User Registration and Login**:
   - Register a new user account or log in using existing credentials.

3. **Admin Panel**:
   - Access the admin panel to manage users and candidates by logging in as an admin.

4. **Voting**:
   - Registered users can view the list of candidates and cast their votes.

5. **View Results**:
   - Admin can view real-time voting results on the results page.

## Folder Structure
- `css/`: Contains CSS files for styling the web pages.
- `js/`: Contains JavaScript files for client-side scripting.
- `api/`: Contains PHP files for server-side logic.
- `connect.php`: Configuration file for database connection.
---
## License
This project is licensed under the MIT License. See the LICENSE file for details.
---
Thank you for using the Voter Online Web Application! If you have any questions or need further assistance, please feel free to contact us.
