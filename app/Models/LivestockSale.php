<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LivestockSale extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'cage_id',
        'date',
        'quantity',
        'price_per_unit',
        'total_amount',
        'buyer_name',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quantity' => 'integer',
            'price_per_unit' => 'decimal:2',
            'total_amount' => 'decimal:2',
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
