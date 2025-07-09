<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\ChatGPTService;

class TestChatGPT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatbot:test {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa a configuração da API do ChatGPT';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🤖 Testando configuração do Chatbot...');
        
        try {
            $chatService = new ChatGPTService();
            
            // Verificar se a API key está configurada
            if (!$chatService->validateApiKey()) {
                $this->error('❌ Chave da API OpenAI não está configurada!');
                $this->line('Configure a variável OPENAI_API_KEY no arquivo .env');
                return 1;
            }
            
            $this->info('✅ Chave da API configurada');
            
            // Testar com uma mensagem simples
            $testMessage = $this->argument('message') ?? 'Olá! Como você pode me ajudar com gestão empresarial?';
            
            $this->line("📤 Enviando mensagem de teste: \"{$testMessage}\"");
            
            $response = $chatService->sendMessage($testMessage);
            
            if ($response['success']) {
                $this->info('✅ Resposta recebida com sucesso!');
                $this->line('');
                $this->line('📝 Resposta:');
                $this->line($response['response']);
                
                if (isset($response['usage'])) {
                    $this->line('');
                    $this->line('📊 Uso de tokens:');
                    $this->line("- Prompt tokens: {$response['usage']['prompt_tokens']}");
                    $this->line("- Completion tokens: {$response['usage']['completion_tokens']}");
                    $this->line("- Total tokens: {$response['usage']['total_tokens']}");
                }
                
                $this->info('🎉 Chatbot configurado e funcionando corretamente!');
                return 0;
            } else {
                $this->error('❌ Erro ao receber resposta da API');
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Erro durante o teste: ' . $e->getMessage());
            return 1;
        }
    }
} 