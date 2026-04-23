<?php

namespace App\Models;

use App\Enums\CageMovementType;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CageMovement extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'cage_id',
        'date',
        'type',
        'quantity',
        'description',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'type' => CageMovementType::class,
            'quantity' => 'integer',
        ];
    }

    public function cage(): BelongsTo
    {
        return $this->belongsTo(Cage::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
