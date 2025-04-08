<?php

namespace App\Http\Requests\V1;

use App\Http\DataObjects\SpotOrderPlacementDTO;
use App\Http\Middleware\EnsureRequestIsIdempotent;
use App\ValueObjects\OrderDirection;
use App\ValueObjects\OrderType;
use Illuminate\Foundation\Http\FormRequest;

class SpotOrderPlacementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'symbol_id' => 'required',
            'direction' => 'required|in:' . OrderDirection::implodes(),
            'type' => 'required|in:' . OrderType::implodes(),
            'price' => 'required|numeric|min:0.01',
            'volume' => 'required|numeric|min:0.01',
            'x-idempotency-key' => 'required',
        ];
    }

    public function validationData()
    {
        return array_merge($this->headers->all(), $this->all());
    }

    public function toDTO(): SpotOrderPlacementDTO
    {
        return new SpotOrderPlacementDTO(
            symbol: $this->string(key: 'symbol_id'),
            direction: $this->enum(key: 'direction', enumClass: OrderDirection::class),
            type: $this->enum(key: 'type', enumClass: OrderType::class),
            price: $this->string(key: 'price'),
            volume: $this->string(key: 'volume'),
            idempotencyKey: $this->header(key: EnsureRequestIsIdempotent::IDEMPOTENT_KEY),
        );
    }
}
