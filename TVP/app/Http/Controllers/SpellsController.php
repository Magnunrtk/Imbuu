<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Traits\Vocations;
use App\Models\WebSpell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SpellsController extends Controller
{
    use Vocations;

    public function index(): View
    {
        $filters = [
            'vocation' => 'all',
            'type' => 'all',
            'premium' => 'all',
            'sort' => 'name',
        ];
        $spells = $this->getSpellsList();
        return view('library.spells.index', compact('spells', 'filters'));
    }

    public function filter(Request $request): View
    {
        $spells = $this->getSpellsList();
        $vocation = strtolower($request->input('vocation'));
        $sort = match ($request->input('sort')) {
            'name' => 'name',
            'type' => 'category',
            'mlvl' => 'mlvl',
            'mana' => 'mana',
            'premium' => 'premium',
            default => NULL,
        };
        $premium = match ($request->input('premium')) {
            'no' => 0,
            'yes' => 1,
            default => NULL,
        };
        $type = match ($request->input('type')) {
            'Instant' => 1,
            'Rune' => 2,
            'Conjure' => 3,
            default => NULL,
        };
        $vocationIds = ($vocation === 'all') ? $this->getAllVocationsById() : $this->getIdsByName(ucwords($vocation));
        if (!empty($vocationIds)) {
            $spells = $spells->filter(function ($spell) use ($vocationIds) {
                return collect(explode(',', $spell->vocations))->intersect($vocationIds)->count() > 0;
            });
        }
        if (!is_null($type)) {
            $spells = $spells->where('category', $type);
        }
        if (!is_null($premium)) {
            $spells = $spells->where('premium', $premium);
        }
        if (!is_null($sort)) {
            if ($sort === 'name' || $sort === 'category') {
                $spells = $spells->sortBy($sort);
            } else {
                $spells = $spells->sortByDesc($sort);
            }
        }
        $filters = [
            'vocation' => empty($vocationIds) ? 'all' : $vocation,
            'type' => is_null($type) ? 'all' : $type,
            'premium' => is_null($premium) ? 'all' : $premium,
            'sort' => is_null($sort) ? 'name' : $sort,
        ];
        return view('library.spells.index', compact('spells', 'filters'));
    }

    public function getSpellsList()
    {
        if (!Cache::has('spells')) {
            $this->cacheSpellsList();
        }

        $spells = Cache::get('spells');
        return $spells->sortBy('name');
    }

    public function cacheSpellsList(): void
    {
        $list = WebSpell::all();
        Cache::put( 'spells', $list, now()->addMinutes(30));
    }
}
