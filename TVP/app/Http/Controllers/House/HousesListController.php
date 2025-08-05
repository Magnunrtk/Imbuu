<?php

declare(strict_types=1);

namespace App\Http\Controllers\House;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Utils\Town;
use App\Utils\World;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class HousesListController extends Controller
{
    public function index(): View
    {
        return view('community.houses.index');
    }

    public function loadList(Request $request): RedirectResponse
    {
        if (!config('multi_world.enabled')) {
            return $this->listWithoutWorld($request);
        }
        return $this->listMultiWorld($request);
    }

    public function listMultiWorld(Request $request): RedirectResponse
    {
        $request->request->set('world', World::getCurrentWorld()['slug']);
        $messages = [
            'world.required' => 'Please select a valid world.',
            'world.world_slug_exists' => 'The world you selected does not exists.',
            'town.required' => 'Please select a valid town.',
            'town.town_slug_exists' => 'The town selected does not exists.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'orderBy.required' => 'Please select a order.',
            'orderBy.in' => 'Invalid order selected.'
        ];
        $rules = [
            'world' => 'required|world_slug_exists',
            'town' => 'bail|required|town_slug_exists',
            'status' => 'bail|required|in:all,available,rented',
            'orderBy' => 'bail|required|in:name,rent,size',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.houses.index'))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $world = $request->world;
        $status = $request->input('status');
        $orderBy = $request->input('orderBy');
        $town = Town::getTownByName($request->input('town'));
        return redirect(
            route(
                'community.houses.list',
                [
                    'worldSlug' => $world,
                    'town' => $town['slug'],
                    'status' => $status,
                    'orderBy' => $orderBy,
                ]
            )
        );
    }

    public function listWithoutWorld(Request $request): RedirectResponse
    {
        $messages = [
            'town.required' => 'Please select a valid town.',
            'town.town_slug_exists' => 'The town selected does not exists.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'orderBy.required' => 'Please select a order.',
            'orderBy.in' => 'Invalid order selected.'
        ];
        $rules = [
            'town' => 'bail|required|town_slug_exists',
            'status' => 'bail|required|in:all,available,rented',
            'orderBy' => 'bail|required|in:name,rent,size',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.houses.index'))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $status = $request->input('status');
        $orderBy = $request->input('orderBy');
        $town = Town::getTownByName($request->input('town'));
        return redirect(
            route(
                'community.houses.list',
                [
                    'town' => $town['slug'],
                    'status' => $status,
                    'orderBy' => $orderBy,
                ]
            )
        );
    }

    public function list(Request $request): RedirectResponse|View
    {
        $messages = [
            'town.required' => 'Please select a valid town.',
            'town.town_slug_exists' => 'The town selected does not exists.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'orderBy.required' => 'Please select a order.',
            'orderBy.in' => 'Invalid order selected.'
        ];
        $rules = [
            'town' => 'bail|required|town_slug_exists',
            'status' => 'bail|required|in:all,available,rented',
            'orderBy' => 'bail|required|in:name,rent,size',
        ];
        $validator = Validator::make($request->route()->parameters(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.houses.index'))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $world = $request->world;
        $status = $request->route('status');
        $orderBy = $request->route('orderBy');
        $town = Town::getTownByName($request->route('town'));
        $houseList = House::whereTownId($town['id']);
        switch ($status) {
            case 'available':
                $houseList = $houseList->where('owner', '=' , 0);
                break;
            case 'rented':
                $houseList = $houseList->where('owner', '!=' , 0);
                break;
        }
        switch ($orderBy) {
            case 'name':
                $houseList = $houseList->orderBy('name');
                break;
            case 'rent':
                $houseList = $houseList->orderBy('rent', 'desc');
                break;
            case 'size':
                $houseList = $houseList->orderBy('size', 'desc');
                break;
        }
        $houseList = $houseList->get();
        return view(
            'community.houses.list',
            compact(
                'world',
                'houseList',
                'town',
                'status',
                'orderBy'
            )
        );
    }

    public function listNoWorld(Request $request): RedirectResponse|View
    {
        $messages = [
            'town.required' => 'Please select a valid town.',
            'town.town_slug_exists' => 'The town selected does not exists.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'orderBy.required' => 'Please select a order.',
            'orderBy.in' => 'Invalid order selected.'
        ];
        $rules = [
            'town' => 'bail|required|town_slug_exists',
            'status' => 'bail|required|in:all,available,rented',
            'orderBy' => 'bail|required|in:name,rent,size',
        ];
        $validator = Validator::make($request->route()->parameters(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.houses.index'))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $status = $request->route('status');
        $orderBy = $request->route('orderBy');
        $town = Town::getTownByName($request->route('town'));
        $houseList = House::whereTownId($town['id']);
        switch ($status) {
            case 'available':
                $houseList = $houseList->where('owner', '=' , 0);
                break;
            case 'rented':
                $houseList = $houseList->where('owner', '!=' , 0);
                break;
        }
        switch ($orderBy) {
            case 'name':
                $houseList = $houseList->orderBy('name');
                break;
            case 'rent':
                $houseList = $houseList->orderBy('rent', 'desc');
                break;
            case 'size':
                $houseList = $houseList->orderBy('size', 'desc');
                break;
        }
        $houseList = $houseList->get();
        return view(
            'community.houses.list',
            compact(
                'houseList',
                'town',
                'status',
                'orderBy'
            )
        );
    }

    public function view(Request $request): View
    {
        $house = $request->house;
        $mainFloor = $house->details->entry_z;
        $housePreviewFiles = array_map('basename', glob(config('houses.imagePath') . $house->id . '_*' . config('houses.imageExtension')));
        $housePreviewArray = [];
        if (empty($housePreviewFiles)) {
            $housePreview = [];
            $housePreview['floor'] = 'Main Floor';
            $housePreview['image'] = $this->houseImageWebPath($this->houseImageNotFound());
            $housePreviewArray[] = $housePreview;
        }
        foreach ($housePreviewFiles as $previewFile) {
            $housePreview = [];
            $trimFileName = str_replace($house->id . '_', '', $previewFile);
            $floorFromFileName = (int)str_replace('.png', '', $trimFileName);
            if ($floorFromFileName === $mainFloor) {
                $housePreview['floor'] = 'Main Floor';
            } else {
                $floor = ($mainFloor - $floorFromFileName);
                if ($floor > 0) {
                    $housePreview['floor'] = 'Upper Floor ' . abs($floor);
                } else {
                    $housePreview['floor'] = 'Lower Floor ' . abs($floor);
                }
            }
            $housePreview['image'] = $this->houseImageWebPath((config('houses.imagePath') . $previewFile));
            $housePreviewArray[] = $housePreview;
        }
        return view('community.view.house.index', compact('house', 'housePreviewArray'));
    }

    static public function houseMainFloorPath(array $housePreviewArray): string
    {
        $key = array_search('Main Floor', array_column($housePreviewArray, 'floor'));
        return $housePreviewArray[$key]['image'];
    }

    private function houseImageWebPath($str): string
    {
        return str_replace(public_path(), '', $str);
    }

    private function houseImageNotFound(): string
    {
        return config('houses.notFoundPath') . 'house_preview_not_found.png';
    }
}
