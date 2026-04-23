<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedStock extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'feed_type',
        'current_stock_kg',
        'min_stock_kg',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'current_stock_kg' => 'decimal:2',
            'min_stock_kg' => 'decimal:2',
            'unit_price' => 'decimal:2',
        ];
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(FeedPurchase::class);
    }

    public function feedLogs(): HasMany
    {
        return $this->hasMany(FeedLog::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock_kg <= $this->min_stock_kg;
    }
}
