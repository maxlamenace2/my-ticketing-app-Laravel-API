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

            <form action="{{ route('inscription.post') }}" method="POST" class="auth-form" novalidate>
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input id="InscriptionName" type="text" id="lastname" name="lastname" placeholder="Dupont">
                        <div id="inscription-name-error-void" class="error-text hidden">Le nom est obligatoire.</div>
                        <div id="inscription-name-error-letter" class="error-text hidden">Le nom doit contenir plus de 2 lettres</div>   
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input id = "InscriptionSurname"type="text" id="firstname" name="firstname" placeholder="Jean">
                        <div id="inscription-surname-error-void" class="error-text hidden">Le prénom est obligatoire.</div>
                        <div id="inscription-surname-error-letter" class="error-text hidden">Le prénom doit contenir plus de 2 lettres</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input id = "InscriptionEmail" type="email" name="email" placeholder="jean.dupont@exemple.com">
                    <div id="inscription-email-error-void" class="error-text hidden">L'email est obligatoire.</div>
                    <div id="inscription-email-error-letter" class="error-text hidden">L'email est trop cours</div>
                    <div id="inscription-email-error-ars" class="error-text hidden">L'email doit contenir un  @ (un seul)</div>
                </div>

                <div class="form-group">
                    <label for="birthdate">Date de naissance</label>
                    <input id="InscriptionDate"type="date" id="birthdate" name="birthdate">
                    <div id="inscription-date-error-void" class="error-text hidden">La date de naissance est obligatoire</div>
                    <div id="inscription-date-error-old" class="error-text hidden">Pour s'inscrire il faut avoir plus de 15 ans</div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="InscriptionMdp1" type="password" id="password" name="password" placeholder="••••••••">
                    <div id="inscription-mdp-error-void" class="error-text hidden">Le mot de passe est obligatoire</div>
                    <div id="inscription-mdp-error-caractere" class="error-text hidden">Le mot de passe doit contenir au moins 10 caractères</div>
                    
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirmer le mot de passe</label>
                    <input id="InscriptionMdp2" type="password" id="password-confirm" name="password_confirm" placeholder="••••••••">
                    <div id="inscription-mdp-error-void2" class="error-text hidden">Le mot de confirmation passe est obligatoire</div>
                    <div id="inscription-mdp-error-caractere2" class="error-text hidden">Le mot de passe doit contenir au moins 10 caractères</div>
                    <div id="inscription-mdp-error-same" class="error-text hidden">Le mot de passe doit être le même que celui au dessus</div>
                </div>

                <div class="form-check">
                    <input id="IncriptionCheckBox"type="checkbox" id="terms" name="terms" required>
                    <label for="terms">J'accepte les <a href="#">Conditions Générales d'Utilisation</a></label>
                    <div id="inscription-checkbox-error-void" class="error-text hidden">Pour crer un compte il faut accepter les Conditions Générales d'Utilisation</div>
                </div>

                <button type="submit" class="btn-primary full-width">S'inscrire</button>

            </form>

            <div class="auth-footer">
                <p>Retourner à la page de connexion ?<a href="{{ route('login') }}" class="link-login"> Se connecter </a></p>
            </div>
        </div>
        <div id="success" class="success hidden">
            <h4>Account created</h4>
        </div>

    </main>

    <!--<script src="{{ asset('js/inscription.js') }}"></script>-->

</body>
</html>