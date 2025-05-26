<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Item;
use App\Models\Mesa;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalCategorias' => Categoria::count(),
            'totalItems'      => Item::count(),
            'totalMesas'      => Mesa::count(),
            'totalAdmins'     => Admin::count(),
        ]);
    }
}