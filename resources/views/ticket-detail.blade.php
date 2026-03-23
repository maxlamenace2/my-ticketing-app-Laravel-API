

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ticket-detail.css') }}">
    <title>Ticket Detail</title>
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
                    <li><a href="{{ route('ticket-detail', ['id' => $project->id]) }}" class="active">Ticket Detail</a></li>
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

        <main class="ticket-detail-main">
            <div class="ticket-detail-header">
                <h1>Ticket Overview</h1>
                <a href="{{ route('project-detail', ['id' => $project->id]) }}" class="back-btn">← Back to Project</a>
            </div>

            <section class="ticket-detail-section">

                <div class="detail-row ticket-detail-section-title">
                    <div class="info-group">
                        <span class="label">Title</span>
                        <span class="value">{{ $ticket->title }}</span>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">Edit</button>
                </div>

                <div class="detail-row ticket-detail-section-associated-project">
                    <div class="info-group">
                        <span class="label">Associated Project</span>
                        <span class="value">{{ $project->ProjectName }}</span>
                    </div>
                </div>

                <div class="detail-row ticket-detail-section-status">
                    <div class="info-group">
                        <span class="label">Status</span>
                        <span class="value status-badge">{{ $ticket->status }}</span>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">Edit</button>
                </div>

                <div class="detail-row ticket-detail-section-priority">
                    <div class="info-group">
                        <span class="label">Priority</span>
                        <span class="value">{{ $ticket->priority }}</span>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">Edit</button>
                </div>

                <div class="detail-row ticket-detail-section-billing-type">
                    <div class="info-group">
                        <span class="label">Billing Type</span>
                        <span class="value">{{ $ticket->billing_type }}</span>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">Edit</button>
                </div> 

                <div class="detail-row ticket-detail-section-time-spent">
                    <div class="info-group">
                        <span class="label">Time Spent</span>
                        <span class="value">{{ $ticket->time_spent }}</span>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">Edit</button>
                </div>

                <div class="detail-row ticket-detail-section-description">
                    <div class="info-group">
                        <span class="label">Description</span>
                        <p class="value description-text">{{ $ticket->description }}</p>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()" >Edit</button>
                </div>

                <div class="detail-row ticket-detail-section-collaborators">
                    <div class="info-group">
                        <span class="label">Assigned To (comma Separated)</span>
                        <div class="collaborators-list">
                            <span class="value">{{ $ticket->assigned_to }}</span>
                        </div>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()" >Edit</button>
                </div>
                            
            </section>       
        </main>
    </div>

    <div id="ticketEditModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h2 class="ticketModal-title">Edit Ticket</h2>

            <form action="{{ route('ticket-detail.update') }}" method="POST">
                @csrf
                
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $ticket->title }}" required>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Status</label>
                        <select name="status">
                            <option value="Nouveau" {{ $ticket->status == 'Nouveau' ? 'selected' : '' }}>Nouveau</option>
                            <option value="En cours" {{ $ticket->status == 'En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="En attente client" {{ $ticket->status == 'En attente client' ? 'selected' : '' }}>En attente client</option>
                            <option value="Terminé" {{ $ticket->status == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="À valider (client)" {{ $ticket->status == 'À valider (client)' ? 'selected' : '' }}>À valider (client)</option>
                            <option value="Validé" {{ $ticket->status == 'Validé' ? 'selected' : '' }}>Validé</option>
                            <option value="Refusé" {{ $ticket->status == 'Refusé' ? 'selected' : '' }}>Refusé</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label>Priority</label>
                        <select name="priority">
                            <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Billing Type</label>
                        <select name="billing_type">
                            <option value="included" {{ $ticket->billing_type == 'included' ? 'selected' : '' }}>Inclus / Gratuit</option>
                            <option value="billable" {{ $ticket->billing_type == 'billable' ? 'selected' : '' }}>Facturable / Payant</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label>Real Time Spent (ex: 2h 30m)</label>
                        <input type="text" name="time_spent" value="{{ $ticket->time_spent }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4">{{ $ticket->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Assigned To</label>
                    @if($ticket->assigned_to)
                        <input type="text" name="title" value="{{ $ticket->assigned_to }}" required>
                    @endif
                </div>

                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>

    
    
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/ticket-detail.js') }}"></script>
 
</body>
</html>

    