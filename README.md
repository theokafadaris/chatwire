# Chatwire

Chatwire is an advanced AI-powered application built using Laravel Breeze, Livewire, and the OpenAI PHP client (Chat and Audio Resource). It integrates multiple APIs, including GPT and Gemini for AI-driven interactions, Spotify for music recommendations, Bible and book data, Reuters for news updates, and translation services, providing a seamless user experience. Chatwire also supports a command-line interface for interacting with ChatGPT through Laravel Prompts, making it a versatile platform for various content and information needs..

## Description

The platform integrates a variety of APIs to enhance user experience:

GPT and Gemini: For advanced AI-driven conversations and responses.
Spotify: To offer personalized music recommendations.
Bible and Book Data: For accessing and interacting with biblical and literary content.
Reuters: To deliver up-to-date news and information.
Translation Services: To facilitate multilingual support and translations.
The frontend utilizes TailwindCSS for modern styling, enhanced by Flowbite for additional UI components. Vite.js is used for efficient script compilation and bundling. The backend relies on MySQL for robust data management.

Additional packages used in the project include:

Flowbite: For pre-built components that work seamlessly with TailwindCSS.
Laravel-Livewire: To enable dynamic and interactive frontend components without full page reloads.
openai-php: To interface with OpenAI’s API for AI functionalities.
livewire-alert: For user-friendly alert notifications.
Laravel Prompts: For a command-line interface that integrates with ChatGPT.


## Getting Started

To run Chatwire locally, follow these steps:

1. Clone this repository

2. Run `composer install`

3. Copy `.env.example` to `.env`

4. Add your OpenAI API key in `.env` file at `OPENAI_API_KEY` as well as the other keys (GEMINI + Cloudlinary).

 For the system to work correctly head over to the Controllers and fill the appropriate keys for each endpoint used.
   Head over here: [RAPID API MARKETPLACE](https://rapidapi.com/hub)

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


## Screenshots

Here are some screenshots of Chatwire in action:

![App Screenshot](https://imgur.com/GHeFLv1.png)

![App Screenshot](https://imgur.com/NTFkdQq.png)

![App Screenshot](https://imgur.com/js9JjeZ.png)

![App Screenshot](https://imgur.com/OsUGfMg.png)

![App Screenshot](https://imgur.com/8GZPq6h.png)

![App Screenshot](https://imgur.com/pV9eFK0.png)

![App Screenshot](https://imgur.com/20G3XR1.png)

![App Screenshot](https://imgur.com/4u8OpbB.png)

![App Screeenshot](https://imgur.com/iWDcmfZ.png)

![App Screeenshot](https://imgur.com/f1fLg7S.png)

![App Screeenshot](https://imgur.com/hXKV9gE.png)

![App Screeenshot](https://imgur.com/EYIhbo6.png)

![App Screeenshot](https://imgur.com/2PiAz1s.png)

![App Screeenshot](https://imgur.com/bII7mng.png)

## Contributing

If you'd like to contribute to Chatwire, here's how you can get started:

1. Fork this repository

2. Create a new branch (`git checkout -b my-new-branch`)

3. Make your changes

4. Commit your changes (`git commit -am 'Add some feature'`)

5. Push to the branch (`git push origin my-new-branch`)

6. Create a new Pull Request

We welcome contributions from anyone interested in improving Chatwire
