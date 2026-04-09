
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <title>Dashboard</title>
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
                    <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
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

        <main class="dashboard-main">

            <section class="dashboard-info-left">
                <div class="dashboard-box stat-box-left">
                    <h3 class="box-title-left">Ticket Past Due</h3>
                    <div class="stat-content-left">
                        <div class="stat-icon">⚠️</div> 
                        <span class="stat-number-left">{{ $pastDueTickets }}</span>
                    </div>
                </div>

                <div class="dashboard-box stat-box-left">
                    <h3 class="box-title-left">New Tickets Today</h3>
                    <div class="stat-content-left">
                        <div class="stat-icon">Wait</div>
                        <span class="stat-number-left">{{ $newTicketsToday }}</span>
                    </div>
                </div>

                <div class="dashboard-box stat-box-left">
                    <h3 class="box-title-left">Tickets Closed Today</h3>
                    <div class="stat-content-left">
                        <div class="stat-icon">✔</div>
                        <span class="stat-number-left">{{ $closedTicketsToday }}</span>
                    </div>
                </div>
            </section>

            <section class="dashboard-info-center">
                
                <div class="dashboard-box">
                    <h2 class="section-title">Ticket Payant</h2>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Project</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->billing_type == "billable")
                                    <tr>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->project->ProjectName }}</td>
                                        <td><a class="action-btn" href = "{{ route('ticket-detail', $ticket->id) }}">Open</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-box">
                    <h2 class="section-title">Ticket Gratuit</h2>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Project</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->billing_type != "billable")
                                    <tr>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->project->ProjectName }}</td>
                                        <td><a class="action-btn" href = "{{ route('ticket-detail', $ticket->id) }}">Open</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </section>

            <section class="dashboard-info-right">
                <div class="dashboard-box">
                    <h2 class="section-title">Ticket Recent</h2> 
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($TicketRecents as $TicketRecent)
                                <tr>
                                    <td style="display: flex; justify-content: center; flex-direction: column;">
                                            {{ $TicketRecent->title }}
                                            <span style="font-size: 12px; color: #8F9BBA; font-weight: normal;">{{ $TicketRecent->project->ProjectName }}</span>
                                        </td>
                                    <td style="text-align: right;"><a href="{{ route('ticket-detail', $TicketRecent->id) }}" class="action-btn">Open</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-box">
                    <h2 class="section-title">Liste des clients</h2> 
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th style="text-align: right;">Project</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @foreach ($projects as $project)
                                <tr>
                                    <td style="display: flex; justify-content: center; flex-direction: column;">
                                        {{ $project->Client }}
                                        <span style="font-size: 12px; color: #8F9BBA; font-weight: normal;">Project : {{ $project->ProjectName }}</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('project-detail', $project->id) }}" class="action-btn">View</a>
                                       
                                    </td>
                                </tr>
                            @endforeach        
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>


    <script src="{{ asset('js/script.js') }}"></script>
    

</body>
</html>