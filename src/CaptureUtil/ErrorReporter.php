<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Symfony\Component\Console\Output\OutputInterface;

class ErrorReporter
{
    /**
     * @var ErrorItem[]
     */
    private $errors = [];

    /**
     * @param ErrorItem $item
     */
    public function add(ErrorItem $item)
    {
        $this->errors[] = $item;
    }

    /**
     * @param OutputInterface $output
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
     * @param OutputInterface $output
     */
    private function writeHeader(OutputInterface $output)
    {
        $output->writeln(sprintf(
            '%s (name, url, error type):',
            count($this->errors) > 1 ? 'Failed Items' : 'Failed Item'
        ));
    }

    /**
     * @param OutputInterface $output
     */
    private function writeDetails(OutputInterface $output)
    {
        foreach ($this->errors as $error) {
            $this->writeDetail($output, $error);
        }
    }

    /**
     * @param OutputInterface $output
     * @param ErrorItem       $item
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
