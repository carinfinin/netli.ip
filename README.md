## 📦 Установка

1 склонировать в /local/modules
2 установить модуль
3 Вызвать компонент
<?$APPLICATION->IncludeComponent(
    "netli:geoip",
    "",
    Array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A"
    )
);?>
