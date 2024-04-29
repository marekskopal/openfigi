<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Dto;

readonly class FigiResult
{
    public function __construct(
        public string $figi,
        public string $securityType,
        public string $marketSector,
        public string $ticker,
        public string $name,
        public string $exchCode,
        public string $shareClassFIGI,
        public string $compositeFIGI,
        public string $securityType2,
        public string $securityDescription,
    ) {
    }

    public static function fromJson(string $json): self
    {
        /**
         * @var array{
         *     figi: string,
         *     securityType: string,
         *     marketSector: string,
         *     ticker: string,
         *     name: string,
         *     exchCode: string,
         *     shareClassFIGI: string,
         *     compositeFIGI: string,
         *     securityType2: string,
         *     securityDescription: string,
         *  } $responseContents
         */
        $responseContents = json_decode($json, associative: true);

        return self::fromArray($responseContents);
    }

    /**
     * @param array{
     *     figi: string,
     *     securityType: string,
     *     marketSector: string,
     *     ticker: string,
     *     name: string,
     *     exchCode: string,
     *     shareClassFIGI: string,
     *     compositeFIGI: string,
     *     securityType2: string,
     *     securityDescription: string,
     *  } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            figi: $data['figi'],
            securityType: $data['securityType'],
            marketSector: $data['marketSector'],
            ticker: $data['ticker'],
            name: $data['name'],
            exchCode: $data['exchCode'],
            shareClassFIGI: $data['shareClassFIGI'],
            compositeFIGI: $data['compositeFIGI'],
            securityType2: $data['securityType2'],
            securityDescription: $data['securityDescription'],
        );
    }
}
