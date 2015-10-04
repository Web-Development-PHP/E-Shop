<?php

namespace EShop\Exceptions;

class NotFoundException extends \Exception
{
    protected $message = '404 Not Found';
    protected $file;
    protected $line;
    private   $trace;

    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return $this->message;
    }
}