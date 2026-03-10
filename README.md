# OpenFIGI API client library for PHP

Unofficial PHP API client library for the [OpenFIGI](https://www.openfigi.com/) API service.


## Install

```sh
composer require marekskopal/openfigi
```

## Usage

```php
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Enum\IdTypeEnum;
use MarekSkopal\OpenFigi\OpenFigi;

// Create OpenFigi instance
$openFigi = new OpenFigi(new Config(apiKey: '<yourApiKey>'));

// Map a single ticker to FIGI
$mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');
$mappingResults = $openFigi->mapping([$mappingJob]);

// Search for securities
$searchResult = $openFigi->search(query: 'Apple');

// Filter securities
$filterResult = $openFigi->filter(exchCode: 'US', securityType: 'Common Stock');

// Get allowed values for a mapping key
$values = $openFigi->values(MappingValuesKeyEnum::ExchCode);
```

## Covered endpoints

* Mapping ✅
* Search ✅
* Filter ✅
* Values ✅

## Notice
This is NOT an official OpenFIGI library, and the authors of this library are not affiliated with OpenFIGI or Bloomberg Finance L.P. in any way, shape or form.

## Contributing
If you want to contribute, feel free to submit a pull request.
