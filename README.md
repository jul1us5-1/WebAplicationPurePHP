Servissana
🚀 Technologies Used

Language: PHP

Database: MySQL

Dependency Manager: Composer

Server Environment: XAMPP (Apache)

Frontend: HTML, CSS, JavaScript

📋 Prerequisites

Before you begin, ensure you have the following installed on your machine:

XAMPP (for Apache and MySQL).

Composer.

Git.

🛠️ Installation & Setup Guide

Follow these steps to set up the project locally on your machine.

1. Clone the Repository
Navigate to your XAMPP htdocs folder and clone the project:

Bash

cd C:/xampp/htdocs
git clone https://github.com/YOUR_USERNAME/servissana-php.git
2. Install Dependencies
Navigate into the project folder and install the required PHP libraries using Composer:

Bash

cd servissana-php
composer install
3. Database Configuration
Open XAMPP Control Panel and start Apache and MySQL.

Go to http://localhost/phpmyadmin in your browser.

Create a new database named servissana_db.

Select the new database and click on the Import tab.

Choose the SQL file located at: db/servissana_db.sql (inside the project folder).

Click Go to import the tables.

Verify Connection: Ensure your database connection file (e.g., db.php or conexion.php) matches your local credentials:

Host: localhost

User: root

Password: (leave empty for default XAMPP)

Database: servissana_db

📧 Email Configuration (PHPMailer)
Para que el sistema pueda enviar correos electrónicos (como confirmaciones de registro), debes configurar tus credenciales en el archivo register_backend.php.

Abre register_backend.php.

Busca la sección de configuración de PHPMailer.

Reemplaza los siguientes valores con tu información:

$mail->Username = 'tu-correo@gmail.com';

$mail->Password = 'tu-contraseña-de-aplicación';

[!IMPORTANT]
No uses tu contraseña normal. Si usas Gmail, debes generar una "Contraseña de Aplicación" desde la configuración de seguridad de tu cuenta de Google (requiere tener activa la verificación en dos pasos).

🏃‍♂️ How to Run
Once everything is set up:

Ensure Apache and MySQL are running in XAMPP.

Open your web browser.

Important: The entry point of the application is the login page.

Navigate to the following URL:
http://localhost/servissana-php/login.php