<?php
namespace Netli\Lib\Service;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity;
\Bitrix\Main\Loader::includeModule('highloadblock');
class GeoIpHLService
{
    private $dataClass;
    // Проверяем, существует ли уже запись с таким IP
    private $hlName = 'GeoIpData';

    public function __construct()
    {
        $this->dataClass = $this->getDataClass();
    }

    public function getByIp(string $ip): ?array
    {
        if (!$this->dataClass) {
            return null;
        }

        $date = $this->dataClass::getList([
            'filter' => ['=UF_IP' => $ip],
            'limit' => 1
        ])->fetch();

        if($date) {
            return [
                'ip' => $date['UF_IP'],
                'country' => $date['UF_COUNTRY'],
                'city' => $date['UF_CITY'],
                'region' => $date['UF_REGION'],
                'latitude' => $date['UF_LATITUDE'],
                'longitude' => $date['UF_LONGITUDE'],
                'provider' => $date['UF_PROVIDER'],
            ];
        }
        return null;
    }

    public function save(array $geoData): bool
    {
        if (!$this->dataClass) {
            return false;
        }
        $result = $this->dataClass::add([
            'UF_IP' => $geoData['ip'],
            'UF_COUNTRY' => $geoData['country'],
            'UF_CITY' => $geoData['city'],
            'UF_REGION' => $geoData['region'],
            'UF_LATITUDE' => $geoData['latitude'],
            'UF_LONGITUDE' => $geoData['longitude'],
            'UF_PROVIDER' => $geoData['provider'],
            'UF_DATE_CREATE' => new \Bitrix\Main\Type\DateTime()
        ]);
        return $result->isSuccess();
    }

    private function getDataClass(): ?string
    {
        $hlblock = HighloadBlockTable::getList([
            'filter' => ['=NAME' => $this->hlName],
            'limit' => 1
        ])->fetch();

        if (!$hlblock) {
            return null;
        }
        $entity = HighloadBlockTable::compileEntity($hlblock);
        return $entity->getDataClass();
    }

}