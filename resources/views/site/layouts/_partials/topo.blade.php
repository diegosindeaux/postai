<div class="topo">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}">
    </div>

    <div class="menu">
        <ul>
            <li><a href="{{ route('site.index') }}">Principal</a></li>
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                <li><a href="{{ route('app.home') }}">Área interna</a></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;color:#069;cursor:pointer;">Sair</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</div>
