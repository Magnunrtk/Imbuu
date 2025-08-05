<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;

class ClientUpdate extends Command
{
    protected $signature = 'client:update';
    protected $description = 'Update client files from GitHub repository';

    public function handle()
    {
        $targetDirectory = storage_path('app/public/client');
        if (!Storage::directoryExists($targetDirectory)) {
            $this->info('Client updating directory does not exist, creating...');
            File::makeDirectory($targetDirectory, 0755, true, true);
        }

        try {
            $this->info('Updating client files from GitHub...');

            $this->info('Downloading GitHub repository...');
            $this->cloneGitHubRepository(
                config('client_update.github')['repository'],
                $targetDirectory,
                config('client_update.github')['username'],
                config('client_update.github')['accessToken']
            );
            $this->info('Cleaning up Git files...');
            $this->cleanUpGitFiles($targetDirectory . '/files');

            $this->info('Client files have been successfully updated from GitHub.');
        } catch (\Exception $e) {
            Log::error("An error occurred: " . $e->getMessage());
            $this->cleanUp($targetDirectory);
            $this->error('Updating client from GitHub failed. Please try again.');
        }
    }

    private function cloneGitHubRepository($repoUrl, $targetDirectory, $username, $accessToken): void
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("$username:$accessToken"),
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept-Language' => 'en-US,en;q=0.9',
            ],
        ]);

        $archiveUrl = "$repoUrl/archive/main.zip";
        $archiveFile = $targetDirectory . '/repository.zip';

        try {
            $client->request('GET', $archiveUrl, [
                'sink' => $archiveFile,
                'progress' => function ($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                    if ($downloadedBytes > 0) {
                        $mb = $downloadedBytes / 1048576;
                        //$this->info('Downloaded: ' . round($mb) . ' MB');
                    }
                },
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 401) {
                Log::error("Bad Request: " . $e->getMessage());
            } else {
                $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
                Log::error($message);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString());
        }

        if (File::exists($archiveFile)) {
            $zip = new \ZipArchive;
            if ($zip->open($archiveFile) === true) {
                $zip->extractTo($targetDirectory);
                $mainDirectoryName = $zip->getNameIndex(0);
                $zip->close();
                $storagePath = $targetDirectory . '/' . $mainDirectoryName;
                $newStoragePath = $targetDirectory . '/files';

                if (File::exists($newStoragePath)) {
                    File::deleteDirectory($newStoragePath);
                }

                if (File::isDirectory($storagePath)) {
                    File::move($storagePath, $newStoragePath);
                }
            } else {
                Log::error("Failed to open ZIP file. ZIP might be corrupt.");
            }

            File::delete($archiveFile);
        }
    }

    private function cleanUpGitFiles($directory)
    {
        foreach (config('client_update.excludeFilesFromRepo') as $file) {
            $filePath = $directory . '/' . $file;
            if (File::exists($filePath)) {
                if (File::isDirectory($filePath)) {
                    File::deleteDirectory($filePath);
                    continue;
                }
                File::delete($filePath);
            }
        }

        $filesToDelete = [];
        foreach (config('client_update.excludeExtensionsFromRepo') as $extension) {
            $filesToDelete = array_merge($filesToDelete, File::glob($directory . '/*.' . $extension));
        }

        foreach ($filesToDelete as $file) {
            File::delete($file);
        }
    }

    private function cleanUp($targetDirectory)
    {
        File::cleanDirectory($targetDirectory);
    }
}
