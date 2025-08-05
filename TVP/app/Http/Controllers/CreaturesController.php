<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CreaturesController extends Controller
{
    public function index(): View
    {
        return view('support.creatures.index');
    }

    public function show(string $name): View|RedirectResponse
    {
        $creatureName = Str::lower(trim($name));
        if (view()->exists('support.creatures.' . $creatureName)) {
            return view('support.creatures.'. $name);
        }
        return redirect(route('support.creatures.index'));
    }
}
