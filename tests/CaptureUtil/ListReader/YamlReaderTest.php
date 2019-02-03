<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use Vfs\FileSystem;

class YamlReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\ListReader\YamlReader
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
        $this->SUT = new YamlReader();
        $this->vfs = FileSystem::factory($this->vfsProtocol);
        $this->vfs->mount();

        $this->captureListPath = sprintf(
            '%s://list.yaml',
            $this->vfsProtocol
        );
    }

    public function tearDown()
    {
        $this->vfs->unmount();
    }

    public function testRead()
    {
        $content = <<<YAML
list:
    - name: site01
      url: https://site01.example.com/
    - name: site02
      url: https://site02.example.com/
YAML;

        file_put_contents($this->captureListPath, $content);

        $items = $this->SUT->read(new \SplFileInfo($this->captureListPath))->getItems();

        $this->assertSame('site01', $items[0]->getName());
        $this->assertSame('https://site01.example.com/', $items[0]->getUrl());

        $this->assertSame('site02', $items[1]->getName());
        $this->assertSame('https://site02.example.com/', $items[1]->getUrl());
    }
}
