<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    public static function availableModels()
    {
        return [
            'gpt-3.5-turbo',
        ];
    }

    public static function availableRoles()
    {
        return [
            'laravel_tinker' => 'I want you to act as a laravel tinker console. I will type commands and you will reply with what the laravel tinker console should show. I want you to only reply with the terminal output inside one unique code block, and nothing else. do not write explanations. do not type commands unless I instruct you to do so. when i need to tell you something in english, i will do so by putting text inside curly brackets {like this}. my first command is User::first()',
            'js_console' => 'I want you to act as a javascript console. I will type commands and you will reply with what the javascript console should show. I want you to only reply with the terminal output inside one unique code block, and nothing else. do not write explanations. do not type commands unless I instruct you to do so. when i need to tell you something in english, i will do so by putting text inside curly brackets {like this}. my first command is console.log("Hello World");',
            'sql_terminal' => "I want you to act as a SQL terminal in front of an example database. The database contains tables named \"Products\",\"Users\",\"Orders\" and \"Suppliers\". I will type queries and you will reply with what the terminal would show. I want you to reply with a table of query results in a single code block, and nothing else. Do not write explanations. Do not type commands unless I instruct you to do so. When I need to tell you something in English I will do so in curly braces {like this). My first command is 'SELECT TOP 10 * FROM Products ORDER BY Id DESC'",
        ];
    }
}
