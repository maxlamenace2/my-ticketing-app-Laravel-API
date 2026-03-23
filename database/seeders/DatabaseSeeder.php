<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. On crée un utilisateur de test (pour pouvoir se connecter !)
        $user = User::create([
            'lastname' => 'Test',
            'firstname' => 'Jean',
            'email' => 'jean@test.com',
            'birthdate' => '1990-01-01',
            'password' => Hash::make('password123'), 
        ]);

        // 2. On crée 3 projets liés à cet utilisateur
        Project::create([
            'user_id' => $user->id, // On relie le projet à Jean
            'ProjectName' => 'Refonte du site web',
            'Client' => 'Google',
            'Description' => 'Refonte complète de l\'interface utilisateur du site vitrine.',
            'Collaborateur' => 'Alice, Bob',
            'spent_hours' => 22,       
            'allocated_hours' => 35,   
        ]);

        Project::create([
            'user_id' => $user->id,
            'ProjectName' => 'Application Mobile V2',
            'Client' => 'Amazon',
            'Description' => 'Développement de la nouvelle application iOS et Android.',
            'Collaborateur' => 'Charlie',
            'spent_hours' => 15,       
            'allocated_hours' => 50,   
        ]);

        Project::create([
            'user_id' => $user->id,
            'ProjectName' => 'Outil de Ticketing interne',
            'Client' => 'En interne',
            'Description' => 'Création d\'un super dashboard pour gérer les tickets (mon projet Laravel !).',
            'Collaborateur' => 'Moi-même',
            'spent_hours' => 10,      
            'allocated_hours' => 10,   
        ]);


        $firstProject = Project::first();

        if ($firstProject) {
            Ticket::create([
                'project_id' => $firstProject->id,
                'title' => 'Intégration API Paiement',
                'description' => 'Mettre en place la passerelle Stripe pour les abonnements.',
                'status' => 'En cours',
                'priority' => 'high',
                'billing_type' => 'billable',
                'time_spent' => '4h 30m',
                'assigned_to' => 'Maxence',
            ]);

            Ticket::create([
                'project_id' => $firstProject->id,
                'title' => 'Correction CSS Dashboard',
                'description' => 'L\'alignement des boîtes de statistiques est cassé sur Safari.',
                'status' => 'Nouveau',
                'priority' => 'medium',
                'billing_type' => 'included',
                'time_spent' => '0h',
                'assigned_to' => 'Timéo',
            ]);
        }
    }

    
}