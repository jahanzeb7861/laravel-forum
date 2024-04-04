<?php

namespace App\Http\Controllers;

use pschocke\TelegramLoginWidget\Facades\TelegramLoginWidget;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function callback(Request $request) {
        if (! $telegramUser = TelegramLoginWidget::validate($request)) {
            return 'Telegram Response not valid';
        }
        $telegramChatID = $telegramUser->get('id');
        // You need to store the chat ID to be able to use it later
        return 'Success!';
    }

}
