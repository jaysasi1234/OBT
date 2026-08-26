<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'cadet_id',
        'user_id',
        'subject',
        'description',
        'attachment',
        'action_taken',
        'remarks',
        'support_file',
        'status',
        'resolved_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT VALUES
    |--------------------------------------------------------------------------
    */
    protected $attributes = [
        'status' => 'Open',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS (BEST PRACTICE)
    |--------------------------------------------------------------------------
    */
    const STATUS_OPEN = 'Open';
    const STATUS_PENDING = 'Pending';
    const STATUS_RESOLVED = 'Resolved';
    const STATUS_REJECTED = 'Rejected';

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS (OPTIONAL BUT USEFUL)
    |--------------------------------------------------------------------------
    */

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }

    public function isResolved(): bool
    {
        return $this->status === self::STATUS_RESOLVED;
    }

    public function handler()
{
    return $this->belongsTo(User::class, 'handled_by');
}
}