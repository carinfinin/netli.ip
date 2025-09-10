<?php
namespace Netli\Lib\Provider;

use Psr\Http\Client\ClientInterface;
use Bitrix\Main\Web\Uri;
use Bitrix\Main\Web\Http\Request;
use Bitrix\Main\Web\Http\Method;

class GeoIpTopProvider implements GeoIpProviderInterface
{
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getGeoData(string $ip): array
    {

        $url = "https://geoip.top/api/v1/" . urlencode($ip);
        $uri = new Uri($url);
        $request = new Request(Method::POST, $uri);
        try {
            $response = $this->httpClient->sendRequest($request);
            if ($response->getStatusCode() !== 200) {
                throw new \RuntimeException('SypexGeo API unavailable');
            }
        }
        catch (ClientException $e) {
            var_dump($e->getMessage());
        }


        $data = json_decode((string)$response->getBody(), true);


        return [
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'region' => $data['region'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'provider' => 'geoip.top'
        ];
    }

    public function getName(): string
    {
        return 'geoip_top';
    }
}