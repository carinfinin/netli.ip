<?php
namespace Netli\Lib\Provider;

use Bitrix\Main\Web\Uri;
use Psr\Http\Client\ClientInterface;
use Bitrix\Main\Web\Http\Request;
use Bitrix\Main\Web\Http\Method;
use function Bitrix\Conversion\AdminHelpers\renderFilter;

class SypexGeoProvider implements GeoIpProviderInterface
{
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getGeoData(string $ip): array
    {
        $url = "https://api.sypexgeo.net/json/" . urlencode($ip);

        $uri = new Uri($url);
        $request = new Request(Method::GET, $uri);

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
            'country' => $data['country']['name_ru'] ?? null,
            'city' => $data['city']['name_ru'] ?? null,
            'region' => $data['region']['name_ru'] ?? null,
            'latitude' => $data['city']['lat'] ?? null,
            'longitude' => $data['city']['lon'] ?? null,
            'provider' => 'sypexgeo'
        ];
    }

    public function getName(): string
    {
        return 'sypexgeo';
    }
}