<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();



use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable;
#

CModule::IncludeModule('highloadblock');
$dbUser = \Bitrix\Main\UserTable::getList(array(
    'select' => array('ID', 'NAME','UF_*' ),
    'filter' => array($arResult['PERSON_TYPE']['1']['ID'])
))->fetch();
echo '<pre>';

$hlblock = HighloadBlockTable::getById(4)->fetch();
$entity = HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$rsData = $entity_data_class::getList(array(



    'filter' => array('ID' => $dbUser['UF_CHILD_ID'])
))->fetchAll();
echo '</pre>';
?>

<?
#STEP ONE GET BASKET ITEM
?>
<div id="bx-soa-order" class="row" >

<? if ($arParams['BASKET_POSITION'] === 'before'): ?>
    <!--	BASKET ITEMS BLOCK	-->
    <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span>
                Лагерь
            </div>

        </div>
        <div class="bx-soa-section-content">
            <h4 class="basket-item camp-name"><?=$arResult['BASKET_ITEMS'][0]['PREVIEW_TEXT']?></h4>
            <h5 class="basket-item shift-name"><?=$arResult['BASKET_ITEMS'][0]['NAME']?></h5>
            <div class="basket-item camp-pic"><img src="<?=$arResult['BASKET_ITEMS'][0]['PREVIEW_PICTURE_SRC_2X']?>"></div>
            <table class="basket-item camp-prop wrap">
                <?foreach ($arResult['BASKET_ITEMS'][0]['PROPS'] as $prop){?>
                    <tr class="basket-item camp-prop container">
                        <td class="basket-item camp-prop prop-name"><?=$prop['NAME']?>:</td>
                        <td class="basket-item camp-prop prop-value"><?=$prop['VALUE']?></td>

                    </tr>
                <?}?>
            </table>
            <div class="basket-item shift-price"><?=$arResult['BASKET_ITEMS'][0]['SUM_BASE_FORMATED']?> </div>

        </div>
    </div>
<? endif ?>

<?
#STEP TWO GET USER
?>
<div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">
    <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
        <div class="bx-soa-section-title" data-entity="section-title">
            <span class="bx-soa-section-title-count"></span>Родитель
        </div>

    </div>
    <div class="bx-soa-section-content">
        <div class="basket-item user status"><?=$dbUser['UF_STATUS_USER']?></div>
        <div class="basket-item user citizenship"><?=$dbUser['UF_CITIZENSHIP']?></div>
        <div class="basket-item user fio-parent"><?=$dbUser['UF_FIO_PARENT']?> </div>
        <div class="basket-item user date-born"><?=$dbUser['UF_DATE_BORN']->toString()?> </div>
        <div class="basket-item user type-document"><?=$dbUser['UF_TYPE_DOCUMENT']?> </div>
        <div class="basket-item user serial-pasport"><?=$dbUser['UF_SERIAL_PASPORT']?> </div>
        <div class="basket-item user number-pasport"><?=$dbUser['UF_NUMBER_PASPORT']?> </div>
        <div class="basket-item user date-out-pasport"><?=$dbUser['UF_DATE_OUT_PASPORT']?> </div>
        <div class="basket-item user out-by-pasport"><?=$dbUser['UF_OUT_BY']?> </div>
        <div class="basket-item user index"><?=$dbUser['UF_INDEX']?> </div>
        <div class="basket-item user country"><?=$dbUser['UF_COUNTRY']?> </div>
        <div class="basket-item user region"><?=$dbUser['UF_REGION']?> </div>
        <div class="basket-item user district"><?=$dbUser['UF_DISTRICT']?> </div>
        <div class="basket-item user city"><?=$dbUser['UF_CITY']?> </div>
        <div class="basket-item user build"><?=$dbUser['UF_BUILD']?> </div>
        <div class="basket-item user corpus"><?=$dbUser['UF_CORPUS']?> </div>
        <div class="basket-item user flat"><?=$dbUser['UF_FLAT']?> </div>
        <div class="basket-item user slils"><?=$dbUser['UF_SNILS']?> </div>
        <div class="basket-item user number-phone"><?=$dbUser['UF_NUMBER_PHONE']?> </div>



    </div>
</div>

<?
#STEP THREE GET CHILD
?>
    <div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span>Ребёнок
            </div>

        </div>
        <div class="select-child-wrap">
            <form>
            <?
            foreach ($dbUser['UF_CHILD_ID'] as $key=>$child){?>
                <input  class="child" name="child" type="radio" id="child-<?=$key?> " value="<?=$key?>" onclick="display(<?=$key?>)">
                <label for="child-<?=$key?>"><?=$rsData[$key]['UF_FIO_CHILD']?></label>
            <?}?>
            </form>

        </div>
        <?foreach ($dbUser['UF_CHILD_ID'] as $key=>$child){?>

        <table class="bx-soa-section-content child"  id="js-child-<?=$key?>">
            <tr class="basket-item child citizenship"><td>Гражданство: </td><td><?=$rsData[$key]['UF_CITIZENSHIP_CH']?></td></tr>
            <tr class="basket-item child fio"><td>ФИО: </td><td><?=$rsData[$key]['UF_FIO_CHILD']?> </td></tr>
            <tr class="basket-item child date-born"><td>Дата рождения: </td><td><?=$rsData[$key]['UF_DATE_BORN_CH']->toString()?></td> </tr>
            <tr class="basket-item child type-document"><td>Тип документа: </td><td><?=$rsData[$key]['UF_DOCUMENT_TYPE_CH']?> </td></tr>
            <tr class="basket-item child info-pasport"><td>Информация документа: </td><td><?=$rsData[$key]['UF_DOCUMENT_INFO']?> </td></tr>
            <tr class="basket-item child registration-pasport"><td>Место регистрации: </td><td><?=$rsData[$key]['UF_REGISTRATION_CHILD']?></td> </tr>
            <tr class="basket-item child fact-live"><td>Фактическое место проживания: </td><td><?=$rsData[$key]['UF_FACT_LIVE']?> </td></tr>
            <tr class="basket-item child snils"><td>СНИЛС: </td><td><?=$rsData[$key]['UF_SNILS_CHILD']?> </td></tr>
            <tr class="basket-item child number-phone"><td>Номер телефона: </td><td><?=$rsData[$key]['UF_NUMBER_PHONE_CHILD']?></td> </tr>
            <tr class="basket-item child number-phone"><td><a href="/personal/childs/">Редактировать карточку ребенка</a></td> <td></td> </tr>

        </table>
        <?}?>

    </div>
<?
#BUTN MAKE ORDER

?>
    <a>Оплатить заказ</a>
</div>