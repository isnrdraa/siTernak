<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-production');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'cage_id' => ['required', 'exists:cages,id'],
            'product_id' => ['required', 'exists:products,id'],
            'date' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'damaged_count' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'cage_id.required' => 'Kandang wajib dipilih.',
            'product_id.required' => 'Produk wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah tidak boleh negatif.',
            'damaged_count.required' => 'Jumlah rusak wajib diisi.',
            'damaged_count.min' => 'Jumlah rusak tidak boleh negatif.',
        ];
    }
}
