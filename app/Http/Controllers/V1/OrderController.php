<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(relations: ['coin', 'user', 'trade', 'trade.counterOrder'])
            ->where(column: 'user_id', operator: '=', value: Auth::id())
            ->latest()
            ->get();

        return OrderCollection::make(resource: $orders);
    }
}
