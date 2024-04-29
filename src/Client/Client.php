<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MarekSkopal\OpenFigi\Config\Config;
use MarekSkopal\OpenFigi\Dto\MappingJob;
use MarekSkopal\OpenFigi\Exception\ApiException;
use MarekSkopal\OpenFigi\Exception\TooManyRequestsException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Client
{
    private const BaseUri = 'https://api.openfigi.com';

    private readonly ClientInterface $httpClient;

    private readonly RequestFactoryInterface $requestFactory;

    private readonly StreamFactoryInterface $streamFactory;

    public function __construct(private readonly Config $config)
    {
        $this->httpClient = Psr18ClientDiscovery::find();
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }

    /** @param list<MappingJob> $data */
    public function post(string $path, array $data, int $retryCount = 0): string
    {
        $uri = self::BaseUri . $path;

        $request = $this->requestFactory->createRequest('POST', $uri);

        $request = $this->addHeaders($request);

        $request = $request->withBody($this->streamFactory->createStream((string) json_encode($data)));

        $response = $this->httpClient->sendRequest($request);

        try {
            return $this->getContents($response);
        } catch (TooManyRequestsException $e) {
            if (
                $this->config->tooManyRequestsRepeat <= 0
                || $this->config->tooManyRequestsWaitTime <= 0
                || $retryCount >= $this->config->tooManyRequestsRepeat
            ) {
                throw $e;
            }

            sleep($this->config->tooManyRequestsWaitTime);

            return $this->post($path, $data, $retryCount + 1);
        }
    }

    private function getContents(ResponseInterface $response): string
    {
        if ($response->getStatusCode() !== 200) {
            throw ApiException::fromCode($response->getStatusCode());
        }

        return $response->getBody()->getContents();
    }

    private function addHeaders(RequestInterface $request): RequestInterface
    {
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('User-Agent', 'marekskopal/openfigi-client:1.0.0');

        if ($this->config->apiKey !== null) {
            $request = $request
                ->withHeader('X-OPENFIGI-APIKEY', $this->config->apiKey);
        }

        return $request;
    }
}
