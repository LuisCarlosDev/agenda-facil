<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'stats' => [
                'totalServices' => 0,
                'pending' => 0,
                'confirmed' => 0,
                'completed' => 0,
            ],
            'activities' => [],
        ]);
    }
}
