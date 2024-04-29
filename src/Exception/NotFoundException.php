<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Exception;

class NotFoundException extends ApiException
{
    public function __construct(string $message = '', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
