<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Auth;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Utils\Vocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use function config;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function characterList(): JsonResponse
    {
        $characterList = Player::whereAccountId(Auth::user()->id)
            ->select('id', 'name', 'level', 'vocation')->get();
        return Datatables::of($characterList)
            ->editColumn(
                'vocation',
                function ($characterList) {
                    return Vocation::getNameByVocationId($characterList->vocation);
                }
            )
            ->addColumn(
                'world',
                function () {
                    return config('server.worlds')[0];
                }
            )
            ->addColumn(
                'online',
                function ($characterList) {
                    return (bool)$characterList->online;
                }
            )
            ->make();
    }
}
