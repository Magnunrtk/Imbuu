<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DateTimeZone;

class CrashReportController extends Controller
{
    public function create(Request $request)
    {
        $maxFiles = 98;

        if (!$request->hasHeader('ravenor-secret') || $request->header('ravenor-secret') !== '0a6f4089-f5c2-4cb3-a35c-3fb01a9f74a1') {
            return Response::json(['error' => 'Unauthorized access.'], 403);
        }

        $requestData = $request->all();
        foreach ($requestData as $key => $value) {
            $requestData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        
        $dataHora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dataHoraFormatada = $dataHora->format('d/m/Y H:i:s');

        $validatedData = $request->validate([
            'problem_name' => 'required|string|max:255',
            'version_name' => 'required|string|max:255',
            'build_name' => 'required|string|max:255',
            'os_name' => 'required|string|max:255',
            'platform_name' => 'required|string|max:255',
            'crash_content' => 'required|string|max:100000',
            'log_content' => 'required|string|max:100000',
        ]);
        
        $content = "Crash Report\n\n";
        $content .= "Date: " . $dataHoraFormatada . "\n";
        $content .= "IP: " . $request->ip() . "\n";
        $content .= "User Agent: " . $request->userAgent() . "\n";
        
        $problemName = htmlspecialchars($validatedData['problem_name'], ENT_QUOTES, 'UTF-8');
        $versionName = htmlspecialchars($validatedData['version_name'], ENT_QUOTES, 'UTF-8');
        $buildName = htmlspecialchars($validatedData['build_name'], ENT_QUOTES, 'UTF-8');
        $osName = htmlspecialchars($validatedData['os_name'], ENT_QUOTES, 'UTF-8');
        $platformName = htmlspecialchars($validatedData['platform_name'], ENT_QUOTES, 'UTF-8');
        $crashContent = htmlspecialchars($validatedData['crash_content'], ENT_QUOTES, 'UTF-8');
        $logContent = htmlspecialchars($validatedData['log_content'], ENT_QUOTES, 'UTF-8');

        $content .= "Game Erro: " . $problemName . "\n";
        $content .= "Version: " . $versionName . "\n";
        $content .= "Build: " . $buildName . "\n";
        $content .= "Os: " . $osName . "\n";
        $content .= "Platform: " . $platformName . "\n\n";

        $crashFile = $content . base64_decode($crashContent);
        $logFile = $content . base64_decode($logContent);

        $this->manageFiles('crash_reports', $maxFiles);

        $filename = 'crash_report_' . now()->format('Ymd_His') . '.txt';
        Storage::put('crash_reports/' . $filename, $crashFile);

        $crashUrl = route('crashReport.read', ['filename' => $filename]);

        $filename = 'log_report_' . now()->format('Ymd_His') . '.txt';
        Storage::put('crash_reports/' . $filename, $logFile);

        $logUrl = route('crashReport.read', ['filename' => $filename]);

        $webhook = 'https://discord.com/api/webhooks/1249754162325880842/SPx6-ajgjED0tPA65V-vtgj9Pmz8qCAZ8BfylCYJ1rmo6A5XChumFUCu_Unz5giwi1V5';
        $filename = 'crash_report_' . now()->format('Ymd_His') . '.txt';

        $data = [

                'content' =>("    
```Game-Erro $problemName
Version $versionName
Build $buildName
Os $osName
Platform $platformName

Crash-log $crashUrl 
View-log $logUrl

Data/Hora: $dataHoraFormatada  
```")];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($webhook, false, $context);

        return Response::json(['message' => 'Crash report saved.'], 200);
    }

    public function read($filename)
    {
        $path = 'crash_reports/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'File not found');
        }

        $fileContent = Storage::get($path);

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain', 
        ]);
    }


    private function manageFiles($directory, $maxFiles)
    {
        $files = Storage::files($directory);

        if (count($files) > $maxFiles) {

            usort($files, function ($a, $b) {
                return Storage::lastModified($a) - Storage::lastModified($b);
            });

            $filesToRemove = count($files) - $maxFiles;

            for ($i = 0; $i < $filesToRemove; $i++) {
                Storage::delete($files[$i]);
            }
        }
    }
}

