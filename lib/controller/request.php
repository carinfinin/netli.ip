<?php
namespace SMenu\Lib\Controller;
use Bitrix\Main\Engine\Controller;
use SMenu\Lib\Helper;
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request;

class GeoIp extends Controller
{

    public static $categoryHL = 9;
    public static $itemHL = 10;
    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'getGeoIp' => [
                'prefilters' => []
            ],

        ];
    }

    public static function getGeoIp($hlblockID, $itemID)
    {
        $helper = new Helper();
        return [
            'item' => $helper->getItemHL($hlblockID,  $itemID),
        ];
    }

}