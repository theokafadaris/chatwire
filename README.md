# Chatwire

Chatwire is a simple clone of ChatGPT made with Laravel Breeze using Livewire and the OpenAI PHP client.

## Description

In this project, we have a Laravel 10 Breeze with Livewire, a login session, and access to OpenAI's ChatGPT API. The entire Laravel project is based on TailwindCSS using Flowbite, Vite.js to compile scripts, MySQL. As far as the extra packages Flowbite, Laravel-Livewire, openai-php, livewire-alert are used.

## Purpose

Chatwire is a Laravel-based project that calls OpenAI's API and displays the responses in Laravel Breeze Dashboard using Livewire. When you finish your ChatBot conversation, you can send it in your email or save it for future use. You can see your saved conversations on the dashboard page using pagination.

## Technologies Used

This project requires the following technologies:

-   PHP 8.1+
-   MySQL
-   OpenAI account for API Key

The project uses the following technologies:

-   Laravel 10 Breeze
-   Livewire
-   TailwindCSS
-   Flowbite
-   Vite.js
-   MySQL
-   openai-php
-   livewire-alert

## Getting Started

To run Chatwire locally, follow these steps:

1. Clone this repository
2. Run `composer update`
3. Copy `.env.example` to `.env`
4. Add your OpenAI API key in `.env` file at `OPENAI_API_KEY`
   ![App Screenshot](https://i.imgur.com/e8IdRtB.png)
5. Add your SMTP configuration. This will be used to send your conversation to your email.
   ![App Screenshot](https://i.imgur.com/Vh0SJuy.png)
6. Run `php artisan key:generate`
7. Run `php artisan migrate`
8. Run `npm install`
9. Run `npm run build`
10. Run `php artisan serve`
11. Add the following line to your cronjobs:
    `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
    The above will be used for the email queue job that it is used for sending the emails
12. Open the link: http://127.0.0.1:8000

## Usage

To use Chatwire, follow these steps:

1. Start a conversation with the chatbot on the dashboard page.
2. When you finish the conversation, you can save it or send it to your email.
3. You can view your saved conversations on the dashboard page using pagination.

## Screenshots

Here are some screenshots of Chatwire in action:

![App Screenshot](https://i.imgur.com/GBdjlTT.png)

![App Screenshot](https://i.imgur.com/7XkbLck.png)

![App Screenshot](https://i.imgur.com/R7S1phq.png)

## Contributing

If you'd like to contribute to Chatwire, here's how you can get started:

1. Fork this repository
2. Create a new branch (`git checkout -b my-new-branch`)
3. Make your changes
4. Commit your changes (`git commit -am 'Add some feature'`)
5. Push to the branch (`git push origin my-new-branch`)
6. Create a new Pull Request

We welcome contributions from anyone interested in improving Chatwire
