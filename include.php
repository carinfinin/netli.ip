<?
Bitrix\Main\Loader::registerAutoloadClasses(
    "netli.ip",
    array(
        "Netli\\Lib\\Controller\\GeoIpDataController" => "lib/controller/GeoIpDataController.php",
        "Netli\\Lib\\Service\\GeoIpService" => "lib/service/GeoIpService.php",
        "Netli\\Lib\\Service\\GeoIpHLService" => "lib/service/GeoIpHLService.php",
        "Netli\\Lib\\Provider\\GeoIpProviderInterface" => "lib/provider/GeoIpProviderInterface.php",
        "Netli\\Lib\\Provider\\GeoIpTopProvider" => "lib/provider/GeoIpTopProvider.php",
        "Netli\\Lib\\Provider\\SypexGeoProvider" => "lib/provider/SypexGeoProvider.php",
        "Netli\\Lib\\Factory\\GeoIpProviderFactory" => "lib/factory/GeoIpProviderFactory.php",
    )
);
