<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Tests;

use MarekSkopal\OpenFigi\Client\Client;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\FigiResult;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Enum\IdTypeEnum;
use MarekSkopal\OpenFigi\OpenFigi;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OpenFigi::class)]
#[UsesClass(Client::class)]
#[UsesClass(Config::class)]
#[UsesClass(FigiResult::class)]
#[UsesClass(MappingJob::class)]
class OpenFigiTest extends TestCase
{
    public function testMapping(): void
    {
        $openFigi = new OpenFigi(new Config());

        $mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');

        $this->assertInstanceOf(FigiResult::class, $openFigi->mapping([$mappingJob])[0][0]);

        $mappingJob1 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');
        $mappingJob2 = new MappingJob(idType: IdTypeEnum::Ticker, idValue: '2WDCF');

        $mappingResults = $openFigi->mapping([$mappingJob1, $mappingJob2]);

        $this->assertInstanceOf(FigiResult::class, $mappingResults[0][0]);
        $this->assertNull($mappingResults[1]);
    }

    public function testGetMaxJobsPerRequest(): void
    {
        $openFigi = new OpenFigi(new Config());

        $this->assertEquals(10, $openFigi->getMaxJobsPerRequest());

        $openFigi = new OpenFigi(new Config('abc'));

        $this->assertEquals(100, $openFigi->getMaxJobsPerRequest());
    }
}
