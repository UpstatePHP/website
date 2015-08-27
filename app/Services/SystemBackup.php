<?php
namespace UpstatePHP\Website\Services;

use Illuminate\Contracts\Foundation\Application;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class SystemBackup
{
    /**
     * @var Application
     */
    private $app;

    private $backupName;

    private $backupDir;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->backupName = date('Y-m-d-H-i-s') . '-' . uniqid();
        $this->backupDir = storage_path('temp/' . $this->backupName);
        $this->makeBackupDirectory();
    }

    public function makeDatabaseBackup()
    {
        $path = $this->backupDir . '/database.sql';

        $command = sprintf('mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_PORT', '3306')),
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($path)
        );

        shell_exec($command);

        return $path;
    }

    public function doFullBackup()
    {
        $backupZip = storage_path('temp/' . $this->backupName . '.zip');
        $dbBackup = $this->makeDatabaseBackup();

        $zip = new ZipArchive;
        $zip->open($backupZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFile($dbBackup, basename($dbBackup));
        $this->addUploadsToZip($zip);

        $zip->close();

        return $backupZip;
    }

    public function sendBackupOffsite($backup, $clearAfterwards = false)
    {
        $offsiteBackup = $this->app['offsite-backup'];

        if (file_exists($backup)) {
            $offsiteBackup->put(basename($backup), file_get_contents($backup));

            if ($clearAfterwards) {
                @unlink($backup);
            }
        }
    }

    private function addUploadsToZip(ZipArchive &$zip)
    {
        $rootPath = public_path('uploads');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, 'uploads/' . $relativePath);
            }
        }
    }

    private function makeBackupDirectory()
    {
        if (is_dir($this->backupDir)) {
            $this->removeBackupDirectory();
        }

        mkdir($this->backupDir);
    }

    private function removeBackupDirectory()
    {
        $it = new RecursiveDirectoryIterator($this->backupDir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($this->backupDir);
    }

    public function __destruct()
    {
        $this->removeBackupDirectory();
    }

    /**
     * @return string
     */
    public function getBackupName()
    {
        return $this->backupName;
    }
}
