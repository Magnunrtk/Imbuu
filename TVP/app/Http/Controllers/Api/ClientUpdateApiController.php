<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ClientUpdateApiController extends Controller
{
    private string $filesDir = "public/client/files/";
    private string $filesUrl = "https://ravenor.online/api/client/TVP-Ravenor-Client-Encryption";
    private array $filesAndDirs = ["init.lua", "data", "modules", "layouts"];
    private string $checksumFile = "checksums.txt";
    private int $checksumUpdateInterval = 60; // seconds
    private array $binaries = [
        "WIN32-WGL" => "otclient_gl.exe",
        "WIN32-EGL" => "otclient_dx.exe",
        "WIN32-WGL-GCC" => "",
        "WIN32-EGL-GCC" => "",
        "X11-GLX" => "",
        "X11-EGL" => "",
        "ANDROID-EGL" => "",
        "ANDROID64-EGL" => ""
    ];

    public function update(Request $request): bool|string
    {
        $data = $request->getContent() ? json_decode($request->getContent()) : null;
        $platform = $data ? $data->platform : "";
        $binary = $data && isset($this->binaries[$platform]) ? $this->binaries[$platform] : "";
        if (!Storage::directoryExists($this->filesDir)) {
            return json_encode(["error" => "Updating files not found."], JSON_PRETTY_PRINT);
        }

        $cache = null;
        $cacheFile = $this->getCacheFilePath();
        if (Storage::disk('public')->exists($cacheFile) &&
            (Storage::disk('public')->lastModified($cacheFile) + $this->checksumUpdateInterval > time())
        ) {
            $cache = json_decode(Storage::disk('public')->get($cacheFile), true);
        }

        if (!$cache) {
            $dir = $this->getStoragePath();
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            $cache = array();
            foreach ($rii as $file) {
                if (!$file->isFile()) {
                    continue;
                }
                $path = str_replace($dir, '', $file->getPathname());
                $path = '/' . ltrim(str_replace(DIRECTORY_SEPARATOR, '/', $path), '/');
                $cache[$path] = hash_file("crc32b", $file->getPathname());
            }
            Storage::disk('public')->put($cacheFile . ".tmp", json_encode($cache));
            Storage::disk('public')->move($cacheFile . ".tmp", $cacheFile);
        }
        $response = [
            "url" => $this->filesUrl,
            "files" => [],
            "keepFiles" => false
        ];
        foreach ($cache as $file => $checksum) {
            $base = trim(explode("/", ltrim($file, "/"))[0]);
            if (in_array($base, $this->filesAndDirs)) {
                $response["files"][$file] = $checksum;
            }
            if ($base == $binary && !empty($binary)) {
                $response["binary"] = ["file" => $file, "checksum" => $checksum];
            }
        }
        return json_encode($response, JSON_PRETTY_PRINT);
    }

    private function getStoragePath(): string
    {
        return Storage::path($this->filesDir);
    }

    private function getCacheFilePath(): string
    {
        return $this->checksumFile;
    }

    public function file(string $path): BinaryFileResponse|JsonResponse
    {
        $filePath = $this->filesDir . $path;
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        return response()->download(storage_path("app/$filePath"));
    }
}