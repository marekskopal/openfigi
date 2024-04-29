# OpenFIGI API client library for PHP

Unofficial PHP API client library for the [OpenFIGI](https://www.openfigi.com/) API service. 


## Install

```sh
composer require marekskopal/openfigi
```

## Usage

```php
use MarekSkopal\OpenFigi\OpenFigi;
use MarekSkopal\OpenFigi\Enum\IntervalEnum;

// Create OpenFIGI instance
$openFigi = new OpenFigi('<yourApiKey>');

// Get the mapping for the AAPL ticker
$mappingJob = new MappingJob(idType: IdTypeEnum::Ticker, idValue: 'AAPL');

$mappingResults = $openFigi->mapping([$mappingJob]));
```

## Notice
This is NOT an official OpenFIGI library, and the authors of this library are not affiliated with OpenFIGI or Bloomberg Finance L.P. in any way, shape or form.

## Contributing
If you want to contribute, feel free to submit a pull request.