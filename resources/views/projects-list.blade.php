
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects-list.css') }}">
    <title>Projects List</title>
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
                    <li><a href="{{ route('projects-list') }}" class="active">Projects</a></li>
                    <li><a href="{{ route('tickets-list') }}">Tickets</a></li>
                    <li><a href="{{ route('dashboard') }}" >Dashboard</a></li>
                    <li><a href="{{ route('login') }}">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="projects-list-main">
            <section class="projects-list-section">
                
                <div class="projects-list-header">
                    <h1 class="projects-list-title">Projects List</h1>
                    <a href="#" id="openModalBtn" class="projects-list-create-btn">+ Create New Project</a>
                </div>

                <div class="table-container">
                    <table class="ticket-table">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Description</th>
                                <th>Team</th>
                                <th class="center btnOpen">Open Project</th>
                                <th class="center btnRemove">Delete Project</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->ProjectName }}</td>
                                    <td>
                                        <span style="font-weight: 600; color: #2D5BFF;">
                                            {{ $project->Client }}
                                        </span>
                                    </td>
                                    <td><p>{{ $project->Description }}</p></td>
                                    <td>
                                        {{ $project->Collaborateur }}
                                    </td>
                                    <td class="center"> 
                                        <a href="{{ route('project-detail', $project->id) }}" class="project-open_btn">Open</a>
                                        <!-- mettre id dasn le lien du bouton}-->
                                    </td>
                                    <td class="center"> 
                                        <form action="{{ route('project-detail-delete') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $project->id }}"> 
                                            <button type="submit" class="project-remove_btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>

    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            
            <h2 class="create-project-title">Create a new Project</h2>
            
            <form id="projects-create-form" class="project-create-form" action="{{ route('project.create') }}" method="post">
                @csrf
                <div class="form-name">
                    <label for="projectName">Project Name:</label>
                    <input id="projectName" type="text" name="project-name" required>
                    <div id="project-name-error-void" class="error-text hidden">Le nom du projet est obligatoire.</div>   
                </div>

                <div class="form-name" style="margin-top: 15px;">
                    <label for="projectClient">Client Name (Optional):</label>
                    <input id="projectClient" type="text" name="project-client" placeholder="Ex: Google, Amazon...">
                </div>

                <div class="form-details" style="margin-top: 15px;">
                    <label for="projectDetail">Project Details:</label>
                    <textarea id="projectDetail" name="project-details" required></textarea>
                    <div id="project-detail-error-void" class="error-text hidden">Le detail du projet est obligatoire</div>
                </div>

                <div class="form-collaborators" style="margin-top: 15px;">
                    <label for="projectCollaborators">Collaborators (comma separated):</label>
                    <input id="projectCollaborators" type="text" name="collaborators" placeholder="Jean, Marie...">
                    <div id="project-collaborators-error-void" class="error-text hidden">Les collaborateurs sont obligatoires</div>
                </div>
                
                <button type="submit" style="margin-top: 20px;">Create Project</button>
            </form>
            
            <div id="success" class="success hidden">
                <h4>Project created</h4>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/project_list.js') }}"></script>

</body>
</html>