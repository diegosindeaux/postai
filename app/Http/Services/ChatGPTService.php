<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ChatGPTService
{
    protected $client;
    protected $apiKey;
    protected $model;
    protected $maxTokens;
    protected $temperature;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);
        $this->apiKey = env('OPENAI_API_KEY');
        $this->model = env('OPENAI_MODEL', 'gpt-4o-mini');
        $this->maxTokens = (int) env('OPENAI_MAX_TOKENS', 1000);
        $this->temperature = (float) env('OPENAI_TEMPERATURE', 0.7);
    }

    public function sendMessage($message, $context = [])
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Chave da API OpenAI não configurada');
        }

        if (empty($message)) {
            throw new \Exception('Mensagem não pode estar vazia');
        }

        // Preparar o contexto do sistema
        $systemMessage = $this->getSystemMessage();
        
        // Preparar mensagens
        $messages = [
            ['role' => 'system', 'content' => $systemMessage]
        ];

        // Adicionar contexto se fornecido
        if (!empty($context)) {
            foreach ($context as $contextMessage) {
                $messages[] = $contextMessage;
            }
        }

        // Adicionar a mensagem atual do usuário
        $messages[] = ['role' => 'user', 'content' => $message];

        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => $messages,
                    'max_tokens' => $this->maxTokens,
                    'temperature' => $this->temperature,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            
            if (isset($responseData['choices'][0]['message']['content'])) {
                return [
                    'success' => true,
                    'response' => $responseData['choices'][0]['message']['content'],
                    'usage' => $responseData['usage'] ?? null,
                ];
            } else {
                throw new \Exception('Resposta inválida da API OpenAI');
            }

        } catch (RequestException $e) {
            Log::error('Erro na API OpenAI: ' . $e->getMessage());
            
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody(), true);
                $errorMessage = $errorResponse['error']['message'] ?? 'Erro desconhecido na API';
            } else {
                $errorMessage = 'Erro de conexão com a API OpenAI';
            }
            
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            Log::error('Erro geral no ChatGPTService: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getSystemMessage()
    {
        return "Você é um assistente virtual especializado em gestão empresarial. 
        Você ajuda usuários com questões relacionadas a:
        - Gestão de produtos e estoque
        - Gestão de clientes e fornecedores
        - Gestão de pedidos
        - Relatórios e análises
        - Dúvidas sobre o sistema
        
        Responda de forma clara, concisa e em português brasileiro. 
        Seja útil e profissional, mas mantenha um tom amigável.";
    }

    public function validateApiKey()
    {
        return !empty($this->apiKey);
    }
}
