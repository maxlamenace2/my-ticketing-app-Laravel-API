<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\projectListController; 
use App\Http\Controllers\ticketListController;
use App\Http\Controllers\ticketDetailController;
use App\Http\Controllers\projectDetailController;


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/projects', [projectListController::class, 'storeApi'])->name('api.projects.store');
    Route::delete('/projects/{id}', [projectListController::class, 'destroyApiProject'])->name('api.projects.destroy');

    Route::post('/projects/{id}/upload-contract', [projectDetailController::class, 'uploadContract'])->name('api.projects.uploadContract');

    Route::delete('/projects/{id}/delete-contract', [projectDetailController::class, 'deleteContract'])->name('api.projects.deleteContract');

    Route::put('/tickets/{id}', [ticketDetailController::class, 'updateApiTicket'])->name('api.tickets.update');
  
});