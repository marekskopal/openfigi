<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Dto;

use DateTimeInterface;
use JsonSerializable;
use MarekSkopal\OpenFigi\Enum\IdTypeEnum;

readonly class MappingJob implements JsonSerializable
{
    /**
     * @param array<DateTimeInterface|null>|null $strike
     * @param array<DateTimeInterface|null>|null $contractSize
     * @param array<DateTimeInterface|null>|null $coupon
     * @param array<DateTimeInterface|null>|null $expiration
     * @param array<DateTimeInterface|null>|null $maturity
     */
    public function __construct(
        public IdTypeEnum $idType,
        public string $idValue,
        public ?string $exchCode = null,
        public ?string $micCode = null,
        public ?string $currency = null,
        public ?string $marketSecDes = null,
        public ?string $securityType = null,
        public ?string $securityType2 = null,
        public ?bool $includeUnlistedEquities = null,
        public ?string $optionType = null,
        public ?array $strike = null,
        public ?array $contractSize = null,
        public ?array $coupon = null,
        public ?array $expiration = null,
        public ?array $maturity = null,
        public ?string $stateCode = null,
    ) {
    }

    /**
     * @return array{
     *     idType: value-of<IdTypeEnum>,
     *     idValue: string,
     *     exchCode?: ?string,
     *     micCode?: string,
     *     currency?: string,
     *     marketSecDes?: string,
     *     securityType?: string,
     *     securityType2?: string,
     *     includeUnlistedEquities?: bool,
     *     optionType?: string,
     *     strike?: array<string|null>,
     *     contractSize?: array<string|null>,
     *     coupon?: array<string|null>,
     *     expiration?: array<string|null>,
     *     maturity?: array<string|null>,
     *     stateCode?: string
     * }
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'idType' => $this->idType->value,
            'idValue' => $this->idValue,
            'exchCode' => $this->exchCode,
            'micCode' => $this->micCode,
            'currency' => $this->currency,
            'marketSecDes' => $this->marketSecDes,
            'securityType' => $this->securityType,
            'securityType2' => $this->securityType2,
            'includeUnlistedEquities' => $this->includeUnlistedEquities,
            'optionType' => $this->optionType,
            'strike' => $this->strike !== null ? array_map(
                fn(DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $this->strike,
            ) : null,
            'contractSize' => $this->contractSize !== null ? array_map(
                fn(DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $this->contractSize,
            ) : null,
            'coupon' => $this->coupon !== null ? array_map(
                fn(DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $this->coupon,
            ) : null,
            'expiration' => $this->expiration !== null ? array_map(
                fn(DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $this->expiration,
            ) : null,
            'maturity' => $this->maturity !== null ? array_map(
                fn(DateTimeInterface|null $item): ?string => $item?->format('Y-m-d'),
                $this->maturity,
            ) : null,
            'stateCode' => $this->stateCode,
        ], fn($value): bool => $value !== null);
    }
}
