<?php

namespace App\Models;

use App\ValueObjects\TradeSide;
use Illuminate\Database\Eloquent\Model;

/** 
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property TradeSide $side
 * @property int $order_id
 * @property int $counter_order_id
 * @property string $price
 * @property string $volume
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
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
        'order_id',
        'counter_order_id',
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
            'side' => TradeSide::class,
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Order>
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Order>
     */
    public function counterOrder()
    {
        return $this->belongsTo(Order::class, 'counter_order_id', 'id');
    }
}
