<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GptController extends Controller
{
    function generate(Request $request){
        $key = env('OPENAI_TOKEN');
        $client = new Client();

        $validate = Validator::make($request->all(),
            [
                'message' => 'required',
            ]);

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => "Bearer $key",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => "Представь что ты ChatGPT 4.0"],
                    ['role' => 'user', 'content' => $request->input('message')]
                ]
            ]
        ]);

        $responseBody = $response->getBody();
        $responseData = json_decode($responseBody, true);

        // Получение ответа от ChatGPT
        $reply = $responseData['choices'][0]['message']['content'];

        return response()->json(['reply' => $reply], 200);
    }
}

//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
