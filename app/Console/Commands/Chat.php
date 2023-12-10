<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\openAIService;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\intro;

class Chat extends Command
{
    // The name and signature of the console command.
    protected $signature = 'chat';

    // The console command description.
    protected $description = 'Command description';

    // This is where the command's logic is defined.
    public function handle()
    {
        // Define the system instruction for the chat
        $chatBoxSystemInstruction = 'You are Chatwire. Answer as concisely as possible.';

        // Create a new instance of the openAIService
        $openAIService = new openAIService();

        // Get the available GPT models
        $availableGPTModels = $openAIService->availableGPTModels();

        // Display an introduction message
        intro('Welcome to Chatwire!');

        // Ask the user to choose a GPT model
        $chosenModel = suggest(
            label: 'Choose a GPT model: ',
            options: array_values($availableGPTModels),
            required: 'This field is required. Choose a model to use for Chatwire.',
            hint: 'Choose a model to use for Chatwire.'
        );

        // Get the available GPT roles
        $chosenAvailableGPTRoles = $openAIService->availableGPTRoles();

        // Ask the user to choose a role
        $chosenRole = suggest(
            label: 'Choose a role: ',
            options: array_keys($chosenAvailableGPTRoles),
            hint: 'If it will be empty, then the default will be used: ' . "$chatBoxSystemInstruction"
        );

        // If no role is chosen, use the default system instruction
        if (empty($chosenRole)) {
            $transactions[] = ['role' => 'system', 'content' => $chatBoxSystemInstruction];
            info($chatBoxSystemInstruction);
        } else {
            // If a role is chosen, use the chosen role
            $transactions[] = ['role' => 'system', 'content' => $chosenAvailableGPTRoles[$chosenRole]];
            info($chosenAvailableGPTRoles[$chosenRole]);
        }

        // Ask the user to choose the max tokens
        $chosenMaxTokens = text(
            label: 'Choose max tokens: ',
            required: 'This field is required. Choose max tokens for Chatwire.',
            default: 600,
            hint: 'Choose max tokens for Chatwire.'
        );

        // Ask the user to choose the temperature
        $chosenTemperature = text(
            label: 'Choose temperature: ',
            required: 'This field is required. Choose temperature for Chatwire.',
            default: 0.6,
            hint: 'Choose temperature for Chatwire.'
        );

        // Get the key of the chosen model
        $chosenModelKey = array_search($chosenModel, $availableGPTModels);

        // Ask the user to ask a question to Chatwire
        $question = text(
            label: 'Ask Chatwire: ',
            required: 'This field is required. Type "exit" to leave the chat.',
            hint: 'Ask whatever you want Chatwire or type "exit" to exit the chat.'
        );

        // Keep asking questions until the user types 'exit'
        while ($question !== 'exit') {

            // Add the question to the transactions
            $transactions[] = ['role' => 'user', 'content' => $question];

            // Get the response from the AI service
            $response = spin(function ()
            use ($openAIService, $transactions, $chosenModelKey, $chosenMaxTokens, $chosenTemperature) {
                return $openAIService->ask($chosenModelKey, $chosenMaxTokens, $chosenTemperature, $transactions);
            });

            // Display the AI's response
            info($response->choices[0]->message->content);

            // Ask the next question
            $question = text(
                label: 'Ask Chatwire: ',
                required: 'This field is required. Type "exit" to leave the chat.',
                hint: 'Ask whatever you want Chatwire or type "exit" to exit the chat.'
            );
        }

        // Display a goodbye message
        outro('Thank you for using Chatwire. See you next time!');
    }
}
