<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMortalityLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-mortality-log');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'cage_id' => ['required', 'exists:cages,id'],
            'date' => ['required', 'date'],
            'count' => ['required', 'integer', 'min:1'],
            'cause' => ['nullable', 'string', 'max:255'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'cage_id.required' => 'Kandang wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'count.required' => 'Jumlah kematian wajib diisi.',
            'count.min' => 'Jumlah kematian minimal 1.',
        ];
    }
}
