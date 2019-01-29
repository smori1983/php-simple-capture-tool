<?php

namespace Momo\SimpleCaptureTool\Browser;

class ChromeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\Browser\Chrome
     */
    private $SUT = null;

    public function setUp()
    {
        $this->SUT = new Chrome();
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
            ['chrome', true],
            ['chrome-headless', false],
            ['phantomjs', false],

            ['Chrome', false],
            ['CHROME', false],
        ];
    }
}
