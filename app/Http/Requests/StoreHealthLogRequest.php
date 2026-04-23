<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHealthLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-health-log');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'cage_id' => ['required', 'exists:cages,id'],
            'date' => ['required', 'date'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'treatment' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'cage_id.required' => 'Kandang wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'type.required' => 'Jenis kejadian wajib diisi.',
        ];
    }
}
