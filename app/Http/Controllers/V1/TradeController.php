<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TradeCollection;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::with(relations: ['user', 'coin', 'order', 'counterOrder'])
            ->where(column: 'user_id', operator: '=', value: Auth::id())
            ->latest()
            ->get();

        return TradeCollection::make(resource: $trades);
    }
}
