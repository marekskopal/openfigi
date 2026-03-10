<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi;

use MarekSkopal\OpenFigi\Api\OpenFigiApi;
use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;

readonly class OpenFigi
{
    private Client $client;

    public OpenFigiApi $api;

    public function __construct(Config $config)
    {
        $this->client = new Client($config);
        $this->api = new OpenFigiApi($this->client);
    }

    /**
     * @param list<MappingJob> $mappingJobs
     * @return list<list<FigiResult>|null>
     */
    public function mapping(array $mappingJobs): array
    {
        return $this->api->mapping($mappingJobs);
    }

    public function getMaxJobsPerRequest(): int
    {
        return $this->client->getMaxJobsPerRequest();
    }
}
