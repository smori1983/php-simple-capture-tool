<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Symfony\Component\Console\Output\BufferedOutput;

class ErrorReporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\ErrorReporter
     */
    private $SUT = null;

    /**
     * @var \Symfony\Component\Console\Output\BufferedOutput
     */
    private $output = null;

    public function setUp()
    {
        $this->SUT = new ErrorReporter();
        $this->output = new BufferedOutput();
    }

    public function testNoError()
    {
        $this->SUT->report($this->output);

        $this->assertSame('', $this->output->fetch());
    }

    public function testOneError()
    {
        $this->SUT->add(new CaptureItem('site01', 'http://site01.example.com/'), new \Exception());

        $this->SUT->report($this->output);

        $message = <<<EOL
Failed Item (name, url, error type):
site01, http://site01.example.com/, Exception
EOL;

        $this->assertSame(trim($message), trim($this->output->fetch()));
    }

    public function testTwoErrors()
    {
        $this->SUT->add(new CaptureItem('site01', 'http://site01.example.com/'), new \Exception());
        $this->SUT->add(new CaptureItem('site02', 'http://site02.example.com/'), new \Exception());

        $this->SUT->report($this->output);

        $message = <<<EOL
Failed Items (name, url, error type):
site01, http://site01.example.com/, Exception
site02, http://site02.example.com/, Exception
EOL;

        $this->assertSame(trim($message), trim($this->output->fetch()));
    }
}
