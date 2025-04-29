<!-- 
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
 -->

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
                <!-- Options visibles pour tous (connectés ou non) -->
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('posts.index')]) href="{{route('posts.index')}}">Accueil</a>
                </li>
                
                @if (Auth::check())
                    <!-- Options pour utilisateurs connectés (standards et admins) -->
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => Route::is('profile')]) href="{{route('profile')}}">Mon Profil</a>
                    </li>
                    
                    @if (Auth::user()->isAdmin())
                        <!-- Options uniquement pour les administrateurs -->
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => Route::is('posts.trash')]) href="{{route('posts.trash')}}">Corbeille</a>
                        </li>
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => Route::is('posts.postsTable')]) href="{{route('posts.postsTable')}}">Gestion Posts</a>
                        </li>
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => Route::is('users.index')]) href="{{route('users.index')}}">Utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => Route::is('posts.create')]) href="{{route('posts.create')}}">Créer un Post</a>
                        </li>
                    @endif
                    
                    <!-- Bouton de déconnexion pour tous les utilisateurs connectés -->
                    <li class="nav-item">
                        <form action="{{{route('logout')}}}" method="POST">
                            @csrf
                            <button type="submit" @class(['nav-link', 'active' => Route::is('logout')]) style="background: none; border: none;">Se déconnecter</button>
                        </form>
                    </li>
                @else
                    <!-- Options uniquement pour les visiteurs non connectés -->
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => Route::is('login')]) href="{{route('login')}}">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => Route::is('register')]) href="{{route('register')}}">S'inscrire</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>