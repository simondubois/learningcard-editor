<?php
declare(strict_types=1);

namespace Simondubois\LearningCardEditor;

use Symfony\Component\Finder\SplFileInfo;

class Parser
{
    public function parse(string $path) : array
    {
        $file = $this->getFile($path);
        $contentRaw = $file->getContents();
        $contentLines = $this->getLines($contentRaw);
        $contentColumns = $this->getColumns($contentLines);

        return $this->cleanColumns($contentColumns);
    }

    public function getFile(string $path) : SplFileInfo
    {
        return new SplFileInfo($path, null, null);
    }

    public function getLines(string $content): array
    {
        return explode(PHP_EOL, $content);
    }

    public function getColumns(array $content): array
    {
        return array_map(function ($line) {
            return str_getcsv($line, ' ');
        }, $content);
    }

    public function cleanColumns(array $content): array
    {
        return array_filter($content, function ($line) {
            return isset($line[0]);
        });
    }
}
