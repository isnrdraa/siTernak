<?php

namespace App\Models;

use App\Enums\ExpenseCategory;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Expense extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'date',
        'category',
        'description',
        'amount',
        'reference_type',
        'reference_id',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'category' => ExpenseCategory::class,
            'amount' => 'decimal:2',
        ];
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
