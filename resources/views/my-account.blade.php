
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-account.css') }}">
    <title>my-account</title>
</head>
<body class="dashboard-page">

    <header class="header">
        <div class="brand-logo">
            <img src="{{ asset('img/logo_b.png') }}" alt="Logo MyTicket">
            
        </div>

        <div class="header-controls">
            
            <a href="{{ route('my-account') }}" class="icon-link">
                <img src="{{ asset('img/account_logo.png') }}" alt="Mon Compte">
            </a>

            <a href="{{ route('parametre') }}" class="icon-link">
                <img src="{{ asset('img/parametre_logo.png') }}" alt="Paramètres">
            </a>

            <button class="menu-toggle" id="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <div class="app-container">
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('projects-list') }}">Projects</a></li>
                    <li><a href="{{ route('tickets-list') }}">Tickets</a></li>
                    <li><a href="{{ route('dashboard') }}" >Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="my-account-main">
            
            <div class="page-header">
                <h1>My Account</h1>
                <p>Manage your profile information and security settings</p>
            </div>

            <div class="account-grid">
                
                <section class="card profile-card">
                    <div class="profile-header">
                        <div class="avatar-circle">
                            <span>T</span> 
                        </div>
                        <h2 class="user-name">{{ $user->firstname }} {{ $user->lastname }}</h2>
                        <span class="role-badge">Membre Officiel</span>
                    </div>
                    
                    <div class="profile-details">
                        <div class="detail-group">
                            <label>Email Address</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="detail-group">
                            <label>Member Since</label>
                            <p>{{ $user->created_at }}</p>
                        </div>
                    </div>
                </section>

                <section class="card security-card">
                    <h2>Security Settings</h2>
                    <form action="{{ route('my-account.password.update') }}" method="POST" class="password-form">
                        @csrf
                        <div class="form-group">
                            <label for="current-pwd">Current Password</label>
                            <input type="password" id="current-pwd" name="current_password" placeholder="Enter current password">
                        </div>

                        <div class="form-group">
                            <label for="new-pwd">New Password</label>
                            <input type="password" id="new-pwd" name="new_password" placeholder="Enter new password">
                        </div>

                        <div class="form-group">
                            <label for="confirm-pwd">Confirm New Password</label>
                            <input type="password" id="confirm-pwd" name="new_password_confirmation" placeholder="Repeat new password">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Update Password</button>
                        </div>
                    </form>
                </section>

            </div>
        </main>
    </div>


    <script src="{{ asset('js/script.js') }}"></script>

        

</body>
</html>