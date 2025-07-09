<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Strategies\ChatGPTStrategy;
use App\Strategies\Context\ChatbotContext;
use Illuminate\Support\Facades\Validator;

class ChatbotController extends Controller
{
    protected $chatContext;

    public function __construct()
    {
        $this->chatContext = new ChatbotContext(new ChatGPTStrategy());
    }

    public function sendMessage(Request $request)
    {
        // Validar a requisição
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $message = $request->input('message');

        try {
            $response = $this->chatContext->respond($message);

            return response()->json([
                'success' => true,
                'response' => $response,
                'timestamp' => now()->toISOString()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar mensagem',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        return view('site.chatbot');
    }

    public function checkStatus()
    {
        try {
            $chatService = app(\App\Http\Services\ChatGPTService::class);
            $isValid = $chatService->validateApiKey();

            return response()->json([
                'success' => true,
                'api_configured' => $isValid,
                'status' => $isValid ? 'online' : 'offline'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'api_configured' => false,
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
} 