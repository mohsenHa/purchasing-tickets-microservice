<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Tue
 * @package App\Models
 *
 * @property integer id
 * @property integer user_id
 * @property integer ticket_id
 * @property float cost
 * @property integer t_cap
 * @property integer c_cap
 * @property float vat
 * @property float to_cost
 *
 */
class Tue extends Model
{
    use HasFactory;


    /**
     * @var string[]
     */
    protected $fillable = [
        'cost',
        't_cap',
        'c_cap',
        'vat',
        'to_cost',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
