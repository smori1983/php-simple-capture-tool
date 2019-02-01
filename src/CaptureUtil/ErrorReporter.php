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
        $output->writeln(sprintf(
            '%s (name, url, error type):',
            count($this->errors) > 1 ? 'Failed Items' : 'Failed Item'
        ));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function writeDetails(OutputInterface $output)
    {
        foreach ($this->errors as $error) {
            $this->writeDetail($output, $error);
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Momo\SimpleCaptureTool\CaptureUtil\ErrorItem     $item
     */
    private function writeDetail(OutputInterface $output, ErrorItem $item)
    {
        $output->writeln(sprintf(
            '%s, %s, %s',
            $item->getName(),
            $item->getUrl(),
            get_class($item->getException())
        ));
    }
}
