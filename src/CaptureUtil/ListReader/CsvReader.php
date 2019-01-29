<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use League\Csv\Reader;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureItem;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureList;
use Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface;

class CsvReader implements ListReaderInterface
{
    /**
     * structure: [encoding] => [acceptable or not].
     *
     * @var array
     */
    protected $encodings = [
        'ASCII' => true,
        'EUC-JP' => false,
        'SJIS-win' => true,
        'UTF-8' => true,
    ];

    public function supports($format)
    {
        return $format === 'csv';
    }

    public function read($filePath)
    {
        $content = $this->prepareCsvContent($filePath);

        $reader = Reader::createFromString($content);

        $captureList = new CaptureList();

        foreach ($reader->setOffset(1)->fetchAssoc(['name', 'url']) as $item) {
            $captureList->addItem(new CaptureItem(
                $item['name'],
                $item['url']
            ));
        }

        return $captureList;
    }

    /**
     * @param string $filePath
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    private function prepareCsvContent($filePath)
    {
        $content = file_get_contents($filePath);

        $contentEncoding = mb_detect_encoding(
            $content,
            array_keys($this->encodings)
        );

        if (!in_array($contentEncoding, $this->acceptableEncodings(), true)) {
            throw new \RuntimeException(sprintf(
                'Unknown encoding of file: %s, only %s acceptable',
                $filePath,
                implode(',', $this->acceptableEncodings())
            ));
        }

        return mb_convert_encoding($content, 'UTF-8', $contentEncoding);
    }

    /**
     * @return string[]
     */
    private function acceptableEncodings()
    {
        return array_keys(array_filter($this->encodings, function ($value) {
            return $value === true;
        }));
    }
}
