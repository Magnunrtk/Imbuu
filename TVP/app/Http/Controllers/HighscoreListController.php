<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Traits\Vocations;
use App\Utils\HighscoreLists;
use App\Utils\World;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HighscoreListController extends Controller
{
    use Vocations;

    private const CACHE_KEYS = [
        'axe-fighting' => HighscoreLists::CACHE_AXE_LIST_KEY,
        'club-fighting' => HighscoreLists::CACHE_CLUB_LIST_KEY,
        'distance-fighting' => HighscoreLists::CACHE_DISTANCE_LIST_KEY,
        'experience' => HighscoreLists::CACHE_EXPERIENCE_LIST_KEY,
        'fishing' => HighscoreLists::CACHE_FISHING_LIST_KEY,
        'fist-fighting' => HighscoreLists::CACHE_FISTING_LIST_KEY,
        'magic-level' => HighscoreLists::CACHE_MAGIC_LIST_KEY,
        'shielding' => HighscoreLists::CACHE_SHIELDING_LIST_KEY,
        'sword-fighting' => HighscoreLists::CACHE_SWORD_LIST_KEY,
    ];

    public function index(Request $request): View
    {
        $world = $request->world;
        $config = [
            'rowName' => 'Experience',
            'showLevel' => true,
            'skill_url' => 'experience',
            'vocation' => 'all',
        ];
        $page = 1;
        $list = $this->getExperienceList(World::getCurrentWorld()['id']);
        $skip = 50 * ($page - 1);
        $players = $list->skip($skip)->take(config('highscore.playersPerPage'));
        $paginator = new LengthAwarePaginator(
            $players,
            $list->count(),
            config('highscore.playersPerPage'),
            $page,
        );
        return view('community.highscores.index', compact(
            'world',
                'players',
                'skip',
                'config',
                'paginator',
            )
        );
    }

    public function setFilter(Request $request): RedirectResponse
    {
        $world = $request->world;
        return redirect()->route('community.highscores.filter', [
            $request->input('skill'),
            1,
            empty($request->input('vocation')) ? null : strtolower($request->input('vocation')),
        ]);
    }

    public function filter(Request $request, string $worldSlug, string $skill, string $page, string $vocation = 'all'): RedirectResponse|View
    {
        $world = $request->world;
        $config = [
            'rowName' => 'Skill',
            'showLevel' => false,
            'skill_url' => $skill,
            'vocation' => $vocation,
        ];
        $vocationIds = ($vocation === 'all') ? $this->getAllVocationsById() : $this->getIdsByName(ucwords($vocation));
        if (empty($vocationIds)) {
            return redirect(route('community.highscores.index', $world['slug']));
        }
        switch ($skill) {
            case 'axe-fighting':
                $list = $this->getAxeSkillList(World::getCurrentWorld()['id']);
                break;
            case 'club-fighting':
                $list = $this->getClubSkillList(World::getCurrentWorld()['id']);
                break;
            case 'distance-fighting':
                $list = $this->getDistanceSkillList(World::getCurrentWorld()['id']);
                break;
            case 'experience':
                $config = [
                    'rowName' => 'Experience',
                    'showLevel' => true,
                    'skill_url' => $skill,
                    'vocation' => $vocation,
                ];
                $list = $this->getExperienceList(World::getCurrentWorld()['id']);
                break;
            case 'fishing':
                $list = $this->getFishingSkillList(World::getCurrentWorld()['id']);
                break;
            case 'fist-fighting':
                $list = $this->getFistSkillList(World::getCurrentWorld()['id']);
                break;
            case 'magic-level':
                $config = [
                    'rowName' => 'Magic Level',
                    'showLevel' => true,
                    'skill_url' => $skill,
                    'vocation' => $vocation,
                ];
                $list = $this->getMagicLevelList(World::getCurrentWorld()['id']);
                break;
            case 'shielding':
                $list = $this->getShieldingSkillList(World::getCurrentWorld()['id']);
                break;
            case 'sword-fighting':
                $list = $this->getSwordSkillList(World::getCurrentWorld()['id']);
                break;
            default:
                return redirect(route('community.highscores.index', $world['slug']));
        }
        $page = (int) $page;
        $list = $list->filter(function ($item) use ($vocationIds) {
            if(in_array($item->vocation, $vocationIds))
            {
                return $item;
            }
        })->values();
        $skip = config('highscore.playersPerPage') * ($page - 1);
        $players = $list->skip($skip)->take(config('highscore.playersPerPage'));
        if ($players->isEmpty()) {
            return redirect(route('community.highscores.index', $world['slug']));
        }
        $paginator = new LengthAwarePaginator(
            $players,
            $list->count(),
            config('highscore.playersPerPage'),
            $page,
        );
        return view('community.highscores.index', compact(
            'world',
                'players',
                'skip',
                'config',
                'paginator',
            )
        );
    }

    public function indexNoWorld(): View
    {
        $config = [
            'rowName' => 'Experience',
            'showLevel' => true,
            'skill_url' => 'experience',
            'vocation' => 'all',
        ];
        $page = 1;
        $worldId = World::getCurrentWorld()['id'];
        $lastUpdatedTime = $this->getLastUpdatedTime($worldId, 'experience');
        $list = $this->getSkillList($worldId, 'experience');
        $skip = 50 * ($page - 1);
        $players = $list->skip($skip)->take(config('highscore.playersPerPage'));
        $paginator = new LengthAwarePaginator(
            $players,
            $list->count(),
            config('highscore.playersPerPage'),
            $page,
        );
        return view('community.highscores.index', compact(
                'players',
                'skip',
                'config',
                'paginator',
                'lastUpdatedTime',
            )
        );
    }

    public function setFilterNoWorld(Request $request): RedirectResponse
    {
        return redirect(
            route(
                'community.highscores.filter',
                [
                    $request->input('skill'),
                    1,
                    empty($request->input('vocation')) ? null : strtolower($request->input('vocation'))
                ]
            )
        );
    }

    public function filterNoWorld(Request $request, string $skill, string $page, string $vocation = 'all'): RedirectResponse|View
    {
        $config = [
            'rowName' => 'Skill',
            'showLevel' => false,
            'skill_url' => $skill,
            'vocation' => $vocation,
        ];
        $vocationIds = ($vocation === 'all') ? $this->getAllVocationsById() : $this->getIdsByName(ucwords($vocation));
        $worldId = World::getCurrentWorld()['id'];
        if (empty($vocationIds)) {
            return redirect(route('community.highscores.index'));
        }
        switch ($skill) {
            case 'fishing':
            case 'club-fighting':
            case 'distance-fighting':
            case 'fist-fighting':
            case 'shielding':
            case 'sword-fighting':
            case 'axe-fighting':
                $list = $this->getSkillList($worldId, $skill, $vocationIds);
                $lastUpdatedTime = $this->getLastUpdatedTime($worldId, $skill, $vocationIds);
                break;
            case 'experience':
                $config = [
                    'rowName' => 'Experience',
                    'showLevel' => true,
                    'skill_url' => $skill,
                    'vocation' => $vocation,
                ];
                $list = $this->getSkillList($worldId, $skill, $vocationIds);
                $lastUpdatedTime = $this->getLastUpdatedTime($worldId, $skill, $vocationIds);
                break;
            case 'magic-level':
                $config = [
                    'rowName' => 'Magic Level',
                    'showLevel' => true,
                    'skill_url' => $skill,
                    'vocation' => $vocation,
                ];
                $list = $this->getSkillList($worldId, $skill, $vocationIds);
                $lastUpdatedTime = $this->getLastUpdatedTime($worldId, $skill, $vocationIds);
                break;
            default:
                return redirect(route('community.highscores.index'));
        }
        $page = (int) $page;
        $list = $list->filter(function ($item) use ($vocationIds) {
            if(in_array($item->vocation, $vocationIds))
            {
                return $item;
            }
        })->values();
        $skip = config('highscore.playersPerPage') * ($page - 1);
        $players = $list->skip($skip)->take(config('highscore.playersPerPage'));
        if ($players->isEmpty()) {
            return redirect(route('community.highscores.index'));
        }
        $paginator = new LengthAwarePaginator(
            $players,
            $list->count(),
            config('highscore.playersPerPage'),
            $page,
        );
        return view('community.highscores.index', compact(
                'players',
                'skip',
                'config',
                'paginator',
                'lastUpdatedTime',
            )
        );
    }

    private function getSkillList(int $worldId, string $skill, array $vocations = []): object
    {
        if (empty($vocations)) {
            $vocations = array_keys(config('vocations'));
        }
        $cacheKey = self::CACHE_KEYS[$skill] ?? null;
        return HighscoreLists::getHighscoreList($cacheKey, $worldId, $vocations);
    }

    private function getLastUpdatedTime(int $worldId, string $skill, array $vocations = [])
    {
        if (empty($vocations)) {
            $vocations = array_keys(config('vocations'));
        }
        $cacheKey = self::CACHE_KEYS[$skill] ?? null;
        $cacheKey .= ':' . implode('_', $vocations);
        return Cache::get($cacheKey . ':' . $worldId . ':time');
    }
}
