<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 01.10.2015
 * Time: 23:27
 */

namespace EShop\Exceptions;


class InvalidUserInputException extends \Exception
{
    protected $message = 'Invalid input data';
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