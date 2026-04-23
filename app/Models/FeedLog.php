<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Database\Factories\FeedLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedLog extends Model
{
    /** @use HasFactory<FeedLogFactory> */
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'cage_id',
        'date',
        'feed_type',
        'feed_stock_id',
        'quantity_kg',
        'recorded_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quantity_kg' => 'decimal:2',
        ];
    }

    public function cage(): BelongsTo
    {
        return $this->belongsTo(Cage::class);
    }

    public function feedStock(): BelongsTo
    {
        return $this->belongsTo(FeedStock::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
