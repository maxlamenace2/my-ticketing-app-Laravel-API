<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\projectListController; 
use App\Http\Controllers\ticketListController;


// On utilise les middlewares 'web' et 'auth' pour que l'API puisse lire la session de l'utilisateur connecté
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/projects', [projectListController::class, 'storeApi'])->name('api.projects.store');
    Route::delete('/projects/{id}', [projectListController::class, 'destroyApiProject'])->name('api.projects.destroy');

    Route::post('/tickets', [ticketListController::class, 'storeApi'])->name('api.tickets.store');
    Route::delete('/tickets/{id}', [ticketListController::class, 'destroyApiTicket'])->name('api.tickets.destroy');
});