<?php

namespace Momo\SimpleCaptureTool\Browser;

class ChromeHeadlessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\Browser\ChromeHeadless
     */
    private $SUT = null;

    public function setUp()
    {
        $this->SUT = new ChromeHeadless();
    }

    /**
     * @dataProvider dataForSupports
     *
     * @param string $browserType
     * @param bool   $result
     */
    public function testSupports($browserType, $result)
    {
        $this->assertSame($result, $this->SUT->supports($browserType));
    }

    public function dataForSupports()
    {
        return [
            ['chrome', false],
            ['chrome-headless', true],
            ['phantomjs', false],

            ['chrome_headless', false],
            ['chromeheadless', false],
        ];
    }
}
