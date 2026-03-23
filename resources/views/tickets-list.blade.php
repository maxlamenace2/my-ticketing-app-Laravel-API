
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ticket-list.css') }}">
    <title>Ticket list</title>
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
                    <li><a href="{{ route('tickets-list') }}" class = "active">Tickets</a></li>
                    <li><a href="{{ route('dashboard') }}" >Dashboard</a></li>
                    <li><a href="{{ route('login') }}">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="projects-list-main">
            <section class = "my-tickets-list">
                <div class="ticket-list-header">
                    <h1 class="projects-list-title">Ticket List</h1>
                    <a href="#" id="openTicketModalBtn" class="projects-list-create-btn">New ticket</a>
                </div>

                <div class="above-ticket-table">
                    <h2>Tickets for all project</h2>
                    <h2 class="filtre">filtre :</h2>
                    <a href="?filter=high" class="btn-filtre-priority priority-high">High</a>
                    <a href="?filter=medium" class="btn-filtre-priority priority-medium">Medium</a>
                    <a href="?filter=low" class="btn-filtre-priority priority-low">Low</a>
                    <a href="?filter=All" class="btn-filtre-priority priority-All">All</a>
                </div>
                
                <table id="content" class="ticket-table-list">
                    <thead>
                        <tr>
                            <th>Project name</th>
                            <th>Title</th> 
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Open</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->project->ProjectName }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <select class="status-select" value ="{{ $ticket->status }}">
                                        <option value="Nouveau">Nouveau</option>
                                        <option value="En cours" selected>En cours</option>
                                        <option value="Closed">Closed</option>
                                        <option value="En attente client">En attente client</option>
                                        <option value="Terminé">Terminé</option>
                                        <option value="À valider (client)">À valider (client)</option>
                                        <option value="Validé">Validé</option>
                                        <option value="Refusé">Refusé</option>
                                    </select>
                                </td>
                                <td class="status">{{ $ticket->priority }}</td>
                                <td>{{ $ticket->assigned_to }}</td>
                                <td>
                                    <a href="{{ route('ticket-detail', ['id' => $ticket->id]) }}">
                                        <button class="ticket-open_btn">Open</button>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('ticket.list.delete') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                        
                                        <button type="submit" class="ticket-remove_btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            
            <h2>Create a new Ticket</h2>

            <form class="ticket-create-form" action="{{ route('tickets.create') }}" method="POST">
                @csrf

                

                <div class="form-row">
                    <div class="form-group">
                        <label for="project-select">Associated Project <span style="color:red">*</span></label>
                        <select id="project-select" name="project_id" required>
                            <option value="">-- Select a Project --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" >{{ $project->ProjectName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ticketName">Title <span style="color:red">*</span></label>
                    <input id="ticketName" type="text" name="title" placeholder="Enter ticket title" required>
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
                    </div>
                </div>

                <div class="form-group">
                    <label for="ticket-details">Description</label>
                    <textarea id="ticket-details" name="description" placeholder="Describe the details..."></textarea>
                </div>

                <div class="form-group">
                    <label for="ticketcollab">Collaborateur</label>
                    <input id="ticketCollaborateur" type="text" name="assigned_to" placeholder="Enter collaborateur (Comma separeted)" required>
                </div>

                

                <div class="form-btn-container">
                    <button type="submit" class="submit-btn" >Create Ticket</button>
                </div>
            </form>

        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/ticket-list.js') }}"></script>
</body>
</html>