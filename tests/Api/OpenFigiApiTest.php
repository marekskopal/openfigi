<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Tests\Api;

use MarekSkopal\OpenFigi\Api\OpenFigiApi;
use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Enum\IdTypeEnum;
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
        self::assertIsArray($mapping[0]);
        self::assertArrayHasKey(0, $mapping[0]);
        self::assertInstanceOf(FigiResult::class, $mapping[0][0]);
    }

    public function testMappingNotFound(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingNotFoundResponse.json'));

        $mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: '2WDCF');

        $mapping = $openFigiApi->mapping([$mappingJob]);

        self::assertIsArray($mapping);
        self::assertArrayHasKey(0, $mapping);
        self::assertNull($mapping[0]);
    }

    public function testMappingMultiple(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingMultipleResponse.json'));

        $mappingJob1 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');
        $mappingJob2 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: '2WDCF');

        $mappingResults = $openFigiApi->mapping([$mappingJob1, $mappingJob2]);

        self::assertIsArray($mappingResults);
        self::assertArrayHasKey(0, $mappingResults);
        self::assertIsArray($mappingResults[0]);
        self::assertArrayHasKey(0, $mappingResults[0]);
        self::assertInstanceOf(FigiResult::class, $mappingResults[0][0]);
        self::assertNull($mappingResults[1]);
    }

    public function testGetMaxJobsPerRequest(): void
    {
        $openFigiApi = new OpenFigiApi(ClientFixture::createWithResponse('mappingResponse.json'));

        self::assertSame(10, $openFigiApi->getMaxJobsPerRequest());
    }
}
