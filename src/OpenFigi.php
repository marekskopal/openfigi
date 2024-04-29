<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi;

use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;

class OpenFigi
{
    private readonly Client $client;

    public function __construct(Config $config)
    {
        $this->client = new Client($config);
    }

    /**
     * @param list<MappingJob> $mappingJobs
     * @return list<list<FigiResult>>
     */
    public function mapping(array $mappingJobs,): array
    {
        /**
         * @var array{
         *     0: array{
         *         data: list<array{
         *             figi: string,
         *             securityType: string,
         *             marketSector: string,
         *             ticker: string,
         *             name: string,
         *             exchCode: string,
         *             shareClassFIGI: string,
         *             compositeFIGI: string,
         *             securityType2: string,
         *             securityDescription: string,
         *         }>,
         *     }
         *  } $mappingResults
         */
        $mappingResults = json_decode($this->client->post(path: '/v3/mapping', data: $mappingJobs), associative: true);

        return array_map(
            fn(array $mappingResult): array => array_map(
                fn (array $item): FigiResult => FigiResult::fromArray($item),
                $mappingResult['data'],
            ),
            $mappingResults,
        );
    }

    public function getMaxJobsPerRequest(): int
    {
        return $this->client->getMaxJobsPerRequest();
    }
}
