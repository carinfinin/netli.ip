<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\SystemException,
    Bitrix\Main\Loader;

class GeoIpComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('netli.ip'))
            throw new SystemException(Loc::getMessage('MODULE_NOT_INSTALLED'));
    }

    public function onPrepareComponentParams($arParams)
    {
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 3600;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        return $arParams;
    }


    protected function getResult()
    {

//        if ($this->startResultCache(false, [$_REQUEST, $this->arParams])) {



        $this->IncludeComponentTemplate();


//            if (!empty($this->arResult)) {
//                $this->SetResultCacheKeys(
//                    array()
//                );
//                $this->IncludeComponentTemplate();
//            } else {
//                $this->AbortResultCache();
//                \Bitrix\Iblock\Component\Tools::process404(
//                    "Секция не найдена",
//                    true,
//                    true
//                );
//            }
//        }
    }
}