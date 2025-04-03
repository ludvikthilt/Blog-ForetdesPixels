<!-- Navbar section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('posts.index')}}">La Forêt Des Pixels</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('posts.index')]) href="{{route('posts.index')}}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('posts.trash')]) href="{{route('posts.trash')}}">Corbeille</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('posts.postsTable')]) href="{{route('posts.postsTable')}}">Posts</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('users.index')]) href="{{route('users.index')}}">Utilisateurs</a>
                </li>
                @if (Auth::check())
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('posts.create')]) href="{{route('posts.create')}}">Créer un Post</a>
                </li>
                <li class="nav-item">
                    <form action="{{{route('logout')}}}" method="POST">
                        @csrf
                        <button type="submit" @class(['nav-link', 'active' => Route::is('logout')]) href="{{route('logout')}}">Se déconnecter</button>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('login')]) href="{{route('login')}}">Se connecter</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
