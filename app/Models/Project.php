<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        "user_id",
        "ProjectName",
        "Client",
        "Description",
        "Collaborateur",
        "spent_hours",     
        "allocated_hours", 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
