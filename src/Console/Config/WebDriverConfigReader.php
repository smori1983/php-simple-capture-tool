<?php

namespace Momo\SimpleCaptureTool\Console\Config;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class WebDriverConfigReader
{
    /**
     * @var Symfony\Component\Config\Definition\Processor
     */
    protected $processor = null;

    public function __construct()
    {
        $this->processor = new Processor();
    }

    /**
     * @param string $configFilePath
     *
     * @return array
     * @throw RuntimeException
     */
    public function read($configFilePath)
    {
        if (!is_file($configFilePath)) {
            throw new \RuntimeException(sprintf(
                'WebDriver config yaml not found: %s',
                $configFilePath
            ));
        }

        $yml = Yaml::parse(file_get_contents($configFilePath));

        return $this->processor->processConfiguration(new WebDriverConfiguration(), [$yml]);
    }
}
