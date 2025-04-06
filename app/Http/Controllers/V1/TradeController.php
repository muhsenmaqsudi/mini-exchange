<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        return Trade::with(relations: ['makerOrder', 'takerOrder'])
            ->where(column: 'user_id', operator: '=', value: Auth::id())
            ->get();
    }
}
