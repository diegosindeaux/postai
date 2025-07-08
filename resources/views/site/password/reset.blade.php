@extends('site.layouts.basico')

@section('titulo', 'Esqueci minha senha')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Esqueci minha senha</h1>
        </div>

        <div class="informacao-pagina">
            <div class="form-login" style="width: 30%; margin-left:auto; margin-right:auto;">
                @if(session('success'))
                    <div style="color: green; margin-bottom: 10px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('password.send') }}" method="POST">
                    @csrf
                    <p>Digite seu email para receber um link de redefinição de senha:</p>
                    
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="borda-preta">
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                    
                    <button type="submit" class="borda-preta">Enviar link</button>
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