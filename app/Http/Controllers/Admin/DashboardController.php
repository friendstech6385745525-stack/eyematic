<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin,superadmin']);
    }

    public function index()
    {
        $totalProducts  = Product::count();
        $totalVendors   = User::where('role', 'vendor')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalMessages  = Message::count();

        $recentProducts = Product::latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalVendors', 'totalCustomers', 'totalMessages',
            'recentProducts', 'recentMessages'
        ));
    }
}
