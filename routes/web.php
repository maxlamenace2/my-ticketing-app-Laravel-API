<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\parametreController;
use App\Http\Controllers\ticketListController;
use App\Http\Controllers\accountController;  
use App\Http\Controllers\projectListController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\projectDetailController;
use App\Http\Controllers\ticketDetailController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



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

require __DIR__.'/auth.php';
