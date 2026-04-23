<?php

namespace App\Models;

use App\Enums\CageStatus;
use App\Models\Concerns\BelongsToTenant;
use Database\Factories\CageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cage extends Model
{
    /** @use HasFactory<CageFactory> */
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'location',
        'capacity',
        'current_count',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => CageStatus::class,
            'capacity' => 'integer',
            'current_count' => 'integer',
        ];
    }

    public function dailyProductions(): HasMany
    {
        return $this->hasMany(DailyProduction::class);
    }

    public function feedLogs(): HasMany
    {
        return $this->hasMany(FeedLog::class);
    }

    public function healthLogs(): HasMany
    {
        return $this->hasMany(HealthLog::class);
    }

    public function mortalityLogs(): HasMany
    {
        return $this->hasMany(MortalityLog::class);
    }

    public function cageMovements(): HasMany
    {
        return $this->hasMany(CageMovement::class);
    }

    public function livestockSales(): HasMany
    {
        return $this->hasMany(LivestockSale::class);
    }

    public function isActive(): bool
    {
        return $this->status === CageStatus::Active;
    }

    public function canAddStock(int $qty): bool
    {
        return ($this->current_count + $qty) <= $this->capacity;
    }

    public function availableSpace(): int
    {
        return max(0, $this->capacity - $this->current_count);
    }

    public function occupancyPercent(): float
    {
        if ($this->capacity <= 0) {
            return 0;
        }

        return round(($this->current_count / $this->capacity) * 100, 1);
    }
}
