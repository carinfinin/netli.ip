<?php
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    Bitrix\Main\ModuleManager,
    Bitrix\Main\Config\Option,
    Bitrix\Highloadblock as HL;

class Netli_Ip extends CModule {
    public  $MODULE_ID;
    public  $MODULE_VERSION;
    public  $MODULE_VERSION_DATE;
    public  $MODULE_NAME;
    public  $MODULE_DESCRIPTION;
    public  $PARTNER_NAME;
    public  $PARTNER_URI;
    public  $errors;


    /**
     * Returns array of table names and their corresponding filename prefixes
     * @return array
     */
    protected function getDB()
    {
        return array(
            'netli_ip_address' => 'IpAddress',
        );
    }
    public function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_ID = "netli.ip";
        $this->MODULE_NAME = "netli.ip";
        $this->MODULE_DESCRIPTION = "Тестовое задание";
        $this->PARTNER_NAME = "netli";
        $this->PARTNER_URI = "https://netli.ru";
    }

    public function DoInstall()
    {
        ModuleManager::RegisterModule($this->MODULE_ID);
        $this->InstallFiles();
        $this->InstallDb();
        return true;
    }
    public function DoUninstall()
    {
        $this->UnInstallDb();
        $this->UnInstallFiles();
        Option::delete($this->MODULE_ID);
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
    }
    public function InstallFiles()
    {
        CopyDirFiles(
            __DIR__ . "/components",
            $_SERVER["DOCUMENT_ROOT"] . "/local/components",
            true,
            true
        );
        return true;
    }
    public function UnInstallFiles()
    {
        if (is_dir($_SERVER["DOCUMENT_ROOT"] . "/local/components/ibs")) {
            DeleteDirFilesEx(
                "/local/components/ibs"
            );
        }
        return true;
    }
    public function InstallDB()
    {
        global $DB, $APPLICATION;

        $this->errors = false;

        // Создание HL-блока
        if (!$this->CreateHLBlock()) {
            $APPLICATION->ThrowException(Loc::getMessage('YOUR_COMPANY_GEOIP_HLBLOCK_CREATE_ERROR'));
            return false;
        }

        return true;
    }

    public function UnInstallDB()
    {
        global $DB, $APPLICATION;
        $this->DeleteHLBlock();

        return true;
    }

    public function InstallEvents() { return true; }
    public function UnInstallEvents() { return true; }

    private function CreateHLBlock()
    {
        if (!Loader::IncludeModule('highloadblock')) {
            return false;
        }

        $hlblock = HL\HighloadBlockTable::getList([
            'filter' => ['=NAME' => 'GeoIpData']
        ])->fetch();

        if ($hlblock) {
            return true;
        }

        // Создаем HL-блок
        $result = HL\HighloadBlockTable::add([
            'NAME' => 'GeoIpData',
            'TABLE_NAME' => 'geo_ip_data',
        ]);

        if (!$result->isSuccess()) {
            return false;
        }

        $hlblockId = $result->getId();

        $this->CreateHLFields($hlblockId);

        return true;
    }

    private function CreateHLFields($hlblockId)
    {
        if (!Loader::IncludeModule('highloadblock')) {
            return false;
        }

        $userTypeEntity = new CUserTypeEntity();

        $fields = [
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_IP',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'IP',
                'SORT' => 100,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'Y',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_COUNTRY',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'COUNTRY',
                'SORT' => 200,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_CITY',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'CITY',
                'SORT' => 300,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_REGION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'REGION',
                'SORT' => 400,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_LATITUDE',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'LATITUDE',
                'SORT' => 500,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_LONGITUDE',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'LONGITUDE',
                'SORT' => 600,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_PROVIDER',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'PROVIDER',
                'SORT' => 700,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
                'FIELD_NAME' => 'UF_DATE_CREATE',
                'USER_TYPE_ID' => 'datetime',
                'XML_ID' => 'DATE_CREATE',
                'SORT' => 800,
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'Y',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ]
        ];

        foreach ($fields as $field) {
            $userTypeEntity->Add($field);
        }

        return true;
    }

    private function DeleteHLBlock()
    {
        if (!CModule::IncludeModule('highloadblock')) {
            return false;
        }

        $hlblock = HL\HighloadBlockTable::getList([
            'filter' => ['=NAME' => 'GeoIpData']
        ])->fetch();

        if ($hlblock) {
            HL\HighloadBlockTable::delete($hlblock['ID']);
        }

        return true;
    }
}