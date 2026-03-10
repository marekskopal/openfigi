<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Api;

use DateTimeInterface;
use MarekSkopal\OpenFigi\Client\ClientInterface;
use MarekSkopal\OpenFigi\Dto\FilterResult;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Dto\SearchResult;
use MarekSkopal\OpenFigi\Enum\MappingValuesKeyEnum;

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

    /** @return list<string> */
    public function values(MappingValuesKeyEnum $key): array
    {
        /** @var array{values: list<string>} $responseContent */
        $responseContent = json_decode(
            $this->client->get(path: '/v3/mapping/values/' . $key->value),
            associative: true,
        );

        return $responseContent['values'];
    }

    /**
     * @param array{0: float|null, 1: float|null}|null $strike
     * @param array{0: float|null, 1: float|null}|null $contractSize
     * @param array{0: float|null, 1: float|null}|null $coupon
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $expiration
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $maturity
     */
    public function search(
        ?string $query = null,
        ?string $start = null,
        ?string $exchCode = null,
        ?string $micCode = null,
        ?string $currency = null,
        ?string $marketSecDes = null,
        ?string $securityType = null,
        ?string $securityType2 = null,
        ?bool $includeUnlistedEquities = null,
        ?string $optionType = null,
        ?array $strike = null,
        ?array $contractSize = null,
        ?array $coupon = null,
        ?array $expiration = null,
        ?array $maturity = null,
        ?string $stateCode = null,
    ): SearchResult {
        /**
         * @var array{
         *     data?: list<FigiResultType>,
         *     error?: string,
         *     next?: string,
         * } $responseContent
         */
        $responseContent = json_decode(
            $this->client->post(path: '/v3/search', data: $this->buildSearchBody(
                $query, $start, $exchCode, $micCode, $currency, $marketSecDes,
                $securityType, $securityType2, $includeUnlistedEquities, $optionType,
                $strike, $contractSize, $coupon, $expiration, $maturity, $stateCode,
            )),
            associative: true,
        );

        return SearchResult::fromArray($responseContent);
    }

    /**
     * @param array{0: float|null, 1: float|null}|null $strike
     * @param array{0: float|null, 1: float|null}|null $contractSize
     * @param array{0: float|null, 1: float|null}|null $coupon
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $expiration
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $maturity
     */
    public function filter(
        ?string $query = null,
        ?string $start = null,
        ?string $exchCode = null,
        ?string $micCode = null,
        ?string $currency = null,
        ?string $marketSecDes = null,
        ?string $securityType = null,
        ?string $securityType2 = null,
        ?bool $includeUnlistedEquities = null,
        ?string $optionType = null,
        ?array $strike = null,
        ?array $contractSize = null,
        ?array $coupon = null,
        ?array $expiration = null,
        ?array $maturity = null,
        ?string $stateCode = null,
    ): FilterResult {
        /**
         * @var array{
         *     data?: list<FigiResultType>,
         *     error?: string,
         *     next?: string,
         *     total?: float,
         * } $responseContent
         */
        $responseContent = json_decode(
            $this->client->post(path: '/v3/filter', data: $this->buildSearchBody(
                $query, $start, $exchCode, $micCode, $currency, $marketSecDes,
                $securityType, $securityType2, $includeUnlistedEquities, $optionType,
                $strike, $contractSize, $coupon, $expiration, $maturity, $stateCode,
            )),
            associative: true,
        );

        return FilterResult::fromArray($responseContent);
    }

    /**
     * @param array{0: float|null, 1: float|null}|null $strike
     * @param array{0: float|null, 1: float|null}|null $contractSize
     * @param array{0: float|null, 1: float|null}|null $coupon
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $expiration
     * @param array{0: DateTimeInterface|null, 1: DateTimeInterface|null}|null $maturity
     * @return array<string, mixed>
     */
    private function buildSearchBody(
        ?string $query,
        ?string $start,
        ?string $exchCode,
        ?string $micCode,
        ?string $currency,
        ?string $marketSecDes,
        ?string $securityType,
        ?string $securityType2,
        ?bool $includeUnlistedEquities,
        ?string $optionType,
        ?array $strike,
        ?array $contractSize,
        ?array $coupon,
        ?array $expiration,
        ?array $maturity,
        ?string $stateCode,
    ): array {
        return array_filter([
            'query' => $query,
            'start' => $start,
            'exchCode' => $exchCode,
            'micCode' => $micCode,
            'currency' => $currency,
            'marketSecDes' => $marketSecDes,
            'securityType' => $securityType,
            'securityType2' => $securityType2,
            'includeUnlistedEquities' => $includeUnlistedEquities,
            'optionType' => $optionType,
            'strike' => $strike,
            'contractSize' => $contractSize,
            'coupon' => $coupon,
            'expiration' => $expiration !== null ? array_map(
                fn (DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $expiration,
            ) : null,
            'maturity' => $maturity !== null ? array_map(
                fn (DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $maturity,
            ) : null,
            'stateCode' => $stateCode,
        ], fn (mixed $value): bool => $value !== null);
    }

    public function getMaxJobsPerRequest(): int
    {
        return $this->client->getMaxJobsPerRequest();
    }
}
