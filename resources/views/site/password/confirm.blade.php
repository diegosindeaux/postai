@extends('site.layouts.basico')

@section('titulo', 'Nova senha')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Definir nova senha</h1>
        </div>

        <div class="informacao-pagina">
            <div class="form-login" style="width: 30%; margin-left:auto; margin-right:auto;">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <p>Digite sua nova senha:</p>
                    
                    <input type="password" name="password" placeholder="Nova senha" class="borda-preta">
                    {{ $errors->has('password') ? $errors->first('password') : '' }}
                    
                    <input type="password" name="password_confirmation" placeholder="Confirmar nova senha" class="borda-preta">
                    {{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}
                    
                    <button type="submit" class="borda-preta">Alterar senha</button>
                </form>
                
                <div style="margin-top: 20px;">
                    <a class="link-padrao" href="{{ route('login') }}">Voltar ao login</a>
                </div>
            </div>
        </div>
    </div>

    <div class="rodape">
        <div class="redes-sociais">
            <h2>Redes sociais</h2>
            <img src="img/facebook.png">
            <img src="img/linkedin.png">
            <img src="img/youtube.png">
        </div>
        <div class="area-contato">
            <h2>Contato</h2>
            <span>suporte@estante.com</span>
        </div>
        <div class="localizacao">
            <h2>Localização</h2>
            <img src="{{ asset('img/mapa.png') }}">
        </div>
    </div>
@endsection 