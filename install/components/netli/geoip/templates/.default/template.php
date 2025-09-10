<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var  $arResult
 * @var  $APPLICATION

 */
?>

<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="geoip-form">
    <h2 class="geoip-form__title">🌍 GeoIP Поиск</h2>

    <form action="" onsubmit="getInfoIp(this); return false" method="POST">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" name="geoip_search" value="Y">

        <div class="geoip-form__group">
            <label class="geoip-form__label" for="ipAddress">IP адрес:</label>
            <input
                type="text"
                id="ipAddress"
                name="ip"
                class="geoip-form__input"
                placeholder="Введите IP адрес (например: 8.8.8.8)"
                value="212.118.42.58"
                required
            >
        </div>
        <button type="submit" class="geoip-form__button">
            Найти геолокацию
        </button>
    </form>

    <div class="geoip-form__result hidden">
        <h3 class="geoip-form__result-title">Результат поиска</h3>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label">IP адрес:</span>
            <span class="geoip-form__result-value" id="ip"></span>
        </div>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label">Страна:</span>
            <span class="geoip-form__result-value" id="country"></span>
        </div>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label">Город:</span>
            <span class="geoip-form__result-value" id="city"></span>
        </div>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label">Регион:</span>
            <span class="geoip-form__result-value" id="region"></span>
        </div>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label" id="">Координаты:</span>
            <span class="geoip-form__result-value">
            <span  id="latitude">,
            <span  id="longitude">
            </span>

        </span>
        </div>
        <div class="geoip-form__result-item">
            <span class="geoip-form__result-label">Источник:</span>
            <span id="provider" class="geoip-form__result-value"></span>
        </div>
    </div>
</div>








