<?php
namespace Netli\Lib\Factory;

use Netli\Lib\Provider\GeoIpProviderInterface;
use Netli\Lib\Provider\SypexGeoProvider;
use Netli\Lib\Provider\GeoIpTopProvider;
use Psr\Http\Client\ClientInterface;

class GeoIpProviderFactory
{
    private $httpClient;

    public function __construct(ClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }

    public function createProvider(string $providerName): GeoIpProviderInterface
    {
        switch ($providerName) {
            case 'sypexgeo':
                return new SypexGeoProvider($this->httpClient);
            case 'geoip_top':
                return new GeoIpTopProvider($this->httpClient);
            default:
                throw new \Exception("Unknown provider: $providerName");
        }
    }

    public function createAllProviders(): array
    {
        return [
            $this->createProvider('sypexgeo'),
            $this->createProvider('geoip_top')
        ];
    }
}