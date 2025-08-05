<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WebNews;
use App\Utils\NewsType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): RedirectResponse|View
    {
        $page = !is_null($request->input('page')) ? (int) $request->input('page') : 0;
        $list = WebNews::whereType(NewsType::NEWS)
        ->whereHidden(false)
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();
        $skip = config('server.newsPerPage') * ($page - 1);
        $newsTicker = WebNews::whereType(NewsType::TICKER)->whereHidden(false)->orderBy('created_at', 'desc')->limit(5)->get();
        $allNews = $list;

        if ($allNews->isEmpty()) {
            return view('news.archive', compact(
                'newsTicker',
                    'allNews',
                )
            );
        }
        $paginator = new LengthAwarePaginator(
            $allNews,
            $list->count(),
            config('server.newsPerPage'),
            $page,
        );
        return view('news.index', compact(
                'allNews',
                'skip',
                'paginator',
                'newsTicker'
            )
        );
    }

    public function archive(): View
    {
        $allNews = WebNews::whereHidden(false)->orderBy('created_at', 'desc')->get();
        return view('news.archive', compact(
                'allNews',
            )
        );
    }

    public function archiveView(string $id): RedirectResponse|View
    {
        $news = WebNews::find((int) $id);
        if ($news && !$news->hidden) {
            return view('news.view', compact(
                    'news',
                )
            );
        }
        return redirect(route('landing'));
    }
}

