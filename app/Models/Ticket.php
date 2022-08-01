<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Ticket
 * @package App\Model
 *
 * @property integer id
 * @property string movie_name
 * @property float cost
 * @property integer t_cap
 * @property integer c_cap
 */
class Ticket extends Model
{
    use HasFactory;

    /**
     * Relation has many tue
     * @return HasMany
     */
    public function tue(): HasMany
    {
        return $this->hasMany(Tue::class);
    }
}
