<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Exception;

class ErrorItem
{
    /**
     * @var CaptureItem
     */
    private $item;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param CaptureItem $item
     * @param Exception   $exception
     */
    public function __construct(CaptureItem $item, Exception $exception)
    {
        $this->item = $item;
        $this->exception = $exception;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->item->getName();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->item->getUrl();
    }

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
