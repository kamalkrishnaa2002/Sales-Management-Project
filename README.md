Installation
Clone the Repository:

bash
Copy code
git clone https://github.com/kamalkrishnaa2002/Sales-Management-Project.git
cd Sales-Management-Project
Install Dependencies:

composer install
Create Environment File:

Copy the .env.example file and rename it to .env.
bash
cp .env.example .env
Configure Environment:

Open the .env file and update the database configuration with your details:

DB_HOST=your_database_host
DB_PORT=your_database_port
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
Generate Application Key:

Generate a new application key:
php artisan key:generate

Run Migrations:
Execute the following command to run migrations and set up the database schema:
php artisan migrate

Serve the Application:
php artisan serve

Accessing the Application:
Open your web browser and navigate to the URL provided by the php artisan serve command (usually http://localhost:8000) to start using the application.
