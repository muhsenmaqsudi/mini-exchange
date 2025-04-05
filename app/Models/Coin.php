<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property array $config
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Coin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'symbol',
        'config',
    ];

    public function casts(): array
    {
        return [
            'config' => 'array',
        ];
    }

    /**
     * @return HasMany<Order>
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany<Trade>
     */
    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
