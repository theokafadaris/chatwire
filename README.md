# Chatwire

Chatwire is a clone of ChatGPT made with Laravel Breeze using Livewire and the OpenAI PHP client (Chat and Audio Resource). It also supports a command interface for asking questions to ChatGPT using Laravel Prompts.

## Description

In this project, we have a Laravel 10 Breeze with Livewire, a login session, and access to OpenAI's ChatGPT API. The entire Laravel project is based on TailwindCSS using Flowbite, Vite.js to compile scripts, MySQL. As far as the extra packages Flowbite, Laravel-Livewire, openai-php, livewire-alert, Laravel Prompts are used.

## Purpose

Chatwire is a Laravel-based project that calls OpenAI's API and displays the responses in Laravel Breeze Dashboard using Livewire. When you finish your ChatBot conversation, you can send it in your email or save it for future use. You can see your saved conversations on the dashboard page using pagination.

Now, you can upload your audio files to create transcription using Audio Resource of OpenAI.

## Features

#### Model Configuration

-   All ChatGPT Models (GPT-4)

-   Audio Resource using Whisper Model

-   Custom System Instruction

-   Temperature Control

-   Maximum Token Control

#### Chat Experience

-   Prompt Library

#### Wordpress Integration

-   Propose and create a Wordpress Post using Wordpress API

-   SEO optimization proposal (focus keywords, meta title, meta description) for latest post

#### Chat Management

-   Share Chat by email

-   Save Chat to Database

-   Paginate Chats

#### Security and Privacy

-   Private By Default

-   Self-hosted

## Technologies Used

This project requires the following technologies:

-   PHP 8.2+

-   MySQL

-   OpenAI account for API Key

The project uses the following technologies:

-   Laravel 11 Breeze

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

2. Run `composer install`

3. Copy `.env.example` to `.env`

4. Add your OpenAI API key in `.env` file at `OPENAI_API_KEY`

![App Screenshot](https://i.imgur.com/e8IdRtB.png)

5. Add your SMTP configuration. This will be used to send your conversation to your email.

![App Screenshot](https://i.imgur.com/Vh0SJuy.png)

6. Run `php artisan key:generate`

7. Run `php artisan migrate`

8. Run `php artisan storage:link`

9. Run `npm install`

10. Run `npm run build`

11. Run `php artisan serve`

12. Add the following line to your cronjobs:

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`

The above will be used for the email queue job that it is used for sending the emails

13. Open the link: http://127.0.0.1:8000

## Usage

To use Chatwire, follow these steps:

1. Start a conversation with the chatbot on the dashboard page.

2. When you finish the conversation, you can save it or send it to your email.

3. You can view your saved conversations on the dashboard page using pagination.

4. You can upload an audio file and ChatGPT will create the trancription for you.

5. You can also use `php artisan chat` command in order to ask ChatGPT from CLI.

## Screenshots

Here are some screenshots of Chatwire in action:

![App Screenshot](https://i.imgur.com/GBdjlTT.png)

![App Screenshot](https://i.imgur.com/wkpgKAr.png)

![App Screenshot](https://i.imgur.com/R7S1phq.png)

![App Screenshot](https://i.imgur.com/GuImTR8.png)

![App Screenshot](https://i.imgur.com/5UAOF8M.png)

![App Screenshot](https://i.imgur.com/3ULtQM1.png)

![App Screenshot](https://i.imgur.com/pOxB0Na.png)

![App Screenshot](https://i.imgur.com/tjCeGyE.png)

![App Screeenshot](https://i.imgur.com/4DbWGng.png)

![App Screeenshot](https://i.imgur.com/wHvUZpu.png)

## Contributing

If you'd like to contribute to Chatwire, here's how you can get started:

1. Fork this repository

2. Create a new branch (`git checkout -b my-new-branch`)

3. Make your changes

4. Commit your changes (`git commit -am 'Add some feature'`)

5. Push to the branch (`git push origin my-new-branch`)

6. Create a new Pull Request

We welcome contributions from anyone interested in improving Chatwire
