<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Guild;
use App\Models\House;
use App\Models\Player;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $totalAccounts = Account::all();
        $totalPlayers = Player::all();
        $totalGuilds = Guild::all();
        $totalHouses = House::all();

        return view(
            'admin.dashboard.index',
            compact(
                'totalAccounts',
                'totalGuilds',
                'totalHouses',
                'totalPlayers',
            )
        );
    }
}
