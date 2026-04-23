<?php

namespace App\Http\Requests;

use App\Services\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-products');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $tenantId = app(TenantManager::class)->id();
        $productId = $this->route('product')?->id;

        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('products')->where('tenant_id', $tenantId)->ignore($productId),
            ],
            'unit' => ['required', 'string', 'max:50'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Produk ini sudah terdaftar.',
            'unit.required' => 'Satuan wajib diisi.',
            'price_per_unit.required' => 'Harga per satuan wajib diisi.',
        ];
    }
}
