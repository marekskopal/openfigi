<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Exception;

class TooManyRequestsException extends ApiException
{
    public function __construct(string $message = '', int $code = 429)
    {
        parent::__construct($message, $code);
    }
}
