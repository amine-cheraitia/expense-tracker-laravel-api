<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the Mouvement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id');
    }
    /**
     * Get the user that owns the Mouvement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the user that owns the Mouvement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type_mouvement()
    {
        return $this->belongsTo(type_mouvement::class, 'type_mouvement_id');
    }
}