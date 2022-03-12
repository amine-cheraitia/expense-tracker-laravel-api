<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    /**
     * Get all of the comments for the Ressource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'ressource_id');
    }
    /**
     * Get the user that owns the Ressource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type_ressource()
    {
        return $this->belongsTo(Type_Ressource::class, 'type_ressources_id');
    }
    /**
     * Get the user that owns the Ressource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}