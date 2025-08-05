<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\RunArtisanInBackground;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClientUpdateController extends Controller
{
    use RunArtisanInBackground;

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view('admin.client-update.index');
    }

    public function action(Request $request): RedirectResponse
    {
        $this->runInBackground('client:update');
        return Redirect::back()
            ->with('success', 'Client files are going to get updated from github, this can take a few minutes.');
    }
}
