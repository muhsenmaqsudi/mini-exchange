<?php

use App\Models\Coin;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $coins = [
        [
            'id' => 1,
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'config' => [
                'precision' => 8,
                'icon' => 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
            ],
        ],
        [
            'id' => 2,
            'name' => 'Ethereum',
            'symbol' => 'ETH',
            'config' => [
                'precision' => 18,
                'icon' => 'https://cryptologos.cc/logos/ethereum-eth-logo.png',
            ],
        ],
        [
            'id' => 3,
            'name' => 'Tether',
            'symbol' => 'USDT',
            'config' => [
                'precision' => 6,
                'icon' => 'https://cryptologos.cc/logos/tether-usdt-logo.png',
            ],
        ],
        [
            'id' => 4,
            'name' => 'Ripple',
            'symbol' => 'XRP',
            'config' => [
                'precision' => 6,
                'icon' => 'https://cryptologos.cc/logos/ripple-xrp-logo.png',
            ],
        ],
        [
            'id' => 5,
            'name' => 'Binance Coin',
            'symbol' => 'BNB',
            'config' => [
                'precision' => 8,
                'icon' => 'https://cryptologos.cc/logos/binance-coin-bnb-logo.png',
            ],
        ],
        [
            'id' => 6,
            'name' => 'Solana',
            'symbol' => 'SOL',
            'config' => [
                'precision' => 9,
                'icon' => 'https://cryptologos.cc/logos/solana-sol-logo.png',
            ],
        ],
        [
            'id' => 7,
            'name' => 'USDC',
            'symbol' => 'USDC',
            'config' => [
                'precision' => 6,
                'icon' => 'https://cryptologos.cc/logos/usd-coin-usdc-logo.png',
            ],
        ],
        [
            'id' => 8,
            'name' => 'Dogecoin',
            'symbol' => 'DOGE',
            'config' => [
                'precision' => 8,
                'icon' => 'https://cryptologos.cc/logos/dogecoin-doge-logo.png',
            ],
        ],
        [
            'id' => 9,
            'name' => 'Cardano',
            'symbol' => 'ADA',
            'config' => [
                'precision' => 6,
                'icon' => 'https://cryptologos.cc/logos/cardano-ada-logo.png',
            ],
        ],
        [
            'id' => 10,
            'name' => 'Tron',
            'symbol' => 'TRX',
            'config' => [
                'precision' => 6,
                'icon' => 'https://cryptologos.cc/logos/tron-trx-logo.png',
            ],
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->coins as $coin) {
            Coin::query()->create(attributes: $coin);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Coin::query()->whereIn(column: 'id', values: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->delete();
    }
};
