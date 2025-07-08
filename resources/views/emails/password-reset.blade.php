<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redefinição de Senha - Sistema Estante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema Estante</h1>
        <p>Onde sua empresa fica e se organiza</p>
    </div>

    <div class="content">
        <h2>Olá, {{ $user->name }}!</h2>
        
        <p>Você solicitou a redefinição de sua senha no Sistema Estante.</p>
        
        <p>Para definir uma nova senha, clique no botão abaixo:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetLink }}" class="button">Redefinir Senha</a>
        </div>
        
        <p>Se o botão não funcionar, copie e cole o link abaixo no seu navegador:</p>
        <p style="word-break: break-all; color: #007bff;">{{ $resetLink }}</p>
        
        <p><strong>Importante:</strong></p>
        <ul>
            <li>Este link é válido por 60 minutos</li>
            <li>Se você não solicitou esta redefinição, ignore este email</li>
            <li>Não compartilhe este link com ninguém</li>
        </ul>
    </div>

    <div class="footer">
        <p>Este email foi enviado automaticamente pelo Sistema Estante.</p>
        <p>Se tiver dúvidas, entre em contato: suporte@estante.com</p>
        <p>&copy; {{ date('Y') }} Sistema Estante. Todos os direitos reservados.</p>
    </div>
</body>
</html> 