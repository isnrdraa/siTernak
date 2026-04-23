<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-feed-log');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'cage_id' => ['required', 'exists:cages,id'],
            'date' => ['required', 'date'],
            'feed_type' => ['required', 'string', 'max:255'],
            'feed_stock_id' => ['nullable', 'exists:feed_stocks,id'],
            'quantity_kg' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'cage_id.required' => 'Kandang wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'feed_type.required' => 'Jenis pakan wajib diisi.',
            'quantity_kg.required' => 'Jumlah pakan wajib diisi.',
            'quantity_kg.min' => 'Jumlah pakan minimal 0.01 kg.',
        ];
    }
}
