<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Database\Factories\DailyProductionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyProduction extends Model
{
    /** @use HasFactory<DailyProductionFactory> */
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'cage_id',
        'product_id',
        'date',
        'quantity',
        'damaged_count',
        'recorded_by',
        'validated_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quantity' => 'decimal:2',
            'damaged_count' => 'decimal:2',
        ];
    }

    public function cage(): BelongsTo
    {
        return $this->belongsTo(Cage::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function isValidated(): bool
    {
        return $this->validated_by !== null;
    }

    public function goodCount(): float
    {
        return $this->quantity - $this->damaged_count;
    }
}
