# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Run all tests
vendor/bin/phpunit

# Run a single test file
vendor/bin/phpunit tests/OpenFigiTest.php

# Run a single test method
vendor/bin/phpunit --filter testMapping

# Static analysis (level: max)
vendor/bin/phpstan analyse

# Code style check
vendor/bin/phpcs

# Code style fix
vendor/bin/phpcbf
```

## Architecture

This is a PHP 8.3 library (`marekskopal/openfigi`) for the OpenFIGI API. The entry point is `OpenFigi` which composes a `Client` for HTTP communication.

**Request flow**: `OpenFigi::mapping(MappingJob[])` → `Client::post('/v3/mapping', ...)` → returns `FigiResult[][]`

### Key classes

- **`OpenFigi`** — public API; `mapping()` calls `/v3/mapping`, `getMaxJobsPerRequest()` returns 10 (no key) or 100 (with key)
- **`Client`** — PSR-18 HTTP client wrapper; handles 429 with configurable retry (default: 6 retries, 10s wait)
- **`Config`** — holds `apiKey`, `tooManyRequestsRepeat`, `tooManyRequestsWaitTime`
- **`MappingJob`** — request DTO; implements `JsonSerializable`, filters null values on serialize
- **`FigiResult`** — response DTO; constructed via `FigiResult::fromArray()`
- **`IdTypeEnum`** — string enum of 25 identifier types (ISIN, CUSIP, TICKER, etc.)
- **`ApiException`** — abstract base; `ApiException::fromCode(int)` maps HTTP status to concrete exception

### Conventions

- All classes are `readonly`
- PHPStan runs at `max` level with bleeding-edge rules — keep it passing
- Namespace: `MarekSkopal\OpenFigi\` → `src/`, tests: `MarekSkopal\OpenFigi\Tests\` → `tests/`
- PHPUnit requires `#[CoversClass]` and `#[UsesClass]` attributes on test classes
