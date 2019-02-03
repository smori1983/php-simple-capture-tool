<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use Momo\SimpleCaptureTool\CaptureUtil\CaptureItem;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureList;
use Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface;
use Symfony\Component\Yaml\Yaml;

class YamlReader implements ListReaderInterface
{
    public function supports($format)
    {
        return $format === 'yml';
    }

    public function read(\SplFileInfo $file)
    {
        $captureList = new CaptureList();

        $yaml = Yaml::parse(file_get_contents($file->getPathname()));

        if (!is_array($yaml['list'])) {
            return $captureList;
        }

        foreach ($yaml['list'] as $item) {
            $captureList->addItem(new CaptureItem($item['name'], $item['url']));
        }

        return $captureList;
    }
}
