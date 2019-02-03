<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Vfs\FileSystem;

class CaptureListFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CaptureListFactory
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
        $this->SUT = new CaptureListFactory();

        $this->vfs = FileSystem::factory($this->vfsProtocol);
        $this->vfs->mount();
    }

    public function tearDown()
    {
        $this->vfs->unmount();
    }

    /**
     * @dataProvider dataForCreate
     *
     * @param string $fileName
     */
    public function testCreate($fileName)
    {
        $this->captureListPath = sprintf(
            '%s://%s',
            $this->vfsProtocol,
            $fileName
        );

        file_put_contents($this->captureListPath, '');

        $captureList = $this->SUT->create($this->captureListPath);

        $this->assertCount(0, $captureList->getItems());
    }

    public function dataForCreate()
    {
        return [
            ['list.csv'],
            ['list.yml'],
            ['list.yaml'],
        ];
    }
}
