<?php

namespace Momo\Selenium\CaptureUtil\ListReader;

use Momo\Selenium\CaptureUtil\CaptureItem;
use Momo\Selenium\CaptureUtil\CaptureList;
use Momo\Selenium\CaptureUtil\ListReaderInterface;
use Symfony\Component\Yaml\Yaml;

class YamlReader implements ListReaderInterface
{
    public function supports($format)
    {
        return 'yml' === $format;
    }

    public function read($filePath)
    {
        $captureList = new CaptureList();

        $yaml = Yaml::parse(file_get_contents($filePath));

        foreach ($yaml['list'] as $item) {
            $captureList->addItem(new CaptureItem(
                $item['name'],
                $item['url']
            ));
        }

        return $captureList;
    }
}
