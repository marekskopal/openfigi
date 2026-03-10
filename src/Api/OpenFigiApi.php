<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Api;

use MarekSkopal\OpenFigi\Client\ClientInterface;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;

/** @phpstan-import-type FigiResultType from FigiResult */
readonly class OpenFigiApi
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * @param list<MappingJob> $mappingJobs
     * @return list<list<FigiResult>|null>
     */
    public function mapping(array $mappingJobs): array
    {
        /**
         * @var list<
         *     array{
         *         data?: list<FigiResultType>,
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
