<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - SYNEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('accueil') }}">SYNEM</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('accueil') }}">Accueil</a>
                <a class="nav-link active" href="{{ route('a-propos') }}">À propos</a>
                @auth
                    <a href="{{ route('administration.tableau-de-bord') }}" class="nav-link">Administration</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>À propos du SYNEM</h1>
                <p>Page en construction...</p>
                <a href="{{ route('accueil') }}" class="btn btn-primary">Retour à l'accueil</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>