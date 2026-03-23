<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step_one_tp</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdp-lost.css') }}">
</head>

<body class = "login-page">

    <header class="header">
        <div class="brand-logo">
            <img src="{{ asset('img/logo_b.png') }}" alt="Logo MyTicket">
        </div>
    </header>

    
    <div class="login-text">
        <h2 class = "login-title" >Welcome to my ticket app</h2> 
    </div>

    <div class="login-conection">
        <div class = "login-text1">
            <p>Veuillez entrer votre adresse mail, un email vous sera envoyé pour changer votre mot de passe</p>
        </div>
        <form id = "mdp-lost"action="{{ route('mdpLost.post') }}" method="post">
            @csrf
            <div class="login-interaction">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email-lost1" type="email" id="email" name="email" placeholder="nom@exemple.com" required>          
                </div>
                
                <div class="form-group">
                    <label for="email">Confirmer votre adresse email</label>
                    <input id="email-lost2" type="email" id="email" name="email" placeholder="nom@exemple.com" required>
                    <div id="lost-error-email-same" class="error-text hidden">Les deux email doivent être identique</div>
                </div>
            </div>
            <button type="submit" class="login-btn" >Changer mot de passe</button>
        </form>

        <a class = "returnConnection" href = "{{ route('login') }}">
            <btn>Retour à la page de connexion</btn>
        </a>
    </div>

    <div id="success" class="success hidden">
        <h4>Email send</h4>
    </div>

    <!--<script src="{{ asset('css/mdp-lost.js') }}"></script>-->
</body>
</html>