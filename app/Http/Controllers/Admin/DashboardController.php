<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalBorrowings = Borrowing::count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalOrders',
            'totalBorrowings'
        ));
    }
}

//
//class DashboardController extends Controller
//{
//    public function index()
//    {
//        $totalBooks = Book::count();
//
//        return view('admin.dashboard', compact('totalBooks'));
//    }
//}

