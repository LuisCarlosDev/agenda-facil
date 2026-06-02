<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('dashboard', [
            'stats' => [
                'totalServices' => $user->isProfissional() ? $user->services()->count() : 0,
                'pending' => 0,
                'confirmed' => 0,
                'completed' => 0,
            ],
            'activities' => [],
        ]);
    }
}
