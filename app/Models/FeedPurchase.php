<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class FeedPurchase extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'feed_stock_id',
        'date',
        'quantity_kg',
        'total_cost',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quantity_kg' => 'decimal:2',
            'total_cost' => 'decimal:2',
        ];
    }

    public function feedStock(): BelongsTo
    {
        return $this->belongsTo(FeedStock::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function expense(): MorphOne
    {
        return $this->morphOne(Expense::class, 'reference');
    }
}
