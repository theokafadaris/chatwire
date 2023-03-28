# Chatwire

This is a simple clone of ChatGPT made with Laravel Breeze using Livewire and the OpenAI PHP client.

In this project, we have a Laravel 10 Breeze with Livewire, a login session and access to OpenAI's ChatGPT API. The entire Laravel project is based on TailwindCSS using Flowbite, Vite.js to compile scripts, MySQL. As far as the extra packages Flowbite, Laravel-Livewire, openai-php, livewire-alert are used.

# Get Started

### Required

-   PHP 8.1+
-   MySQL
-   OpenAI account for API Key

### Installation

-   Clone this repository
-   `composer update`
-   `cp .env.example .env`
-   Add your OpenAI API key in `.env` file at `OPENAI_API_KEY`
    ![App Screenshot](https://i.imgur.com/e8IdRtB.png)
-   Add your SMPT configuration. This will be used to send your conversation to your email.
    ![App Screenshot](https://i.imgur.com/Vh0SJuy.png)
-   `php artisan key:generate`
-   `php artisan migrate`
-   `npm install`
-   `npm run build`
-   `php artisan serve`
-   Add the following line to your cronjobs :
    `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
`
    The above will be used for the email queue job that it is used for sending the emails
-   Open the link: http://127.0.0.1:8000

## Usage

This project is used to call OpenAI API and display the responses in Laravel Breeze Dashboard using Livewire.
There is the ability to send your conversation with ChatGPT to your email.

## Screenshots

![App Screenshot](https://i.imgur.com/bU2qNWm.png)

![App Screenshot](https://i.imgur.com/bqPrBnL.png)

![App Screenshot](https://i.imgur.com/KiwGh64.png)
