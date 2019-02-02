<?php

namespace Momo\SimpleCaptureTool\Browser;

class PhantomjsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\Browser\Phantomjs
     */
    private $SUT = null;

    public function setUp()
    {
        $this->SUT = new Phantomjs();
    }

    /**
     * @dataProvider dataForSupports
     *
     * @param string $browserType
     * @param string $result
     */
    public function testSupports($browserType, $result)
    {
        $this->assertSame($result, $this->SUT->supports($browserType));
    }

    public function dataForSupports()
    {
        return [
            ['chrome', false],
            ['chrome-headless', false],
            ['phantomjs', true],

            ['Phantomjs', false],
            ['PhantomJS', false],
        ];
    }
}
