<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Ressource extends Model
{
    use HasFactory;
    /**
     * Get all of the comments for the Type_Ressource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ressources()
    {
        return $this->hasMany(Ressource::class, 'type_ressources_id');
    }
}