<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 04.10.2015
 * Time: 00:20
 */

namespace EShop\Exceptions;


class UnauthorizedException extends \Exception
{
    protected $message = 'Unauthorized';
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