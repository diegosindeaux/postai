<?php

namespace App\Strategies;

use App\Factories\ChatServiceFactory;

class ChatGPTStrategy implements ChatStrategy
{
    protected $chatService;

    public function __construct()
    {
        $this->chatService = ChatServiceFactory::createChatGPTService();
    }

    public function reply(string $message): string
    {
        try {
            $response = $this->chatService->sendMessage($message);
            
            if ($response['success']) {
                return $response['response'];
            } else {
                return 'Desculpe, não consegui processar sua mensagem no momento.';
            }
        } catch (\Exception $e) {
            return 'Desculpe, ocorreu um erro ao processar sua mensagem: ' . $e->getMessage();
        }
    }
}
