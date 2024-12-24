# Food Tracking System

## Overview

The Food Tracking System is a comprehensive solution designed for managing e-commerce logistics, specifically focused on shipping and payment integrations. This project includes an admin control panel built with Filament, real-time shipping data updates using Livewire, and a factory design pattern implementation for multiple payment gateways (Stripe, PayPal, and Cash on Delivery).

## Features

### Admin Control Panel

-   Built with Filament for efficient management.
-   Features include:
    -   Adding and managing shipping zones.
    -   Adding countries and their available cities.
    -   Creating new Filament users with specific roles.
    -   Managing banners, featured products, and controlling the active/inactive status of products.
    -   Modifying banner text for the front-end display.

### Real-Time Shipping Calculator

-   Uses Livewire for dynamic and real-time shipping fee calculation.
-   Features:
    -   Calculates shipping fees based on selected country and city.
    -   Provides immediate feedback if shipping is unavailable for a location.
    -   Updates total cost with shipping fees in real time.

### Payment Gateway Integration

-   Implements the factory design pattern to support multiple payment methods:
    -   Stripe
    -   PayPal
    -   Cash on Delivery

### Additional Features

-   RESTful APIs for retrieving countries and cities.
-   Efficient zone and rate management for shipping.

## Technologies Used

-   **Backend**: Laravel Framework
-   **Frontend**: Livewire for real-time interactions
-   **Admin Panel**: Filament
-   **Payment Integration**: Stripe and PayPal
-   **Database**: MySQL
-   **Localization**: Support for global shipping zones and multi-country support

## Installation

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   MySQL
-   Node.js and npm (for frontend dependencies)

### Steps

1. Clone the repository:
    ```bash
    git clone https://gitlab.objects.ws/laravel/engy-food-delivery-training.git
    cd engy-food-delivery-training
    ```
2. Install PHP dependencies:
    ```bash
    composer install
    ```
3. Install Node.js dependencies:
    ```bash
    npm install && npm run dev
    ```
4. Set up the environment variables:
    ```bash
    cp .env.example .env
    ```
    Configure the `.env` file with your database credentials and payment gateway API keys.
5. Run database migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```
6. Serve the application:
    ```bash
    php artisan serve
    ```

## Usage

### Admin Panel

Access the admin panel at `/admin`.

### Shipping Calculator

The shipping calculator dynamically updates shipping costs based on the user's selected location and provides real-time feedback.

### Admin User Management

To create a new Filament user, run the following command in the terminal:

```bash
php artisan make:filament-user
```
This command will prompt you to enter:

1. **Email address**: The email address of the user.
2. **Password**: The password for the user.

After running the command, the user will be created and can access the admin panel with the provided credentials.

### Payment Management

The system includes a dedicated payment management interface in the admin dashboard that allows administrators to:

-   Enable/disable payment methods dynamically
-   Control available payment options including:
    -   Stripe Payments
    -   PayPal Integration
    -   Cash on Delivery (COD)

Administrators can access these settings through:

1. Navigate to the admin dashboard
2. Go to Settings > Manage Payment
3. Toggle payment methods on/off as needed
4. Save changes to immediately affect the checkout options available to customers

This provides flexible control over payment methods without requiring code changes.

### Payment Integration

During checkout, users can select a preferred payment method. The factory design pattern ensures a seamless switch between payment gateways.

