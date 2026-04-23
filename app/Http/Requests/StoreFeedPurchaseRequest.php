<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedPurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-feed-purchase');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'feed_stock_id' => ['required', 'exists:feed_stocks,id'],
            'date' => ['required', 'date'],
            'quantity_kg' => ['required', 'numeric', 'min:0.01'],
            'total_cost' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'feed_stock_id.required' => 'Jenis pakan wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'quantity_kg.required' => 'Jumlah pakan wajib diisi.',
            'quantity_kg.min' => 'Jumlah pakan minimal 0.01 kg.',
            'total_cost.required' => 'Total biaya wajib diisi.',
        ];
    }
}
