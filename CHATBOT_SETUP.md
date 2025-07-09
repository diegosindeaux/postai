# 🤖 Configuração do Chatbot com API do ChatGPT

## Visão Geral

Este projeto inclui um chatbot inteligente integrado com a API do OpenAI ChatGPT, especializado em gestão empresarial. O chatbot pode ajudar com questões sobre produtos, clientes, fornecedores, pedidos e muito mais.

## Funcionalidades

- ✅ Interface moderna e responsiva
- ✅ Integração com API OpenAI ChatGPT
- ✅ Sugestões de perguntas pré-definidas
- ✅ Indicador de status da API
- ✅ Tratamento de erros robusto
- ✅ Validação de entrada
- ✅ Design responsivo para mobile

## Configuração

### 1. Obter Chave da API OpenAI

1. Acesse [OpenAI Platform](https://platform.openai.com/)
2. Faça login ou crie uma conta
3. Vá para "API Keys" no menu lateral
4. Clique em "Create new secret key"
5. Copie a chave gerada

### 2. Configurar Variáveis de Ambiente

Adicione as seguintes variáveis ao seu arquivo `.env`:

```env
# OpenAI API Configuration
OPENAI_API_KEY=sua_chave_api_aqui
OPENAI_MODEL=gpt-4o-mini
OPENAI_MAX_TOKENS=1000
OPENAI_TEMPERATURE=0.7
```

### 3. Instalar Dependências

Certifique-se de que o Guzzle HTTP Client está instalado:

```bash
composer require guzzlehttp/guzzle
```

### 4. Configurar CSRF Protection

O Laravel já está configurado com proteção CSRF. O token é automaticamente incluído nas requisições AJAX.

## Uso

### Acessar o Chatbot

1. Acesse a página principal do site
2. Clique em "🤖 Chatbot" no menu de navegação
3. Ou acesse diretamente: `/chatbot`

### Funcionalidades da Interface

- **Envio de mensagens**: Digite sua pergunta e pressione Enter ou clique no botão de enviar
- **Sugestões**: Clique nas sugestões pré-definidas para perguntas rápidas
- **Status da API**: O indicador mostra se a API está configurada e funcionando
- **Histórico**: As mensagens são exibidas em tempo real com timestamps

### Exemplos de Perguntas

- "Como posso gerenciar meus produtos?"
- "Como adicionar um novo cliente?"
- "Como criar um pedido?"
- "Como funciona o sistema de estoque?"
- "Quais são as funcionalidades principais do sistema?"

## Estrutura do Código

### Controllers
- `ChatbotController.php` - Gerencia as requisições do chatbot

### Services
- `ChatGPTService.php` - Integração com a API OpenAI

### Strategies
- `ChatGPTStrategy.php` - Implementação da estratégia de chat
- `ChatStrategy.php` - Interface para estratégias de chat

### Views
- `chatbot.blade.php` - Interface do usuário

### Routes
```php
Route::get('/chatbot', 'ChatbotController@index')->name('site.chatbot');
Route::post('/chatbot/send-message', 'ChatbotController@sendMessage')->name('chatbot.sendMessage');
Route::get('/chatbot/status', 'ChatbotController@checkStatus')->name('chatbot.status');
```

## Personalização

### Modificar o Prompt do Sistema

Edite o método `getSystemMessage()` em `ChatGPTService.php` para personalizar o comportamento do chatbot:

```php
protected function getSystemMessage()
{
    return "Seu prompt personalizado aqui...";
}
```

### Ajustar Configurações da API

Modifique as variáveis de ambiente para ajustar:
- **Modelo**: `OPENAI_MODEL` (gpt-4o-mini, gpt-4, gpt-3.5-turbo)
- **Tokens máximos**: `OPENAI_MAX_TOKENS` (1-4000)
- **Temperatura**: `OPENAI_TEMPERATURE` (0.0-2.0)

### Adicionar Novas Sugestões

Edite o arquivo `chatbot.blade.php` e adicione novos botões de sugestão:

```html
<button class="suggestion-chip" data-message="Sua nova sugestão aqui">Texto do botão</button>
```

## Troubleshooting

### Erro: "Chave da API OpenAI não configurada"
- Verifique se a variável `OPENAI_API_KEY` está definida no `.env`
- Certifique-se de que o arquivo `.env` está na raiz do projeto

### Erro: "Erro de conexão com a API OpenAI"
- Verifique sua conexão com a internet
- Confirme se a chave da API é válida
- Verifique se você tem créditos disponíveis na sua conta OpenAI

### Chatbot não responde
- Verifique os logs do Laravel: `storage/logs/laravel.log`
- Confirme se todas as dependências estão instaladas
- Verifique se as rotas estão registradas corretamente

## Segurança

- A chave da API nunca é exposta no frontend
- Todas as requisições são validadas
- Proteção CSRF está ativa
- Limite de caracteres nas mensagens (1000 caracteres)

## Custos

O uso da API OpenAI gera custos baseados no número de tokens utilizados. Consulte a [página de preços da OpenAI](https://openai.com/pricing) para mais detalhes.

## Suporte

Para dúvidas ou problemas:
1. Verifique os logs do Laravel
2. Teste a conectividade com a API OpenAI
3. Confirme se todas as configurações estão corretas 