<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoinCollection;
use App\Http\Resources\CoinResource;
use App\Models\Coin;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): CoinCollection
    {
        $coins = Coin::all();

        return CoinCollection::make($coins);
    }
}
