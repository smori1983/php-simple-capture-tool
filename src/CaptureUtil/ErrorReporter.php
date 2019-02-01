<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Symfony\Component\Console\Output\OutputInterface;

class ErrorReporter
{
    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\ErrorItem[]
     */
    private $errors = [];

    /**
     * @param \Momo\SimpleCaptureTool\CaptureUtil\CaptureItem $item
     * @param \Exception                                      $exception
     */
    public function add(CaptureItem $item, \Exception $exception)
    {
        $this->errors[] = new ErrorItem($item, $exception);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function report(OutputInterface $output)
    {
        if (count($this->errors) === 0) {
            return;
        }

        $this->writeHeader($output);
        $this->writeDetails($output);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function writeHeader(OutputInterface $output)
    {
        $header = (count($this->errors) > 1) ? 'Failed Items' : 'Failed Item';

        $output->writeln(sprintf('%s (name, url, error type):', $header));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function writeDetails(OutputInterface $output)
    {
        foreach ($this->errors as $error) {
            $output->writeln(sprintf(
                '%s, %s, %s',
                $error->getName(),
                $error->getUrl(),
                get_class($error->getException())
            ));
        }
    }
}
