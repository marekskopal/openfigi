<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Config;

readonly class Config
{
    public function __construct(
        public ?string $apiKey = null,
        public int $tooManyRequestsRepeat = 6,
        public int $tooManyRequestsWaitTime = 10,
    )
    {
    }
}
