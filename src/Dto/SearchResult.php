<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Dto;

/** @phpstan-import-type FigiResultType from FigiResult */
readonly class SearchResult
{
    /**
     * @param list<FigiResult>|null $data
     */
    public function __construct(
        public ?array $data,
        public ?string $error,
        public ?string $next,
    ) {
    }

    /**
     * @param array{
     *     data?: list<FigiResultType>,
     *     error?: string,
     *     next?: string,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            data: isset($data['data']) ? array_map(
                fn (array $item): FigiResult => FigiResult::fromArray($item),
                $data['data'],
            ) : null,
            error: $data['error'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
