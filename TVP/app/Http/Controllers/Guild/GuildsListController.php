<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Models\Guild;
use App\Models\WebGuild;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class GuildsListController extends Controller
{
    public function index(): View
    {
        $guildList = Guild::all();
        return view('community.guilds.index', compact('guildList'));
    }

    public function loadList(Request $request): RedirectResponse
    {
        if (!config('multi_world.enabled')) {
            $request->request->set('world', config('multi_world.worlds')[0]['slug']);
        }
        $messages = [
            'world.required' => 'Please select a valid world.',
            'world.world_slug_exists' => 'The world you selected does not exists.',
        ];
        $rules = [
            'world' => 'required|world_slug_exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.guilds.index'))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $world = $request->world;
        return redirect(
            route(
                'community.guilds.list',
                [
                    'worldSlug' => $world,
                ]
            )
        );
    }

    public function list(Request $request): View
    {
        $world = $request->world;
        $guildList = Guild::select(['name', 'motd'])->get();
        return view('community.guilds.list', compact('guildList', 'world'));
    }
}
