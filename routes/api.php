<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\projectListController; 
use App\Http\Controllers\ticketListController;
use App\Http\Controllers\ticketDetailController;
use App\Http\Controllers\projectDetailController;

// On utilise les middlewares 'web' et 'auth' pour que l'API puisse lire la session de l'utilisateur connecté
Route::middleware(['web', 'auth'])->group(function () {
    // ---- PROJETS ----
    Route::post('/projects', [projectListController::class, 'storeApi'])->name('api.projects.store');
    Route::put('/projects/{id}', [projectDetailController::class, 'updateApiProject'])->name('api.projects.update');
    Route::delete('/projects/{id}', [projectListController::class, 'destroyApiProject'])->name('api.projects.destroy');

    // ---- TICKETS (LA ROUTE UNIVERSELLE) ----
    Route::post('/tickets', [ticketListController::class, 'storeApi'])->name('api.tickets.store');
    Route::put('/tickets/{id}', [ticketDetailController::class, 'updateApiTicket'])->name('api.tickets.update');
    Route::delete('/tickets/{id}', [ticketListController::class, 'destroyApiTicket'])->name('api.tickets.destroy');    
});