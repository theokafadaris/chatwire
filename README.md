# Laravel Livewire ChatGPT

This is a simple clone of ChatGPT made with Laravel Breeze and Livewire using the OpenAI PHP client.

In this project, we have a Laravel 10 Breeze and Livewire, with a login session and access to OpenAI's ChatGPT API. The entire Laravel project is based on TailwindCSS using Flowbite, Vite.js to compile scripts, MySQL. As far as the extra packages, openai-php is used.

# Get Started

### Required

-   PHP 8.1+
-   MySQL
-   OpenAI account for API Key

### Installation

-   Clone this repository
-   `composer update`
-   `cp .env.example .env`
-   `php artisan key:generate`
-   `php artisan migrate`
-   `npm install`
-   `npm run build`
-   `php artisan serve`
-   Open the link: http://127.0.0.1:8000

Add your OpenAI API key in `.env` file at `OPENAI_API_KEY`

## Usage

This project is used to call OpenAI API and display the responses in Laravel Breeze Dashboard.

## Screenshots

![App Screenshot](https://i.imgur.com/Zjd0L3Y.png)
