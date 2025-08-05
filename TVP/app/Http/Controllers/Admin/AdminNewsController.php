<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebManualTransaction;
use App\Models\WebNews;
use App\Utils\NewsType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Models\Player;

class AdminNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view('admin.news.index');
    }

    public function list(string $type): JsonResponse
    {
        $query = match ((int)$type) {
            NewsType::TICKER => WebNews::whereType(NewsType::TICKER)->get(),
            NewsType::ARTICLE => WebNews::whereType(NewsType::ARTICLE)->get(),
            default => WebNews::whereType(NewsType::NEWS)->get(),
        };
        return Datatables::of($query)
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d H:i');
            })->addColumn('author', function ($query) {
                return $query->author->name;
            })->make();
    }

    public function add(): View
    {
        return view('admin.news.add');
    }

    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'title.required'     => 'Please enter a title!',
            'body.required'      => 'Please enter a text for the news!',
            'type.required'      => 'Please select a type.',
            'type.in'            => 'Selected type does not exist.',
            'player_id.required' => 'Please select an author.',
            'player_id.exists'   => 'Selected author does not exist.',
            'category.required'  => 'Please select a category.',
            'category.in'        => 'Selected category does not exist.',
        ];

        $rules = [
            'title'     => 'required',
            'body'      => 'required',
            'type'      => 'required|in:' . NewsType::NEWS . ',' . NewsType::TICKER . ',' . NewsType::ARTICLE,
            'player_id' => 'required|exists:players,id',
            'category'  => 'required|in:0,1,2,3,4',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }

        $news = WebNews::create($request->all());

        $dataHora = now()->format('d/m/Y H:i:s');

        $typeNames = [
            NewsType::NEWS    => 'Notícia Geral',
            NewsType::TICKER  => 'Ticker',
            NewsType::ARTICLE => 'Artigo',
        ];
        $categoryNames = [
            0 => 'Geral',
            1 => 'Eventos',
            2 => 'Atualizações',
            3 => 'Tutoriais',
            4 => 'Promoções',
        ];

        $playerId = $request->player_id;

        $playerName = Player::where('id', $playerId)
                            ->value('name');

        $authorName = $playerName ?? 'Desconhecido';

        $rawBody = $news->body;

        $rawBody = preg_replace('/<span([^>]*)>(.*?)<br\s*\/?>(.*?)<\/span>/is', "$2<br>$3", $rawBody);

        $rawBody = preg_replace('/<br\s*\/?>/i', "\n", $rawBody);

        $rawBody = preg_replace_callback(
            '/<(strong|b)\b[^>]*>(.*?)<\/\1>/is',
            fn($m) => '**' . trim(strip_tags($m[2])) . '**',
            $rawBody
        );

        $rawBody = preg_replace_callback(
            '/<span\b[^>]*style=["\'][^"\']*font-weight\s*:\s*(?:bold|700)[^"\']*["\'][^>]*>(.*?)<\/span>/is',
            fn($m) => '**' . trim(strip_tags($m[1])) . '**',
            $rawBody
        );

        $step1 = html_entity_decode($rawBody, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $step2 = preg_replace_callback(
            '/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is',
            fn($m) => "\n\n**" . trim(strip_tags($m[1])) . "**\n\n",
            $step1
        );

        $step3 = preg_replace('/<\/p>\s*<p>/i', "\n\n", $step2);

        $step4 = strip_tags($step3);

        $plainBody = preg_replace('/[ \t\x{00A0}]+/u', ' ', $step4);
        $plainBody = trim($plainBody);

        $webhookUrl = 'https://discord.com/api/webhooks/1372561226164469911/lZCLZaVpiszxvaPnCERlnWjQ3lgII4OWv4ko8tvO-t6xDHs3K6r-ebagGYz3suL37-yW';
        $payload = [
            'embeds' => [[
                'title'       => "📰 {$news->title}",
                'description' => $plainBody,
                'color'       => 0x00AAFF, 
                'fields'      => [
                    ['name' => 'Tipo',      'value' => ($typeNames[$news->type]    ?? $news->type),     'inline' => true],
                    ['name' => 'Categoria', 'value' => ($categoryNames[$news->category] ?? $news->category), 'inline' => true],
                    ['name' => 'Autor',     'value' => $authorName,                                       'inline' => true],
                    ['name' => 'Data',      'value' => $dataHora,                                         'inline' => true],
                ],
                'timestamp'   => now()->toIso8601String(),
            ]]
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => json_encode($payload),
            ]
        ];
        $context = stream_context_create($options);
        @file_get_contents($webhookUrl, false, $context);

        return Redirect::back()
            ->with('success', 'News has been successfully created.');
    }

    public function edit(string $id): View|RedirectResponse
    {
        $news = WebNews::find((int) $id);
        if ($news) {
            return view('admin.news.edit', compact('news'));
        }

        return Redirect::back();
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $messages = [
            'title.required' => 'Please enter a title!',
            'body.required' => 'Please enter a text for the news!',
            'type.required' => 'Please select a type.',
            'type.in' => 'Selected type does not exists.',
            'last_modified_by.required' => 'Please select a modified by player.',
            'last_modified_by.exists' => 'Selected modified player does not exists.',
            'category.required' => 'Please select a category.',
            'category.in' => 'Selected category does not exists.',
        ];
        $rules = [
            'title' => 'required',
            'body' => 'required',
            'type' => 'required|in:' . NewsType::NEWS . ', ' . NewsType::TICKER . ',' . NewsType::ARTICLE,
            'last_modified_by' => 'required|exists:players,id',
            'category' => 'required|in:0,1,2,3,4',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()
                ->with('error', preg_replace('/\s+/', ' ', $validator->errors()->first()));
        }
        $input = $request->all();
        $news = WebNews::updateOrCreate(
            ['id' => (int) $id],
            $input
        );
        return Redirect::back()
            ->with(
                'success',
                sprintf('%s has been successfully updated.', NewsType::getName((int) $news->type)),
            );
    }

    public function delete(string $id): JsonResponse
    {
        $news = WebNews::find((int) $id);
        if ($news) {
            $news->delete();
            return response()->json(
                [
                    'success' => true,
                    'type' => 'success',
                    'title' => 'Done!',
                    'message' => sprintf('%s has been successfully deleted.', NewsType::getName((int) $news->type)),
                ]
            );
        }
        return response()->json(
            [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'There was an error while trying to delete.'
            ]
        );
    }
}
