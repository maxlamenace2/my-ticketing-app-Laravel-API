<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project-detail.css') }}">
    <title>projet detail</title>
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
                    <li><a href="{{ route('project-detail', ['id' => $project->id]) }}" class="active">Project Details</a></li>
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


        <main>
            <section class="my-project-info">
                <div class="my-project-info-container-1">
                    <div class=" editable1 my-project-info-container-1-name">
                        <h1>Nom</h1>
                        <h1 class="editable">{{ $project->ProjectName }}</h1>
                    </div>

                    <div class=" editable1 my-project-info-container-1-details">
                        <h1>Détails : </h1>
                        <p class="editable">{{ $project->Description }}</p>
                    </div>
                    <div class="my-project-info-container-1-colaborators">
                        <h1>Colaborateurs :</h1>
                        <div class="collab-container">
                                <span class="cololaborators-list">{{ $project->Collaborateur }}</span>
                        </div>
                    </div>
                    <div class=" editable1 my-project-info-container-1-hours">
                        <h1>hour Spend</h1>
                        <h1 class="editable">{{ $project->spent_hours }}/{{ $project->allocated_hours }}h</h1>
                    </div>
                </div>

                <div class="my-project-info-container-2">
                    <div>
                        <button id="openProjectModalBtn" class="my-project-info-button-edit" onclick="openProjectEditModal()"> Edit projet </button>
                    </div>
                </div>
            </section>
            <section class="my-project-info-2">
                <div class="my-project-info-container-3">
                    <div class="my-project-info-container-2-contract">
                        <button id="btn-download" class="my-project-info-button" disabled>Download Contract</button>

                        <button id="btn-upload" class="my-project-info-button">Upload Contract</button>

                        <input type="file" id="real-file-input" style="display: none;">

                        <span id="file-name-display" class="file-name"></span>
                    </div>
                </div>
            </section>


            <section class="my-project-tickets">
                <div class="projects-list-header">
                    <h1 class="projects-list-title">Ticket List</h1>
                    <btn href="#" id="openTicketModalBtn" class="projects-list-create-btn" onclick="openTicketModal()">New ticket</btn>
                </div>
                <div class="above-ticket-table">
                    <h2>Tickets for all project</h2>
                    <h2 class="filtre">filtre :</h2>
                    <a href="?filter=High" class="btn-filtre-priority priority-high">High</a>
                    <a href="?filter=Medium" class="btn-filtre-priority priority-medium">Medium</a>
                    <a href="?filter=Low" class="btn-filtre-priority priority-low">Low</a>
                    <a href="?filter=All" class="btn-filtre-priority priority-All">All</a>
                </div>
                <table id="content" class="ticket-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Open</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tickets->isEmpty())
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">Aucun ticket n'a été créé pour ce projet.</td>
                            </tr>
                        @else
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td>
                                        <span style="font-weight: bold; color: #2D5BFF;">{{ $ticket->status }}</span>
                                    </td>
                                    <td class="status">{{ ucfirst($ticket->priority) }}</td>
                                    <td>{{ $ticket->assigned_to ?? 'Non assigné' }}</td>
                                    <td>
                                        <a href="{{ route('ticket-detail', ['id' => $ticket->id]) }}">
                                            <button class="project-open_btn">Open</button>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('api.tickets.destroy', $ticket->id) }}" method="POST" class="api-delete-ticket" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="project-remove_btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
            <div id="update-project-toats-success" class="toastUpdate">
                Projet mis à jour avec succès !
            </div>
        </main>
    </div>



    <div id="ProjetModal" class="modal0">
        <div class="Project-modal-cotent">
            <span class="Project-modale-close-btn" onclick="closeProjectEditModal()">&times;</span>

            <h2 class="Project-Modal-title">Modify the project</h2>

            <form id="api-update-project-form" class="project-modal-modify-form" action="{{ route('api.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="form-group0">
                    <label>Nom du projet</label>
                    <input type="text" name="project_name" value="{{ $project->ProjectName }}" required>
                </div>

                <div class="form-group0">
                    <label>Détails</label>
                    <textarea name="project_description" rows="4">{{ $project->Description }}</textarea>
                </div>

                <div class="form-group0">
                    <label>Collaborateurs (séparés par des virgules)</label>
                    <input type="text" name="collaborateurs" value="{{ $project->Collaborateur }}" placeholder="Ex: Bob, Alice, Yoan">
                </div>

                <div class="form-row0">
                    <div class="form-group0">
                        <label>Heures passées</label>
                        <input type="number" step="0.5" name="hours_spent" value="{{ $project->spent_hours }}">
                    </div>
                    <div class="form-group0">
                        <label>Budget total (heures)</label>
                        <input type="number" name="hours_budget" value="{{ $project->allocated_hours }}">
                    </div>
                </div>

                <button type="submit" class="project-submit-btn" onclick="closeProjectEditModal()">Sauvegarder les modifications</button>

            </form>
        </div>
    </div>

    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close-btn-ticket"  onclick="closeTicketModal()">&times;</span>

            <h2 class="ticketModal-title">Create a new Ticket</h2>

            <form id="tickets_create_form" class="ticket-create-form" action="{{ route('api.tickets.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="form-group">
                    <label for="ticketName">Title</label>
                    <input id="ticketName" type="text" name="title" placeholder="Enter ticket title">
                    <div id="ticket-name-error-void" class="error-text hidden">Le titre du ticket est obligatoire</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ticket-status">Status</label>
                        <select id="ticket-status" name="status">
                            <option value="Nouveau">Nouveau</option>
                            <option value="En cours">En cours</option>
                            <option value="Closed">Closed</option>
                            <option value="En attente client">En attente client</option>
                            <option value="Terminé">Terminé</option>
                            <option value="À valider (client)">À valider (client)</option>
                            <option value="Validé">Validé</option>
                            <option value="Refusé">Refusé</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ticket-priority">Priority</label>
                        <select id="ticket-priority" name="priority">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ticket-type">Billing Type</label>
                        <select id="ticket-type" name="billing_type">
                            <option value="included">Inclus / Gratuit</option>
                            <option value="billable">Facturable / Payant</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="real-time">Real Time Spent</label>
                        <input id="ticketTime" type="text" name="time_spent" placeholder="Ex: 2h 30m">
                        <div id="ticket-time-error-void" class="error-text hidden">Les heures sont obligatoires</div>
                        <div id="ticket-time-error-format" class="error-text hidden">Mauvais format : Format demandé :
                            ..h ..m</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ticket-details">Description</label>
                    <textarea id="ticket-details" name="description"
                        placeholder="Describe the details..."></textarea>
                    <div id="ticket-description-error-void" class="error-text hidden">La Description est obligatoire
                    </div>
                </div>

                <div class="form-group">
                    <label for="ticketCollaborator">Assigned To (Collaborators)</label>
                    <input id="ticketCollaborateur" type="text" name="assigned_to" placeholder="Enter collaborateur (Comma separeted)" required>
                </div>

                <div class="form-btn-container">
                    <button type="submit" class="submit-btn" onclick="closeTicketModal()" >Create Ticket</button>
                </div>
            </form>

            <div id="success" class="success hidden">
                <h4>Ticket created</h4>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/project-detail.js') }}"></script>

</body>

</html>