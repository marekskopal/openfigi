<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Tests\Fixtures\Client;

use MarekSkopal\OpenFigi\Client\ClientInterface;
use MarekSkopal\OpenFigi\Dto\MappingJob;

final class ClientFixture implements ClientInterface
{
    public function __construct(private string $responseFilename)
    {
    }

    public static function createWithResponse(string $responseFilename): ClientInterface
    {
        return new self($responseFilename);
    }

    public function get(string $path): string
    {
        return $this->getResponse();
    }

    /** @param list<MappingJob>|array<string, mixed> $data */
    public function post(string $path, array $data): string
    {
        return $this->getResponse();
    }

    public function getMaxJobsPerRequest(): int
    {
        return 10;
    }

    private function getResponse(): string
    {
        return (string) file_get_contents(__DIR__ . '/../Response/' . $this->responseFilename);
    }
}
