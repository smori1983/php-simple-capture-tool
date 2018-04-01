<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Symfony\Component\Console\Output\OutputInterface;

class ErrorReporter
{
    private $errors = [];

    public function add(CaptureItem $item, \Exception $exception)
    {
        $this->errors[] = [
            'item' => $item,
            'exception' => $exception,
        ];
    }

    public function report(OutputInterface $output)
    {
        if (count($this->errors) === 0) {
            return;
        }

        $title = (count($this->errors) > 1) ? 'Failed Items' : 'Failed Item';

        $output->writeln(sprintf('%s (name, url, error type):', $title));

        foreach ($this->errors as $error) {
            $output->writeln(sprintf(
                '%s, %s, %s',
                $error['item']->getName(),
                $error['item']->getUrl(),
                get_class($error['exception'])
            ));
        }
    }
}
