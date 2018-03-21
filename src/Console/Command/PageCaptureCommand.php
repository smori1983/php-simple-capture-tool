<?php
namespace Momo\Selenium\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class PageCaptureCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('page:capture')
            ->setDescription('')
            ->setDefinition([]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
