<?php

namespace App\Http\Requests;

use App\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFeedStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-feed-stock');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $tenantId = app(TenantManager::class)->id();
        $stockId = $this->route('feed_stock')?->id;

        return [
            'feed_type' => [
                'required', 'string', 'max:255',
                Rule::unique('feed_stocks')->where('tenant_id', $tenantId)->ignore($stockId),
            ],
            'min_stock_kg' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'feed_type.required' => 'Nama jenis pakan wajib diisi.',
            'feed_type.unique' => 'Jenis pakan ini sudah terdaftar.',
            'min_stock_kg.required' => 'Stok minimum wajib diisi.',
        ];
    }
}
