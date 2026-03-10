<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Client;

use MarekSkopal\OpenFigi\Dto\MappingJob;

interface ClientInterface
{
    public function get(string $path): string;

    /** @param list<MappingJob>|array<string, mixed> $data */
    public function post(string $path, array $data): string;

    public function getMaxJobsPerRequest(): int;
}
