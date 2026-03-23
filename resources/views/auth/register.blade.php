<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inscription.css') }}">
</head>

<body class="auth-page">

    <header class="header">
        <div class="brand-logo">
            <img src="{{ asset('img/logo_b.png') }}" alt="Logo MyTicket">
        </div>
    </header>

    <main class="auth-container">
        
        <div class="auth-card">
            <div class="auth-header-text">
                <h1>Créer un compte</h1>
                <p>Bienvenue sur MyTicket App! Remplissez le formulaire ci-dessous pour commencer.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="auth-form" novalidate>
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Dupont" required autofocus>
                        @error('lastname') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" placeholder="Jean" required>
                        @error('firstname') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="jean.dupont@exemple.com" required>
                    @error('email') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="birthdate">Date de naissance</label>
                    <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required>
                    @error('birthdate') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" placeholder="••••••••" required>
                    @error('password') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <div class="form-check">
                    <input id="terms" type="checkbox" name="terms" required>
                    <label for="terms">J'accepte les <a href="#">Conditions Générales d'Utilisation</a></label>
                    @error('terms') <div style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-primary full-width">S'inscrire</button>

            </form>

            <div class="auth-footer">
                <p>Retourner à la page de connexion ?<a href="{{ route('login') }}" class="link-login"> Se connecter </a></p>
            </div>
        </div>

    </main>

</body>
</html>