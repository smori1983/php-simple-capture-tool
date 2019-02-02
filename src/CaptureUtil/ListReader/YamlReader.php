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

    public function read($filePath)
    {
        $captureList = new CaptureList();

        $yaml = Yaml::parse(file_get_contents($filePath));

        foreach ($yaml['list'] as $item) {
            $captureList->addItem(new CaptureItem($item['name'], $item['url']));
        }

        return $captureList;
    }
}
