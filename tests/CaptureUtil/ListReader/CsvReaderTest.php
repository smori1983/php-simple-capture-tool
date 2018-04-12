<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use Vfs\FileSystem;

class CsvReaderTest extends \PHPUnit_Framework_TestCase
{
    private $SUT = null;

    private $vfs = null;

    private $vfsProtocol = 'phpunit';

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
     * @expectedException RuntimeException
     */
    public function testUnknownFileEncoding()
    {
        $content = <<<CSV
name,url
サイトFoo,http://foo.example.com/
サイトBar,http://bar.example.com/
CSV;

        file_put_contents(
            $this->captureListPath,
            mb_convert_encoding($content, 'EUC-JP')
        );

        $this->SUT->read($this->captureListPath);
    }
}
