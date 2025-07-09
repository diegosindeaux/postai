<!-- Chatbot Widget Flutuante -->
<div id="chatbot-widget" class="chatbot-widget">
    <div class="chatbot-toggle" id="chatbotToggle">
        <span class="chatbot-icon">🤖</span>
        <span class="chatbot-label">Assistente</span>
    </div>
    
    <div class="chatbot-panel" id="chatbotPanel">
        <div class="chatbot-header">
            <h3>🤖 Assistente Virtual</h3>
            <button class="chatbot-close" id="chatbotClose">×</button>
        </div>
        
        <div class="chatbot-messages" id="widgetMessages">
            <div class="message bot-message">
                <div class="message-content">
                    <div class="message-avatar">🤖</div>
                    <div class="message-text">
                        Olá! Como posso ajudá-lo hoje?
                    </div>
                </div>
            </div>
        </div>
        
        <div class="chatbot-input">
            <input type="text" id="widgetMessageInput" placeholder="Digite sua mensagem..." maxlength="1000">
            <button id="widgetSendButton" class="widget-send-button">
                <span>📤</span>
            </button>
        </div>
    </div>
</div>

<style>
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chatbot-toggle {
    background: #007bff;
    color: white;
    padding: 12px 16px;
    border-radius: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    transition: all 0.3s ease;
}

.chatbot-toggle:hover {
    background: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,123,255,0.4);
}

.chatbot-icon {
    font-size: 1.2em;
}

.chatbot-label {
    font-weight: 500;
}

.chatbot-panel {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chatbot-panel.active {
    display: flex;
}

.chatbot-header {
    background: #007bff;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header h3 {
    margin: 0;
    font-size: 1.1em;
    font-weight: 600;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5em;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.3s;
}

.chatbot-close:hover {
    background: rgba(255,255,255,0.2);
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    background: #f8f9fa;
}

.message {
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.message-content {
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.message-avatar {
    font-size: 1.2em;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
    border-radius: 50%;
}

.user-message .message-content {
    flex-direction: row-reverse;
}

.user-message .message-text {
    background: #007bff;
    color: white;
    border-radius: 15px 15px 4px 15px;
}

.bot-message .message-text {
    background: white;
    color: #333;
    border-radius: 15px 15px 15px 4px;
    border: 1px solid #e9ecef;
}

.message-text {
    padding: 10px 12px;
    max-width: 80%;
    word-wrap: break-word;
    line-height: 1.3;
    font-size: 0.9em;
}

.chatbot-input {
    padding: 15px;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
    align-items: center;
}

#widgetMessageInput {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    font-size: 0.9em;
    outline: none;
    transition: border-color 0.3s;
}

#widgetMessageInput:focus {
    border-color: #007bff;
}

.widget-send-button {
    width: 40px;
    height: 40px;
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

.widget-send-button:hover {
    background: #0056b3;
}

.widget-send-button:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .chatbot-widget {
        bottom: 10px;
        right: 10px;
    }
    
    .chatbot-panel {
        width: 300px;
        height: 400px;
        bottom: 60px;
    }
    
    .chatbot-label {
        display: none;
    }
    
    .chatbot-toggle {
        padding: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotPanel = document.getElementById('chatbotPanel');
    const chatbotClose = document.getElementById('chatbotClose');
    const widgetMessageInput = document.getElementById('widgetMessageInput');
    const widgetSendButton = document.getElementById('widgetSendButton');
    const widgetMessages = document.getElementById('widgetMessages');

    // Toggle do painel
    chatbotToggle.addEventListener('click', function() {
        chatbotPanel.classList.toggle('active');
        if (chatbotPanel.classList.contains('active')) {
            widgetMessageInput.focus();
        }
    });

    // Fechar painel
    chatbotClose.addEventListener('click', function() {
        chatbotPanel.classList.remove('active');
    });

    // Enviar mensagem com Enter
    widgetMessageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendWidgetMessage();
        }
    });

    // Enviar mensagem com botão
    widgetSendButton.addEventListener('click', sendWidgetMessage);

    function sendWidgetMessage() {
        const message = widgetMessageInput.value.trim();
        if (!message) return;

        // Adicionar mensagem do usuário
        addWidgetMessage(message, 'user');
        widgetMessageInput.value = '';
        widgetSendButton.disabled = true;

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
            widgetSendButton.disabled = false;

            if (data.success) {
                addWidgetMessage(data.response, 'bot');
            } else {
                addWidgetMessage('Desculpe, ocorreu um erro ao processar sua mensagem.', 'bot');
            }
        })
        .catch(error => {
            widgetSendButton.disabled = false;
            addWidgetMessage('Desculpe, ocorreu um erro de conexão. Tente novamente.', 'bot');
            console.error('Erro:', error);
        });
    }

    function addWidgetMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        messageDiv.innerHTML = `
            <div class="message-content">
                <div class="message-avatar">${sender === 'user' ? '👤' : '🤖'}</div>
                <div class="message-text">${text}</div>
            </div>
        `;

        widgetMessages.appendChild(messageDiv);
        widgetMessages.scrollTop = widgetMessages.scrollHeight;
    }
});
</script> 