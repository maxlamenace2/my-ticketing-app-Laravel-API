<?php

use App\Http\Controllers\parametreController;
use App\Http\Controllers\ticketListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\inscriptionController;
use App\Http\Controllers\mdpLostController;
use App\Http\Controllers\accountController;  
use App\Http\Controllers\projectListController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\projectDetailController;
use App\Http\Controllers\ticketDetailController;
      

Route::get('/', [loginController::class, 'login'])->name('login');
Route::post('/login-check', [loginController::class, 'loginProcess'])->name('login.post');

Route::get('/inscription', [inscriptionController::class, 'inscription'])->name('inscription');
Route::post('/inscription', [inscriptionController::class, 'inscriptionProcess'])->name('inscription.post');

Route::get('/mdp-lost', [mdpLostController::class, 'mdpLost'])->name('mdp-lost');
Route::post('/mdp-lost', [mdpLostController::class, 'mdpLostProcess'])->name('mdpLost.post');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [accountController::class, 'myAccount'])->name('my-account');
    Route::post('/my-account/update-password', [accountController::class, 'updatePassword'])->name('my-account.password.update');

    Route::get('/parametre', [parametreController::class, 'Parametre'])->name('parametre');

    Route::get('/projects-list', [projectListController::class, 'projectsList'])->name('projects-list');
    Route::post('/projects-list', [projectListController::class, 'projectsListCreate'])->name('project.create');
    Route::delete('/projects-list-delete', [projectListController::class, 'projectsListDelete'])->name('project-detail-delete');

    Route::get('/tickets-list', [ticketListController::class, 'ticketList'])->name('tickets-list');
    Route::post('/tickets-list', [ticketListController::class, 'ticketListCreate'])->name('tickets.create');
    Route::delete('/tickets-list-delete', [ticketListController::class, 'TicketListDelete'])->name('ticket.list.delete');

    Route::get('/dashboard', [dashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/project-detail/{id}', [projectDetailController::class, 'projectDetail'])->name('project-detail');
    Route::post('/project-detail/update', [projectDetailController::class, 'updateProject'])->name('project-detail.update');
    Route::post('/project-detail/ticketCreate', [projectDetailController::class, 'createTicket'])->name('project-detail.ticket.create');
    Route::delete('/project-detail/ticketDelete', [projectDetailController::class, 'projectDetaildeleteT'])->name('project-detail.ticket.delete');

    Route::get('/ticket-detail/{id}', [ticketDetailController::class, 'ticketDetail'])->name('ticket-detail');
    Route::post('/ticket-detail/update', [ticketDetailController::class, 'updateTicket'])->name('ticket-detail.update');
});

