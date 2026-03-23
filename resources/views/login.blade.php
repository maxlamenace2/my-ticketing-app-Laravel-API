
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step_one_tp</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
            <p>Veuillez vous connecter pour accéder à vos tickets</p>
        </div>
            
        
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="login-interaction">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="nom@exemple.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="mdp-forgot">
                    <a class="mdp-lost" href="{{ route('mdp-lost') }}">mot de passe oublié ?</a>
                    
                    <a class="inscription" href="{{ route('inscription') }}">inscription ?</a>
                </div>
                <button type="submit" class="login-btn" >Se connecter</button>
            </form>
        </div>

        <div id="error-toast" class="toast">Email ou mot de passe incorrect.</div>
    
    <script src="{{ asset('js/login.js') }}"></script>

</body>
</html>