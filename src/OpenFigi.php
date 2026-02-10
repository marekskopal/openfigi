<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi;

use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;

readonly class OpenFigi
{
    private Client $client;

    public function __construct(Config $config)
    {
        $this->client = new Client($config);
    }

    /**
     * @param list<MappingJob> $mappingJobs
     * @return list<list<FigiResult>|null>
     */
    public function mapping(array $mappingJobs,): array
    {
        /**
         * @var list<
         *     array{
         *         data?: list<array{
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
         *         warning?: string
         *     }
         *  > $responseContents
         */
        $responseContents = json_decode($this->client->post(path: '/v3/mapping', data: $mappingJobs), associative: true);

        $mappingResults = [];

        foreach ($responseContents as $responseContent) {
            if (!isset($responseContent['data'])) {
                $mappingResults[] = null;
                continue;
            }

            $mappingResults[] = array_map(
                fn (array $item): FigiResult => FigiResult::fromArray($item),
                $responseContent['data'],
            );
        }

        return $mappingResults;
    }

    public function getMaxJobsPerRequest(): int
    {
        return $this->client->getMaxJobsPerRequest();
    }
}
