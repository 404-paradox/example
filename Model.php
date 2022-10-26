<?php

namespace App\Bundles\CacheBundle;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Model
{
    private string $baseDir;
    private string $featureDir;
    private string $modelName;
    private string $fileName;

    /**
     * Constructor
     *
     * @param $modelName
     * @param $fileName
     */
    public function __construct($modelName, $fileName)
    {
        $this->modelName = $modelName;
        $this->fileName = $fileName;
        $this->baseDir = config('', 'app_cache');
        $this->featureDir = config('', 'models');
    }

    /**
     * Has cache
     *
     * @return bool
     */
    public function hasCache(): bool
    {
        return is_readable($this->cacheDirPath() . '/' . $this->fileName);
    }

    /**
     * Get cache
     *
     * @return array
     */
    public function getCache(): array
    {
        return json_decode($this->getCachedData());
    }

    /**
     * Get cached data
     *
     * @return string
     *
     * @throw FileNotFoundException
     */
    public function getCachedData(): string
    {
        $filePath = $this->fullPathToFile();

        try {
            return file_get_contents($filePath);
        } catch (\Exception $e) {
            throw new FileNotFoundException($filePath);
        }
    }

    /**
     * Save cache
     *
     * @param string $all
     *
     * @return void
     */
    public function saveCache(string $all): void
    {
        try {
            file_put_contents($this->fullPathToFile(), $all);
        } catch (Exception $e) {
            throw new FileException();
        }
    }

    /**
     * Full path to File
     *
     * @return string
     */
    private function fullPathToFile(): string
    {
        $dirPath = $this->cacheDirPath();

        if (!is_dir($dirPath)) {
            $this->createDir();
        }

        return $dirPath . '/' . $this->fileName;
    }

    /**
     * Create dirs
     *
     * @return void
     */
    private function createDir(): void
    {
        mkdir($this->cacheDirPath(), 0777, true);
    }

    /**
     * Path to cache dir
     *
     * @return string
     */
    private function cacheDirPath(): string
    {
        return storage_path() . '/' . $this->baseDir . '/' . $this->featureDir . '/' . $this->modelName;
    }
}
