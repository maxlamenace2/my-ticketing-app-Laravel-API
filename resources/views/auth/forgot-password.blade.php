<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdp-lost.css') }}">
</head>

<body class="login-page">
    <header class="header">
        <div class="brand-logo">
            <img src="{{ asset('img/logo_b.png') }}" alt="Logo MyTicket">
        </div>
    </header>

    <div class="login-text">
        <h2 class="login-title">Welcome to my ticket app</h2> 
    </div>

    <div class="login-conection">
        <div class="login-text1">
            <p>Veuillez entrer votre adresse mail, un lien vous sera envoyé pour changer votre mot de passe</p>
        </div>

        @if (session('status'))
            <div style="color: green; margin-bottom: 10px; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="login-interaction">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nom@exemple.com" required autofocus>
                    @error('email')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="login-btn">Envoyer le lien</button>
        </form>

        <a class="returnConnection" href="{{ route('login') }}" style="display: block; text-align: center; margin-top: 20px;">
            Retour à la page de connexion
        </a>
    </div>
</body>
</html>