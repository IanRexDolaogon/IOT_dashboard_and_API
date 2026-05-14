@echo off
echo ===================================================
echo     Smart Classroom IoT - Setup Script
echo ===================================================

echo [1/5] Installing PHP Dependencies (Composer)...
call composer install

echo [2/5] Installing Node.js Dependencies (NPM)...
call npm install

echo [3/5] Setting up Environment File...
if not exist .env (
    copy .env.example .env
    echo .env file created. Please configure your Mailtrap credentials inside.
) else (
    echo .env already exists.
)

echo [4/5] Generating Application Key...
call php artisan key:generate

echo [5/5] Running Database Migrations...
call php artisan migrate

echo ===================================================
echo   Setup Complete! 
echo   Run 'php artisan serve --host 0.0.0.0 --port 8000'
echo ===================================================
pause