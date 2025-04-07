<?php

namespace App\Models;

use App\ValueObjects\OrderDirection;
use App\ValueObjects\OrderStatus;
use App\ValueObjects\OrderType;
use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property string $idempotency_key
 * @property OrderDirection $direction
 * @property OrderType $type
 * @property string $price
 * @property string $volume
 * @property OrderStatus $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Order extends Model
{
    use HasSnowflakes;
    
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
            'direction' => OrderDirection::class,
            'type' => OrderType::class,
            'price' => 'decimal:8',
            'volume' => 'decimal:8',
            'status' => OrderStatus::class,
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
    public function trade()
    {
        return $this->hasOne(Trade::class, 'order_id', 'id');
    }
}
