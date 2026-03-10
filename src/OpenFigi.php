<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi;

use DateTimeInterface;
use MarekSkopal\OpenFigi\Api\OpenFigiApi;
use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\FilterResult;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Dto\SearchResult;
use MarekSkopal\OpenFigi\Enum\MappingValuesKeyEnum;

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

    /** @return list<string> */
    public function values(MappingValuesKeyEnum $key): array
    {
        return $this->api->values($key);
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
        return $this->api->search(
            $query, $start, $exchCode, $micCode, $currency, $marketSecDes,
            $securityType, $securityType2, $includeUnlistedEquities, $optionType,
            $strike, $contractSize, $coupon, $expiration, $maturity, $stateCode,
        );
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
        return $this->api->filter(
            $query, $start, $exchCode, $micCode, $currency, $marketSecDes,
            $securityType, $securityType2, $includeUnlistedEquities, $optionType,
            $strike, $contractSize, $coupon, $expiration, $maturity, $stateCode,
        );
    }

    public function getMaxJobsPerRequest(): int
    {
        return $this->client->getMaxJobsPerRequest();
    }
}
