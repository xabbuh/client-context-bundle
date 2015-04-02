<?php

namespace Openroot\Bundle\ClientContextBundle\Exceptions;

/**
 * Class ClientContextException
 *
 * @package Openroot\Bundle\ClientContextBundle\Exceptions
 */
class ClientContextException extends \Exception
{
    /**
     * @return static
     */
    public static function noContext()
    {
        return new static("Can't determine client as there is no HTTP-context available yet.");
    }

    /**
     * @return static
     */
    public static function noClient()
    {
        return new static("Can't find client for the current HTTP-context.");
    }
}
