# My Ticketing App - Laravel API

Voici mon application web de gestion de tickets et de projets développée avec Laravel. Cette application permet aux utilisateurs de gérer leurs projets, créer et suivre des tickets, et uploader des contrats associés aux projets.

## Fonctionnalités

### Authentification et Gestion des Utilisateurs
- Inscription d'utilisateurs
- Connexion et déconnexion
- Récupération de mot de passe perdu (simulation)
- Gestion du profil utilisateur
- Modification du mot de passe

### Gestion des Projets
- Création de nouveaux projets
- Liste des projets de l'utilisateur
- Détail d'un projet avec ses tickets associés
- Modification des informations du projet (nom, description, collaborateurs, heures allouées/dépensées)
- Suppression de projets
- Upload et suppression de fichiers de contrat (PDF, DOC, DOCX)

### Gestion des Tickets
- Création de tickets associés à un projet
- Liste des tickets avec filtrage par priorité (All, Low, Medium, High)
- Détail d'un ticket
- Modification des tickets (titre, statut, priorité, type de facturation, temps passé, description, assigné à, dates de début/fin)
- Suppression de tickets

### Tableau de Bord
- Aperçu des projets récents
- Tickets récents
- Statistiques quotidiennes :
  - Nouveaux tickets créés aujourd'hui
  - Tickets fermés aujourd'hui
  - Tickets en retard (date de fin dépassée)


## Structure de la Base de Données

### Users
- lastname, firstname, email, birthdate, password

### Projects
- user_id, ProjectName, Client, Description, Collaborateur, spent_hours, allocated_hours, contract_file_path, contract_file_name

### Tickets
- project_id, user_id, title, description, status, priority, billing_type, time_spent, assigned_to, start_date, end_date


