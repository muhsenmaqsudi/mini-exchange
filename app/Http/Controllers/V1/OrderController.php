<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(relations: ['coin', 'user', 'makerTrade', 'takerTrade'])
            ->where(column: 'user_id', operator: '=', value: Auth::id())
            ->latest()
            ->get();
    }
}
