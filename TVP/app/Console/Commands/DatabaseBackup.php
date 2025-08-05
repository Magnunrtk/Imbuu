<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    protected $signature = 'database:backup';

    protected $description = 'Generate a database backup package by command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $backupDir = config('server.backup_storage_path');
            $backupPath = Storage::path($backupDir);
            $backupFilePath = Storage::disk('local')->exists($backupDir);
            if(!$backupFilePath) {
                File::makeDirectory($backupPath, $mode = 0777, true, true);
            }
            $filename = "backup-" . Carbon::now()->format('Y_m_d_His') . ".gz";
            $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $backupPath . "/" . $filename;
            exec($command);
            $this->info('Database backup has been saved.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}