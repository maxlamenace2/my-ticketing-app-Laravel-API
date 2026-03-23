<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/parametre.css') }}">
    <title>Parametre</title>
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

        <main class="settings-main">
            
            <div class="page-header">
                <h1>Paramètres</h1>
                <p>Gérez vos préférences d'application et les documents légaux</p>
            </div>

            <div class="settings-grid">

                <section class="card settings-card">
                    <h2>Préférences Générales</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <label for="language-select">Langue de l'interface</label>
                            <p>Choisissez votre langue préférée</p>
                        </div>
                        <div class="setting-action">
                            <select id="language-select" class="custom-select">
                                <option value="fr" selected>Français</option>
                                <option value="en">English</option>
                                <option value="es">Español</option>
                            </select>
                        </div>
                    </div>

                    <hr class="divider">

                    <div class="setting-item">
                        <div class="setting-info">
                            <label>Sécurité</label>
                            <p>Recevoir un email a chaque connexion</p>
                        </div>
                        <div class="setting-action">
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </section>

                <section class="card settings-card">
                    <h2>Notifications</h2>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <label>Alertes Email</label>
                            <p>Recevoir un email à chaque nouveau ticket</p>
                        </div>
                        <div class="setting-action">
                            <label class="toggle-switch">
                                <input type="checkbox" checked> <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <hr class="divider">

                    <div class="setting-item">
                        <div class="setting-info">
                            <label>Mises à jour Projets</label>
                            <p>Notifications lors de la clôture d'un projet</p>
                        </div>
                        <div class="setting-action">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </section>

                <section class="card settings-card full-width">
                    <h2>Documents Légaux & Données</h2>
                    <p class="section-desc">Téléchargez les documents relatifs à l'utilisation de MyTicket.</p>

                    <div class="documents-list">
                        <div class="doc-item">
                            <div class="doc-icon">📄</div>
                            <div class="doc-details">
                                <strong>Politique de Confidentialité (RGPD)</strong>
                                <span>Mise à jour le 01/02/2026</span>
                            </div>
                            <button class="btn-download">Télécharger PDF</button>
                        </div>

                        <div class="doc-item">
                            <div class="doc-icon">⚖️</div>
                            <div class="doc-details">
                                <strong>Conditions Générales d'Utilisation</strong>
                                <span>Version 2.4</span>
                            </div>
                            <button class="btn-download">Télécharger PDF</button>
                        </div>
                    </div>
                </section>

                <div class="save-area">
                    <button class="btn-save">Enregistrer les modifications</button>
                </div>

            </div>
        </main>
    </div>


    <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>