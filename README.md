# EdiCodes Website

This repository contains both the frontend and backend code for the EdiCodes website.

## Project Structure

- `edicodes/` - Frontend Vue.js application
- `back-end/` - Laravel backend API

## Setup Instructions

### Backend Setup (Laravel)

1. Navigate to the backend directory:
   ```bash
   cd back-end
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in `.env` and run migrations:
   ```bash
   php artisan migrate
   ```

6. Install frontend dependencies and build:
   ```bash
   npm install
   npm run build
   ```

### Frontend Setup (Vue.js)

1. Navigate to the frontend directory:
   ```bash
   cd edicodes
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Start the development server:
   ```bash
   npm run dev
   ```

## Development

- Backend API runs on: `http://localhost:8000`
- Frontend development server runs on: `http://localhost:3000`