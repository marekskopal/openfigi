<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Dto;

/** @phpstan-import-type FigiResultType from FigiResult */
readonly class MappingJobResult
{
    /** @param list<FigiResult>|null $data */
    public function __construct(public ?array $data, public ?string $warning,)
    {
    }

    /**
     * @param array{
     *     data?: list<FigiResultType>,
     *     warning?: string,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            data: isset($data['data']) ? array_map(
                fn (array $item): FigiResult => FigiResult::fromArray($item),
                $data['data'],
            ) : null,
            warning: $data['warning'] ?? null,
        );
    }
}
