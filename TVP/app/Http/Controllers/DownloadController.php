<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function index(): View
    {
        return view('download.index');
    }

    public function prepare(): RedirectResponse
    {
        if(!config('server.enableClientDownload')) {
            return redirect(route('download.index'))
                ->with(
                    'error',
                    'The download has been temporary disabled. Please try again later.'
                );
        }
        $storagePath = 'client/';
        $fileName = config('server.clientName') . '[v' . config('server.clientVersion') . '].zip';
        $storageFilePath = $storagePath . $fileName;
        if (Storage::disk('public')->exists($storageFilePath)) {
            Session::put('downloadClient', true);
            return redirect(route('download.index'))
                ->with(
                    'success',
                    'We are preparing your client. The download will start shorty.'
                );
        }

        return redirect(route('download.index'))
            ->with(
                'error',
                'There was an error while trying to download the client, please try again later.'
            );
    }

    public function start(): RedirectResponse|StreamedResponse
    {
        if(!Session::has('downloadClient')) {
            return redirect(route('download.index'));
        }

        $storagePath = 'client/';
        $fileName = config('server.clientName') . '[v' . config('server.clientVersion') . '].zip';
        $storageFilePath = $storagePath . $fileName;
        if (Storage::disk('public')->exists($storageFilePath)) {
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            Session::forget('downloadClient');
            return Storage::disk('public')->download($storageFilePath, $fileName, $headers);
        }

        return redirect(route('download.index'))
            ->with(
                'error',
                'There was an error while trying to download the client, please try again later.'
            );
    }
}
