<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trade
 *
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property string $side
 * @property string $maker_order_id
 * @property string $taker_order_id
 * @property string $price
 * @property string $volume
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Trade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'coin_id',
        'side',
        'maker_order_id',
        'taker_order_id',
        'price',
        'volume',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'price' => 'decimal:8',
            'volume' => 'decimal:8',
        ];
    }
}
