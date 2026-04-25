<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Dto;

/** @phpstan-import-type FigiResultType from FigiResult */
readonly class FilterResult extends SearchResult
{
    /** @param list<FigiResult>|null $data */
    public function __construct(public ?float $total, ?array $data, ?string $error, ?string $next,)
    {
        parent::__construct($data, $error, $next);
    }

    /**
     * @param array{
     *     data?: list<FigiResultType>,
     *     error?: string,
     *     next?: string,
     *     total?: float,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            total: $data['total'] ?? null,
            data: isset($data['data']) ? array_map(
                fn (array $item): FigiResult => FigiResult::fromArray($item),
                $data['data'],
            ) : null,
            error: $data['error'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
