@extends('site.layouts.basico')

@section('titulo', 'Chatbot - Assistente Virtual')

@section('conteudo')
<div class="chatbot-container">
    <div class="chatbot-header">
        <h1>🤖 Assistente Virtual</h1>
        <p>Como posso ajudá-lo hoje?</p>
        <div class="status-indicator" id="statusIndicator">
            <span class="status-dot"></span>
            <span class="status-text">Verificando...</span>
        </div>
    </div>

    <div class="chatbot-messages" id="chatMessages">
        <div class="message bot-message">
            <div class="message-content">
                <div class="message-avatar">🤖</div>
                <div class="message-text">
                    Olá! Sou seu assistente virtual especializado em gestão empresarial. 
                    Posso ajudá-lo com questões sobre produtos, clientes, fornecedores, pedidos e muito mais. 
                    Como posso ser útil hoje?
                </div>
            </div>
            <div class="message-time">{{ now()->format('H:i') }}</div>
        </div>
    </div>

    <div class="chatbot-input-container">
        <div class="input-wrapper">
            <input type="text" id="messageInput" placeholder="Digite sua mensagem..." maxlength="1000">
            <button id="sendButton" class="send-button">
                <span class="send-icon">📤</span>
            </button>
        </div>
        <div class="typing-indicator" id="typingIndicator" style="display: none;">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span>Assistente está digitando...</span>
        </div>
    </div>

    <div class="chatbot-suggestions">
        <h4>Sugestões de perguntas:</h4>
        <div class="suggestion-chips">
            <button class="suggestion-chip" data-message="Como posso gerenciar meus produtos?">Gerenciar produtos</button>
            <button class="suggestion-chip" data-message="Como adicionar um novo cliente?">Adicionar cliente</button>
            <button class="suggestion-chip" data-message="Como criar um pedido?">Criar pedido</button>
            <button class="suggestion-chip" data-message="Como funciona o sistema de estoque?">Sistema de estoque</button>
        </div>
    </div>
</div>

<style>
.chatbot-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    min-height: 600px;
    display: flex;
    flex-direction: column;
}

.chatbot-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
}

.chatbot-header h1 {
    color: #333;
    margin-bottom: 10px;
    font-size: 2.5em;
}

.chatbot-header p {
    color: #666;
    font-size: 1.1em;
    margin-bottom: 15px;
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #f8f9fa;
    border-radius: 20px;
    font-size: 0.9em;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ffc107;
    animation: pulse 2s infinite;
}

.status-dot.online {
    background: #28a745;
}

.status-dot.offline {
    background: #dc3545;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px 0;
    max-height: 400px;
}

.message {
    margin-bottom: 20px;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.message-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.message-avatar {
    font-size: 1.5em;
    min-width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 50%;
}

.user-message .message-content {
    flex-direction: row-reverse;
}

.user-message .message-text {
    background: #007bff;
    color: white;
    border-radius: 18px 18px 4px 18px;
}

.bot-message .message-text {
    background: #f8f9fa;
    color: #333;
    border-radius: 18px 18px 18px 4px;
}

.message-text {
    padding: 12px 16px;
    max-width: 70%;
    word-wrap: break-word;
    line-height: 1.4;
}

.message-time {
    font-size: 0.8em;
    color: #999;
    margin-top: 5px;
    text-align: right;
}

.user-message .message-time {
    text-align: left;
}

.chatbot-input-container {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.input-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

#messageInput {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    font-size: 1em;
    outline: none;
    transition: border-color 0.3s;
}

#messageInput:focus {
    border-color: #007bff;
}

.send-button {
    width: 50px;
    height: 50px;
    border: none;
    border-radius: 50%;
    background: #007bff;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s;
}

.send-button:hover {
    background: #0056b3;
}

.send-button:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

.send-icon {
    font-size: 1.2em;
}

.typing-indicator {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
    color: #666;
    font-size: 0.9em;
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dots span {
    width: 8px;
    height: 8px;
    background: #007bff;
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

.chatbot-suggestions {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.chatbot-suggestions h4 {
    color: #333;
    margin-bottom: 15px;
    font-size: 1.1em;
}

.suggestion-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.suggestion-chip {
    padding: 8px 16px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.9em;
}

.suggestion-chip:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

@media (max-width: 768px) {
    .chatbot-container {
        margin: 10px;
        padding: 15px;
    }
    
    .chatbot-header h1 {
        font-size: 2em;
    }
    
    .message-text {
        max-width: 85%;
    }
    
    .suggestion-chips {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    const statusIndicator = document.getElementById('statusIndicator');
    const suggestionChips = document.querySelectorAll('.suggestion-chip');

    // Verificar status da API
    checkApiStatus();

    // Enviar mensagem com Enter
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Enviar mensagem com botão
    sendButton.addEventListener('click', sendMessage);

    // Sugestões de perguntas
    suggestionChips.forEach(chip => {
        chip.addEventListener('click', function() {
            const message = this.getAttribute('data-message');
            messageInput.value = message;
            sendMessage();
        });
    });

    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message) return;

        // Adicionar mensagem do usuário
        addMessage(message, 'user');
        messageInput.value = '';
        sendButton.disabled = true;

        // Mostrar indicador de digitação
        typingIndicator.style.display = 'flex';

        // Enviar para API
        fetch('{{ route("chatbot.sendMessage") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            typingIndicator.style.display = 'none';
            sendButton.disabled = false;

            if (data.success) {
                addMessage(data.response, 'bot');
            } else {
                addMessage('Desculpe, ocorreu um erro ao processar sua mensagem.', 'bot');
            }
        })
        .catch(error => {
            typingIndicator.style.display = 'none';
            sendButton.disabled = false;
            addMessage('Desculpe, ocorreu um erro de conexão. Tente novamente.', 'bot');
            console.error('Erro:', error);
        });
    }

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const time = new Date().toLocaleTimeString('pt-BR', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        messageDiv.innerHTML = `
            <div class="message-content">
                <div class="message-avatar">${sender === 'user' ? '👤' : '🤖'}</div>
                <div class="message-text">${text}</div>
            </div>
            <div class="message-time">${time}</div>
        `;

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function checkApiStatus() {
        fetch('{{ route("chatbot.status") }}')
        .then(response => response.json())
        .then(data => {
            const statusDot = statusIndicator.querySelector('.status-dot');
            const statusText = statusIndicator.querySelector('.status-text');
            
            if (data.api_configured) {
                statusDot.className = 'status-dot online';
                statusText.textContent = 'Online';
            } else {
                statusDot.className = 'status-dot offline';
                statusText.textContent = 'Offline - API não configurada';
            }
        })
        .catch(error => {
            const statusDot = statusIndicator.querySelector('.status-dot');
            const statusText = statusIndicator.querySelector('.status-text');
            statusDot.className = 'status-dot offline';
            statusText.textContent = 'Erro ao verificar status';
        });
    }
});
</script>
@endsection 