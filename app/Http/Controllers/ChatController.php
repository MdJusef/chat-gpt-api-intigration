<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Throwable;

class ChatController extends Controller
{

    public function chatGpt(Request $request)
    {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->json();  // Convert the response to JSON

            if (isset($response['error'])) {
                return response()->json([
                    'error' => $response['error']['message']
                ], 400);  // Return the specific error from OpenAI API
            }

            return $response['choices'][0]['message']['content'];
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);  // Log the actual exception
        }
    }
}
