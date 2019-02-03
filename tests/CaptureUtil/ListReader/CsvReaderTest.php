<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use Vfs\FileSystem;

class CsvReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\ListReader\CsvReader
     */
    private $SUT = null;

    /**
     * @var \Vfs\FileSystem
     */
    private $vfs = null;

    /**
     * @var string
     */
    private $vfsProtocol = 'phpunit';

    /**
     * @var string
     */
    private $captureListPath = null;

    public function setUp()
    {
        $this->SUT = new CsvReader();

        $this->vfs = FileSystem::factory($this->vfsProtocol);
        $this->vfs->mount();

        $this->captureListPath = sprintf(
            '%s://list.csv',
            $this->vfsProtocol
        );
    }

    public function tearDown()
    {
        $this->vfs->unmount();
    }

    /**
     * @dataProvider dataForReadAcceptableEncodingFile
     *
     * @param string $encoding
     */
    public function testReadAcceptableFile($encoding)
    {
        $content = <<<CSV
name,url
サイトFoo,http://foo.example.com/
サイトBar,http://bar.example.com/
CSV;

        file_put_contents(
            $this->captureListPath,
            mb_convert_encoding($content, $encoding, 'UTF-8')
        );

        $items = $this->SUT->read(new \SplFileInfo($this->captureListPath))->getItems();

        $this->assertSame('サイトFoo', $items[0]->getName());
        $this->assertSame('http://foo.example.com/', $items[0]->getUrl());

        $this->assertSame('サイトBar', $items[1]->getName());
        $this->assertSame('http://bar.example.com/', $items[1]->getUrl());
    }

    public function dataForReadAcceptableEncodingFile()
    {
        return [
            ['SJIS-win'],
            ['UTF-8'],
        ];
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnknownFileEncoding()
    {
        $this->markTestSkipped();

        $content = <<<CSV
name,url
サイトFoo,http://foo.example.com/
サイトBar,http://bar.example.com/
CSV;

        file_put_contents(
            $this->captureListPath,
            mb_convert_encoding($content, 'EUC-JP')
        );

        $this->SUT->read(new \SplFileInfo($this->captureListPath));
    }
}
