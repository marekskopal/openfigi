<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Tests\Api;

use MarekSkopal\OpenFigi\Api\OpenFigiApi;
use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Dto\FilterResult;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Dto\MappingJobResult;
use MarekSkopal\OpenFigi\Dto\SearchResult;
use MarekSkopal\OpenFigi\Enum\IdTypeEnum;
use MarekSkopal\OpenFigi\Enum\MappingValuesKeyEnum;
use MarekSkopal\OpenFigi\OpenFigi;
use MarekSkopal\OpenFigi\Tests\Fixtures\Client\ClientFixture;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OpenFigiApi::class)]
#[UsesClass(OpenFigi::class)]
#[UsesClass(Client::class)]
#[UsesClass(FigiResult::class)]
#[UsesClass(MappingJob::class)]
#[UsesClass(MappingJobResult::class)]
#[UsesClass(SearchResult::class)]
#[UsesClass(FilterResult::class)]
#[UsesClass(ClientFixture::class)]
final class OpenFigiApiTest extends TestCase
{
    public function testMapping(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingResponse.json'));

        $mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');

        $mapping = $openFigiApi->mapping([$mappingJob]);

        self::assertIsArray($mapping);
        self::assertArrayHasKey(0, $mapping);
        self::assertInstanceOf(MappingJobResult::class, $mapping[0]);
        self::assertIsArray($mapping[0]->data);
        self::assertInstanceOf(FigiResult::class, $mapping[0]->data[0]);
    }

    public function testMappingNotFound(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingNotFoundResponse.json'));

        $mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: '2WDCF');

        $mapping = $openFigiApi->mapping([$mappingJob]);

        self::assertIsArray($mapping);
        self::assertArrayHasKey(0, $mapping);
        self::assertInstanceOf(MappingJobResult::class, $mapping[0]);
        self::assertNull($mapping[0]->data);
        self::assertIsString($mapping[0]->warning);
    }

    public function testMappingMultiple(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingMultipleResponse.json'));

        $mappingJob1 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');
        $mappingJob2 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: '2WDCF');

        $mappingResults = $openFigiApi->mapping([$mappingJob1, $mappingJob2]);

        self::assertIsArray($mappingResults);
        self::assertArrayHasKey(0, $mappingResults);
        self::assertInstanceOf(MappingJobResult::class, $mappingResults[0]);
        self::assertIsArray($mappingResults[0]->data);
        self::assertInstanceOf(FigiResult::class, $mappingResults[0]->data[0]);
        self::assertInstanceOf(MappingJobResult::class, $mappingResults[1]);
        self::assertNull($mappingResults[1]->data);
        self::assertIsString($mappingResults[1]->warning);
    }

    public function testValues(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingValuesResponse.json'));

        $values = $openFigiApi->values(MappingValuesKeyEnum::IdType);

        self::assertIsArray($values);
        self::assertNotEmpty($values);
        self::assertContainsOnlyString($values);
    }

    public function testSearch(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('searchResponse.json'));

        $result = $openFigiApi->search(query: 'Apple');

        self::assertInstanceOf(SearchResult::class, $result);
        self::assertIsArray($result->data);
        self::assertNotEmpty($result->data);
        self::assertInstanceOf(FigiResult::class, $result->data[0]);
    }

    public function testFilter(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('filterResponse.json'));

        $result = $openFigiApi->filter(query: 'Apple');

        self::assertInstanceOf(FilterResult::class, $result);
        self::assertIsArray($result->data);
        self::assertNotEmpty($result->data);
        self::assertInstanceOf(FigiResult::class, $result->data[0]);
        self::assertIsFloat($result->total);
    }

    public function testGetMaxJobsPerRequest(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingResponse.json'));

        self::assertSame(10, $openFigiApi->getMaxJobsPerRequest());
    }
}
