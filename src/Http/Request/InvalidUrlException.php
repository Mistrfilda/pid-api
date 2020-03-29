<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Http\Request;

use Exception;
use Throwable;

class InvalidUrlException extends Exception
{
    /** @var string */
    private $url;

    public function __construct(string $url, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
