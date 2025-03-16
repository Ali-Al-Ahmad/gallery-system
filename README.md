# Personal Gallery System

A simple personal gallery application built with React (Vite) and PHP (MySQLi). Users can upload, view, and manage their images with descriptions and tags.

Live link: [http://52.47.202.106/](http://52.47.202.106/)

Database schema: [https://drawsql.app/teams/alialahmads-team/diagrams/gallery](https://drawsql.app/teams/alialahmads-team/diagrams/gallery)

## Features
- User authentication (register/login)
- Upload and manage images
- Add descriptions and tags
- Search and filter images

## Installation

### Backend

1. Clone the repository:
    ```bash
    git clone https://github.com/Ali-Al-Ahmad/gallery-system.git
    cd gallery-system/backend
    ```

2. Set up the database in `connection/connection.php`.

3. Run migrations:
    ```bash
    php database/migrations/migrate.php
    ```

4. Start the PHP server:
    ```bash
    php -S localhost:8000 -t public
    ```

### Frontend

1. Navigate to the frontend folder:
    ```bash
    cd ../frontend
    ```

2. Install dependencies and start the server:
    ```bash
    npm install
    npm run dev
    ```

## Contact

For questions, reach out at ali.alahmad.cs@gmail.com.
