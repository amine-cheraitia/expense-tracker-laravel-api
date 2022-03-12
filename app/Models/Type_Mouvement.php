<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Mouvement extends Model
{
    use HasFactory;
    /**
     * Get all of the comments for the Type_Mouvement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'type_mouvement_id');
    }
}