<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property string $idempotency_key
 * @property string $direction
 * @property string $type
 * @property string $price
 * @property string $volume
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'coin_id',
        'idempotency_key',
        'direction',
        'type',
        'price',
        'volume',
        'status',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Coin>
     */
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Trade>
     */
    public function makerTrade()
    {
        return $this->hasOne(Trade::class, 'maker_order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Trade>
     */
    public function takerTrade()
    {
        return $this->hasOne(Trade::class, 'taker_order_id', 'id');
    }
}
