<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $supportGroups = Player::select('name', 'group_id', 'lastlogin')
            ->where('group_id', '>', 1)
            ->orderBy('group_id', 'desc') // Ordena pelo group_id de forma decrescente
            ->get()
            ->groupBy('group_id');
        
        return view('support.contact.index', compact('supportGroups'));
    }
}