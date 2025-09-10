<?php
namespace Netli\Lib\Provider;

interface GeoIpProviderInterface
{
    public function getGeoData(string $ip): array;

}