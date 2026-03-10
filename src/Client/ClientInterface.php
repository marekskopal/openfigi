<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Client;

use MarekSkopal\OpenFigi\Dto\MappingJob;

interface ClientInterface
{
    /** @param list<MappingJob> $data */
    public function post(string $path, array $data): string;

    public function getMaxJobsPerRequest(): int;
}
