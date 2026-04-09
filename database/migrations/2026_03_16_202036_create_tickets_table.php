<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Relie le ticket au projet (si le projet est supprimé, ses tickets aussi)
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('Nouveau');
            $table->string('priority')->nullable(); 
            $table->string('billing_type')->nullable(); 
            $table->string('time_spent')->nullable(); 
            $table->string('assigned_to')->nullable(); 

            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable();   
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
