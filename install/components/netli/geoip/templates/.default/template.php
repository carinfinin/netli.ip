<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var  $arResult
 * @var  $APPLICATION

 */
?>

<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="geoip-form">
    <h2 class="geoip-form__title">🌍 GeoIP Поиск</h2>

    <form action="<?= $APPLICATION->GetCurPage() ?>" method="POST">
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
                value="<?= htmlspecialcharsbx($_POST['ip'] ?? '') ?>"
                required
            >
            <?php if (!empty($arResult['ERROR'])): ?>
                <div class="geoip-form__error"><?= htmlspecialcharsbx($arResult['ERROR']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="geoip-form__button">
            Найти геолокацию
        </button>
    </form>

    <?php if (!empty($arResult['GEO_DATA'])): ?>
        <div class="geoip-form__result">
            <h3 class="geoip-form__result-title">Результат поиска</h3>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">IP адрес:</span>
                <span class="geoip-form__result-value"><?= htmlspecialcharsbx($arResult['GEO_DATA']['IP']) ?></span>
            </div>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">Страна:</span>
                <span class="geoip-form__result-value"><?= htmlspecialcharsbx($arResult['GEO_DATA']['COUNTRY']) ?></span>
            </div>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">Город:</span>
                <span class="geoip-form__result-value"><?= htmlspecialcharsbx($arResult['GEO_DATA']['CITY']) ?></span>
            </div>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">Регион:</span>
                <span class="geoip-form__result-value"><?= htmlspecialcharsbx($arResult['GEO_DATA']['REGION']) ?></span>
            </div>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">Координаты:</span>
                <span class="geoip-form__result-value">
                <?= htmlspecialcharsbx($arResult['GEO_DATA']['LATITUDE']) ?>,
                <?= htmlspecialcharsbx($arResult['GEO_DATA']['LONGITUDE']) ?>
            </span>
            </div>
            <div class="geoip-form__result-item">
                <span class="geoip-form__result-label">Источник:</span>
                <span class="geoip-form__result-value"><?= htmlspecialcharsbx($arResult['GEO_DATA']['PROVIDER']) ?></span>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .geoip-form {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        color: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .geoip-form__title {
        text-align: center;
        margin-bottom: 25px;
        font-size: 28px;
        font-weight: 300;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .geoip-form__group {
        margin-bottom: 20px;
    }

    .geoip-form__label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 16px;
    }

    .geoip-form__input {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .geoip-form__input:focus {
        outline: none;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.2), 0 0 0 3px rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .geoip-form__input.error {
        border: 2px solid #ff4757;
        background: rgba(255, 71, 87, 0.1);
    }

    .geoip-form__button {
        width: 100%;
        padding: 16px;
        background: linear-gradient(45deg, #ff6b6b, #ee5a52);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .geoip-form__button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(45deg, #ee5a52, #ff6b6b);
    }

    .geoip-form__button:active {
        transform: translateY(-1px);
    }

    .geoip-form__button:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
    }

    .geoip-form__error {
        color: #ff4757;
        font-size: 14px;
        margin-top: 8px;
        display: none;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 4px solid #ff4757;
    }

    .geoip-form__loading {
        display: none;
        text-align: center;
        margin-top: 20px;
    }

    .geoip-form__spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .geoip-form__result {
        margin-top: 25px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        border-left: 4px solid #2ecc71;
        display: none;
    }

    .geoip-form__result-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #2ecc71;
    }

    .geoip-form__result-item {
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
    }

    .geoip-form__result-label {
        font-weight: 500;
        opacity: 0.9;
    }

    .geoip-form__result-value {
        font-weight: 600;
    }

    @media (max-width: 600px) {
        .geoip-form {
            margin: 20px;
            padding: 20px;
        }

        .geoip-form__title {
            font-size: 24px;
        }
    }
</style>


<script>
    function request () {
        return new Promise((resolve) => {
            var request = BX.ajax.runAction('netli:ip.api.netli.getGeoIp', {
                data: {}
            });
            request.then(function(response){
                if(response.status == "success") {
                    resolve(response.data)
                }else {
                    resolve(false)
                }
            }).catch((err) => {
                console.error(err)
                resolve(false)
            })
        })
    }

</script>