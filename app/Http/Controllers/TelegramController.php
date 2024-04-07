<?php

namespace App\Http\Controllers;

use App\Models\User;
use pschocke\TelegramLoginWidget\Facades\TelegramLoginWidget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    public function callback(Request $request) {
        // if (! $telegramUser = $this->checkHashes($request)) {
        //     return 'Telegram Response not valid';
        // }

        $telegramChatID = $request->get('id');
        // You need to store the chat ID to be able to use it later

        // Assuming you have retrieved user information like user ID or username
        $user = User::where('telegram_user_id', $request->id)->first();

        // Log in the user
        if ($user) {
            Auth::login($user);
            return redirect('/threads')->with('error', 'Already Connected.');
            // return redirect('/home'); // Redirect to the home page or any other desired location
        } else {
            return redirect('/show_connect')->with('error', 'Failed to connect with Telegram.');
        }

        // auth()->user()->update([
        //         'telegram_username' => $request->username,
        //         'telegram_id' => $request->id,
        // ]);

        // return 'Success!';
    }


      public function showConnectButton() {
        return view('telegram.show_connect');
    }

}
